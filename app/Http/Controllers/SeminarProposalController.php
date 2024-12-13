<?php

namespace App\Http\Controllers;

use App\Models\SeminarProposal;
use App\Models\SeminarProposalReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeminarProposalRequest;
use App\Http\Requests\UpdateSeminarProposalRequest;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\ProposalAssessment;
use App\Models\ProposalAssessmentCriteria;
use App\Models\ProposalCriteria;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SeminarProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == "dosen") {
            if (Auth::user()->dosen->role == "kaprodi") {
                $seminarProposals = SeminarProposal::where('status', 'approved')
                    ->whereHas('proposalAssessments', function ($query) {
                        $query->where('dosen_id', Auth::user()->dosen->id)
                            ->whereIn('type', ['pembimbing_1', 'pembimbing_2', 'penguji']);
                    })->get();

                return view("dashboard.dosen.seminarproposals.index", compact('seminarProposals'));
            }
        } else if (Auth::user()->role == "admin") {
            $seminarProposals = SeminarProposal::where('status', 'approved')->get();
            return view("dashboard.admin.seminarproposals.index", compact("seminarProposals"));
        } else {
            // Assuming this is for mahasiswa
            $seminarProposals = SeminarProposal::where('mahasiswa_id', Auth::user()->mahasiswa->id)->get();
            return view("dashboard.mahasiswa.seminarproposals.index", compact("seminarProposals"));
        }
    }

    public function delegate()
    {
        if (Auth::user()->dosen->role == "kaprodi") {
            $seminarProposals = SeminarProposal::where('status', 'approved')->get();
            return view("dashboard.dosen.seminarproposals.delegate", compact("seminarProposals"));
        } else {
            return redirect("dashboard")->with("error", "");
        }
    }

    public function evaluation(String $id)
    {
        $seminarproposal = SeminarProposal::findOrFail($id);
        $assessment = $seminarproposal->proposalAssessments()
            ->where('dosen_id', Auth::user()->dosen->id)
            ->first();

        $criterias = ProposalCriteria::all()
            ->groupBy('type');


        $assessmentCriterias = $assessment->proposalAssessmentCriterias()
            ->pluck('score', 'proposal_criteria_id')
            ->toArray();

        return view('dashboard.dosen.seminarproposals.evaluation', compact('seminarproposal', 'criterias', 'assessment', 'assessmentCriterias'));
    }

    public function updateEvaluation(Request $request, SeminarProposal $seminarproposal)
    {
        try {
            $request->validate([
                'scores.*' => 'required|numeric|min:0|max:100',
                'assessment_id' => 'required|exists:proposal_assessments,id'
            ]);

            $assessment = $seminarproposal->proposalAssessments()
                ->where('dosen_id', Auth::user()->dosen->id)
                ->firstOrFail();

            DB::beginTransaction();

            $totalCalculatedScore = 0;
            $totalWeight = 0;

            $criterias = ProposalCriteria::all();

            foreach ($request->scores as $criteriaId => $score) {
                $criteria = $criterias->find($criteriaId);

                if (!$criteria) {
                    throw new \Exception("Invalid criteria ID: {$criteriaId}");
                }

                $calculatedScore = $score * ($criteria->weight / 100);
                $totalWeight += $criteria->weight;

                ProposalAssessmentCriteria::updateOrCreate(
                    [
                        'proposal_assessment_id' => $assessment->id,
                        'proposal_criteria_id' => $criteriaId
                    ],
                    [
                        'score' => $score,
                        'calculated_score' => $calculatedScore
                    ]
                );

                $totalCalculatedScore += $calculatedScore;
            }

            if (abs($totalWeight - 100) > 0.01) {
                throw new \Exception("Total criteria weight must be 100%, current: {$totalWeight}%");
            }

            $assessment->update(['score' => $totalCalculatedScore]);

            $allAssessmentsComplete = $seminarproposal->proposalAssessments()
                ->whereNull('score')
                ->doesntExist();

            if ($allAssessmentsComplete) {
                $averageScore = $seminarproposal->proposalAssessments()->avg('score');
                $seminarproposal->numeric_grade = round($averageScore, 2);
                $seminarproposal->letter_grade = $this->convertToLetterGrade($averageScore);
                $seminarproposal->save();
            }

            DB::commit();

            return redirect()
                ->route('seminarproposals.index')
                ->with('success', 'Assessment has been updated successfully!');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation Error in updateEvaluation:', [
                'seminar_id' => $seminarproposal->id,
                'errors' => $e->errors()
            ]);
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in updateEvaluation:', [
                'seminar_id' => $seminarproposal->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->with('error', 'An error occurred while updating the assessment. Please try again.');
        }
    }

    /**
     * Convert numeric grade to letter grade.
     *
     * @param float $score
     * @return string
     */
    private function convertToLetterGrade(float $score): string
    {
        if ($score >= 85) {
            return 'A';
        } elseif ($score >= 70) {
            return 'B';
        } elseif ($score >= 55) {
            return 'C';
        } elseif ($score >= 40) {
            return 'D';
        } else {
            return 'E';
        }
    }


    public function request()
    {
        if (!Auth::user()->role == "dosen") {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        } else {

            $seminarProposals = SeminarProposal::where('status', 'pending')->whereHas('proposalAssessments', function ($query) {
                $query->where('dosen_id', Auth::user()->dosen->id);
            })->get();

            $seminarProposalReviews = SeminarProposalReview::where('dosen_id', Auth::user()->dosen->id)->get();
            return view("dashboard.dosen.seminarproposals.request", compact("seminarProposals", "seminarProposalReviews"));
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(SeminarProposal $seminarProposal)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeminarProposalRequest $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
        ]);

        try {
            $mahasiswa_id = $request->mahasiswa_id;

            $mahasiswa = Mahasiswa::with('superVisions')->find($mahasiswa_id);

            if (!$mahasiswa) {
                return redirect()->route('seminarproposals.index')->with('error', 'Mahasiswa tidak ditemukan.');
            }

            $dosens = $mahasiswa->superVisions->where('status', 'approved')->pluck('dosen');

            $existingProposal = SeminarProposal::where('mahasiswa_id', $mahasiswa_id)->first();

            if (!$existingProposal) {
                $seminar = SeminarProposal::create([
                    'mahasiswa_id' => $mahasiswa_id,
                    'status' => 'pending',
                ]);

                foreach ($dosens as $dosen) {
                    SeminarProposalReview::create([
                        'dosen_id' => $dosen->id,
                        'seminar_proposal_id' => $seminar->id,
                        'status' => 'pending',
                    ]);
                }

                return redirect()->route('seminarproposals.index')->with('success', 'Proposal Seminar berhasil diajukan.');
            } else {
                return redirect()->route('seminarproposals.index')->with('error', 'Anda sudah memiliki pengajuan seminar proposal.');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('seminarproposals.index')->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function getAvailableDosens(SeminarProposal $seminarproposal)
    {
        $usedDosenIds = $seminarproposal->proposalAssessments()
            ->whereIn('type', ['pembimbing_1', 'pembimbing_2'])
            ->pluck('dosen_id')
            ->toArray();

        $availableDosens = Dosen::whereNotIn('id', $usedDosenIds)
            ->with('user:id,name')
            ->get()
            ->map(function ($dosen) {
                return [
                    'id' => $dosen->id,
                    'name' => $dosen->user->name
                ];
            });

        $pengujiAssessment = $seminarproposal->proposalAssessments()
            ->where('type', 'penguji')
            ->first();

        return response()->json([
            'dosens' => $availableDosens,
            'selectedDosenId' => $pengujiAssessment ? $pengujiAssessment->dosen_id : null
        ]);
    }

    public function resubmission(StoreSeminarProposalRequest $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
        ]);

        try {
            $mahasiswa_id = $request->mahasiswa_id;

            $seminarProposal = SeminarProposal::where('mahasiswa_id', $mahasiswa_id)
                ->where('status', 'rejected')
                ->first();

            if ($seminarProposal) {
                $seminarProposal->status = 'pending';
                $seminarProposal->save();

                foreach ($seminarProposal->seminarProposalReviews as $review) {
                    $review->status = 'pending';
                    $review->comment = null;
                    $review->save();
                }

                return redirect()->route('seminarproposals.index')->with('success', 'Proposal Seminar berhasil diajukan ulang, dan status review diperbarui.');
            } else {
                return redirect()->route('seminarproposals.index')->with('error', 'Proposal Seminar tidak ditemukan atau tidak dapat diajukan ulang.');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('seminarproposals.index')->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(SeminarProposal $seminarProposal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(SeminarProposal $seminarproposal)
    {

        return view('dashboard.admin.seminarproposals.edit', compact('seminarproposal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeminarProposalRequest $request, SeminarProposal $seminarproposal)
    {
        $request->validated();

        try {
            // Update seminar proposal
            $seminarproposal->update([
                "date" => $request->date,
                "time" => $request->time,
                "location" => $request->location,
            ]);

            // Redirect kembali ke halaman daftar proposal seminar dengan pesan sukses
            return redirect()->route('seminarproposals.index')->with('success', 'Proposal Seminar berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('seminarproposals.edit', $seminarproposal)->with('error', "Terjadi kesalahan. Silakan coba lagi.");
        }
    }


    public function assignPenguji(Request $request, SeminarProposal $seminarproposal)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'dosen_id' => 'required|exists:dosens,id'
            ]);

            $existingAssessment = $seminarproposal->proposalAssessments()
                ->where('type', 'penguji')
                ->first();

            if ($existingAssessment) {
                if ($existingAssessment->dosen_id != $request->dosen_id) {
                    $existingAssessment->proposalAssessmentCriterias()->delete();
                    $existingAssessment->delete();
                    $proposalAssessment = ProposalAssessment::create([
                        "seminar_proposal_id" => $seminarproposal->id,
                        "dosen_id" => $request->dosen_id,
                        "type" => "penguji",
                    ]);
                    $this->createAssessmentCriteria($proposalAssessment);
                }
            } else {
                $proposalAssessment = ProposalAssessment::create([
                    "seminar_proposal_id" => $seminarproposal->id,
                    "dosen_id" => $request->dosen_id,
                    "type" => "penguji",
                ]);

                $this->createAssessmentCriteria($proposalAssessment);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Dosen penguji berhasil ditugaskan'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Helper function to create assessment criteria
    private function createAssessmentCriteria($proposalAssessment)
    {
        $criteria = ProposalCriteria::all();
        foreach ($criteria as $criterion) {
            ProposalAssessmentCriteria::create([
                'proposal_criteria_id' => $criterion->id,
                'proposal_assessment_id' => $proposalAssessment->id,
                'score' => 0,
                'calculated_score' => 0,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeminarProposal $seminarProposal)
    {
        //
    }

    public function exportBeritaAcara(SeminarProposal $seminarproposal)
    {
        $proposal = $seminarproposal->load([
            'mahasiswa',
            'proposalAssessments.dosen',
        ]);

        $letterGrade = $this->determineLetterGrade($seminarproposal->numeric_grade);

        // Data yang akan diteruskan ke view
        $data = [
            'proposal' => $proposal,
            'letterGrade' => $letterGrade,
        ];

        // Render view ke PDF
        $pdf = Pdf::loadView('dashboard.mahasiswa.seminarproposals.exportBeritaAcara', $data);

        // Unduh file PDF
        return $pdf->download('Berita_Acara_Seminar_Proposal.pdf');
    }



    private function determineLetterGrade($score)
    {
        if ($score >= 75) return 'A';
        if ($score >= 70) return 'AB';
        if ($score >= 65) return 'B';
        if ($score >= 60) return 'BC';
        if ($score >= 55) return 'C';
        if ($score >= 40) return 'D';
        return 'E';
    }
}
