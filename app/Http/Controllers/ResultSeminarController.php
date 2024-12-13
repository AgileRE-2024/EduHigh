<?php

namespace App\Http\Controllers;

use App\Models\ResultSeminar;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResultSeminarRequest;
use App\Http\Requests\UpdateResultSeminarRequest;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\ResultAssessment;
use App\Models\ResultAssessmentCriteria;
use App\Models\ResultCriteria;
use App\Models\ResultSeminarReview;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ResultSeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == "dosen") {
            $resultSeminars = ResultSeminar::where('status', 'approved')
                ->whereHas('resultAssessments', function ($query) {
                    $query->where('dosen_id', Auth::user()->dosen->id)
                        ->whereIn('type', ['pembimbing_1', 'pembimbing_2', 'penguji_1', 'penguji_2']);
                })->get();

            return view("dashboard.dosen.resultSeminars.index", compact('resultSeminars'));
        } else if (Auth::user()->role == "admin") {
            $resultSeminars = ResultSeminar::where('status', 'approved')->get();

            return view("dashboard.admin.resultSeminars.index", compact("resultSeminars"));
        } else {
            return view("dashboard.mahasiswa.resultSeminars.index");
        }
    }

    public function delegate()
    {
        $resultSeminars = ResultSeminar::where('status', 'approved')->get();

        return view("dashboard.dosen.resultSeminars.delegate", compact("resultSeminars"));
    }

    public function evaluation(String $id)
    {
        $resultSeminar = ResultSeminar::findOrFail($id);

        $materialAssessment = $resultSeminar->resultAssessments()
            ->where('dosen_id', Auth::user()->dosen->id)
            ->where('category', 'material')
            ->first();

        $presentationAssessment = $resultSeminar->resultAssessments()
            ->where('dosen_id', Auth::user()->dosen->id)
            ->where('category', 'presentation')
            ->first();


        return view('dashboard.dosen.resultSeminars.evaluation', compact(
            'resultSeminar',
            'materialAssessment',
            'presentationAssessment',
        ));
    }

    public function updateEvaluation(Request $request, ResultSeminar $resultSeminar)
    {
        DB::beginTransaction();

        try {
            // Validate request
            $request->validate([
                'material_result_assessment_id' => 'required|exists:result_assessments,id',
                'presentation_result_assessment_id' => 'required|exists:result_assessments,id',
                'materials' => 'required|array',
                'presentations' => 'required|array',
                'materials.*' => 'required|numeric|between:0,100',
                'presentations.*' => 'required|numeric|between:0,100',
            ]);

            // Retrieve assessments
            $materialAssessment = ResultAssessment::findOrFail($request->material_result_assessment_id);
            $presentationAssessment = ResultAssessment::findOrFail($request->presentation_result_assessment_id);

            if (
                $materialAssessment->is_submitted || $presentationAssessment->is_submitted
            ) {
                return back()->with('error', 'You have already submitted your evaluation.');
            }

            // Initialize scores
            $materialScore = 0;
            $presentationScore = 0;

            // Update material assessment criteria
            foreach ($request->materials as $id => $material) {
                $result = ResultAssessmentCriteria::findOrFail($id);
                $result->score = $material;
                $result->calculated_score = $material * $result->resultCriteria->weight / 100;
                $result->save();
                $materialScore += $result->calculated_score;
            }

            // Update material assessment
            $materialAssessment->score = $materialScore;
            $materialAssessment->calculated_score = $materialScore * $materialAssessment->weight / 100;
            $materialAssessment->is_submitted = true;
            $materialAssessment->save();

            // Update presentation assessment criteria
            foreach ($request->presentations as $id => $presentation) {
                $result = ResultAssessmentCriteria::findOrFail($id);
                $result->score = $presentation;
                $result->calculated_score = $presentation * $result->resultCriteria->weight / 100;
                $result->save();
                $presentationScore += $result->calculated_score;
            }

            // Update presentation assessment
            $presentationAssessment->score = $presentationScore;
            $presentationAssessment->calculated_score = $presentationScore * $presentationAssessment->weight / 100;
            $presentationAssessment->is_submitted = true;
            $presentationAssessment->save();

            // Update result seminar scores
            $materialScore = $resultSeminar->resultAssessments()
                ->where('category', 'material')
                ->sum('calculated_score');

            $presentationScore = $resultSeminar->resultAssessments()
                ->where('category', 'presentation')
                ->sum('calculated_score');

            $materialWeight = 0.60; // 60%
            $presentationWeight = 0.40; // 40%

            $finalScore = $materialScore * $materialWeight + $presentationScore * $presentationWeight;

            $letterGrade = match (true) {
                $finalScore >= 75 => 'A',
                $finalScore >= 70 => 'AB',
                $finalScore >= 65 => 'B',
                $finalScore >= 60 => 'BC',
                $finalScore >= 55 => 'C',
                $finalScore >= 40 => 'D',
                default => 'E',
            };

            $resultSeminar->material_score = $materialScore;
            $resultSeminar->presentation_score = $presentationScore;
            $resultSeminar->final_score = $finalScore;
            $resultSeminar->letter_grade = $letterGrade;
            $resultSeminar->save();

            DB::commit();

            return redirect()->route('resultSeminars.index')->with('success', 'Assessment updated successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Validation Error in updateEvaluation:', [
                'seminar_id' => $resultSeminar->id,
                'errors' => $e->errors()
            ]);
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in updateEvaluation:', [
                'seminar_id' => $resultSeminar->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()
                ->with('error', 'An error occurred while updating the assessment. Please try again.');
        }
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResultSeminarRequest $request)
    {
        //
        $request->validated();
        try {
            $mahasiswa_id = $request->mahasiswa_id;

            $mahasiswa = Mahasiswa::with('superVisions')->find($mahasiswa_id);

            if (!$mahasiswa) {
                return redirect()->route('resultSeminars.index')->with('error', 'Mahasiswa tidak ditemukan.');
            }

            $dosens = $mahasiswa->superVisions->where('status', 'approved')->pluck('dosen');

            $existingProposal = ResultSeminar::where('mahasiswa_id', $mahasiswa_id)->first();

            if (!$existingProposal) {
                $resultSeminar = ResultSeminar::create([
                    'mahasiswa_id' => $mahasiswa_id,
                    'status' => 'pending',
                ]);


                foreach ($dosens as $dosen) {
                    $result = ResultSeminarReview::create([
                        'dosen_id' => $dosen->id,
                        'result_seminar_id' => $resultSeminar->id,
                        'status' => 'pending',
                    ]);
                }


                return redirect()->route('resultSeminars.index')->with('success', 'Proposal Seminar berhasil diajukan.');
            } else {
                return redirect()->route('resultSeminars.index')->with('error', 'Anda sudah memiliki pengajuan seminar proposal.');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('resultSeminars.index')->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
    public function request()
    {
        if (!Auth::user()->role == "dosen") {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        } else {

            $resultSeminars = ResultSeminar::whereHas('resultAssessments', function ($query) {
                $query->where('dosen_id', Auth::user()->dosen->id);
            })->get();

            $resultSeminarReviews = ResultSeminarReview::where('dosen_id', Auth::user()->dosen->id)->get();
            return view("dashboard.dosen.resultSeminars.request", compact("resultSeminars", "resultSeminarReviews"));
        }
    }

    public function viewBeritaAcara()
    {

        $resultSeminar = ResultSeminar::find(1);

        $resultSeminar = $resultSeminar->load([
            'mahasiswa',
            'resultAssessments.dosen',
        ]);

        $letterGrade = $this->determineLetterGrade($resultSeminar->final_score);

        // Data yang akan diteruskan ke view
        $data = [
            'resultSeminar' => $resultSeminar,
            'letterGrade' => $letterGrade,
        ];

        // Render view ke PDF
        return view('dashboard.mahasiswa.resultSeminars.exportBeritaAcara', compact('resultSeminar', 'letterGrade'));
    }

    public function exportBeritaAcara(ResultSeminar $resultSeminar)
    {
        $resultSeminar = $resultSeminar->load([
            'mahasiswa',
            'resultAssessments.dosen',
        ]);

        $letterGrade = $this->determineLetterGrade($resultSeminar->final_score);

        // Data yang akan diteruskan ke view
        $data = [
            'resultSeminar' => $resultSeminar,
            'letterGrade' => $letterGrade,
        ];

        // Render view ke PDF
        $pdf = Pdf::loadView('dashboard.mahasiswa.resultSeminars.exportBeritaAcara', $data);

        // Unduh file PDF
        return $pdf->download('Berita_Acara_Seminar_Hasil.pdf');
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

    public function resubmission(StoreResultSeminarRequest $request)
    {
        $request->validated();

        try {
            $mahasiswa_id = $request->mahasiswa_id;

            $resultSeminar = ResultSeminar::where('mahasiswa_id', $mahasiswa_id)
                ->where('status', 'rejected')
                ->first();

            if ($resultSeminar) {
                $resultSeminar->status = 'pending';
                $resultSeminar->save();

                foreach ($resultSeminar->resultSeminarReviews as $review) {
                    $review->status = 'pending';
                    $review->comment = null;
                    $review->save();
                }

                return redirect()->route('resultSeminars.index')->with('success', 'Proposal Seminar berhasil diajukan ulang, dan status review diperbarui.');
            } else {
                return redirect()->route('resultSeminars.index')->with('error', 'Proposal Seminar tidak ditemukan atau tidak dapat diajukan ulang.');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('resultSeminars.index')->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ResultSeminar $resultSeminar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResultSeminar $resultSeminar)
    {
        //


        return view('dashboard.admin.resultSeminars.edit', compact('resultSeminar'));
    }

    public function getAvailableDosens(ResultSeminar $resultSeminar)
    {
        $usedDosenIds = $resultSeminar->resultAssessments()
            ->whereIn('type', ['pembimbing_1', 'pembimbing_2', 'penguji_1'])
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

        $pengujiAssessment = $resultSeminar->resultAssessments()->where('type', 'penguji_2')->first();
        $selectedDosenId = $pengujiAssessment ? $pengujiAssessment->dosen_id : null;

        return response()->json([
            'dosens' => $availableDosens,
            'selectedDosenId' => $selectedDosenId
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResultSeminarRequest $request, ResultSeminar $resultSeminar)
    {
        $request->validated();

        try {
            // Update seminar proposal
            $resultSeminar->update([
                "date" => $request->date,
                "time" => $request->time,
                "location" => $request->location,
            ]);

            return redirect()->route('resultSeminars.index')->with('success', 'Proposal Seminar berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('resultSeminars.edit', $resultSeminar)->with('error', "Terjadi kesalahan. Silakan coba lagi.");
        }
    }


    public function assignPenguji(Request $request, ResultSeminar $resultSeminar)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'dosen_id' => 'required|exists:dosens,id'
            ]);

            $assessmentTypes = ['material', 'presentation'];

            foreach ($assessmentTypes as $type) {
                $existingAssessment = $resultSeminar->resultAssessments()
                    ->where('type', 'penguji_2')
                    ->where('category', $type)
                    ->first();

                if ($existingAssessment) {
                    if ($existingAssessment->dosen_id != $request->dosen_id) {
                        $existingAssessment->resultAssessmentCriterias()->delete();
                        $existingAssessment->delete();

                        $resultAssessment = ResultAssessment::create([
                            "result_seminar_id" => $resultSeminar->id,
                            "dosen_id" => $request->dosen_id,
                            "type" => "penguji_2",
                            "category" => $type,
                        ]);

                        $this->createResultAssessmentCriteria($resultAssessment);
                    }
                } else {
                    $resultAssessment = ResultAssessment::create([
                        "result_seminar_id" => $resultSeminar->id,
                        "dosen_id" => $request->dosen_id,
                        "type" => "penguji_2",
                        "category" => $type,
                    ]);

                    $this->createResultAssessmentCriteria($resultAssessment);
                }
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
    private function createResultAssessmentCriteria($resultAssessment)
    {
        $criteria = ResultCriteria::all();
        foreach ($criteria as $criterion) {
            ResultAssessmentCriteria::create([
                'result_criteria_id' => $criterion->id,
                'result_assessment_id' => $resultAssessment->id,
                'score' => 0,
                'calculated_score' => 0,
            ]);
        }
    }

    /**
     * Membuat ResultAssessment dengan kategori material dan presentation.
     *
     * @param  ResultSeminar  $resultSeminar
     * @param  int  $dosenId
     * @param  string  $type
     * @return void
     */
    private function createResultAssessmentWithCategories(ResultSeminar $resultSeminar, $dosenId, $type)
    {
        foreach (['material', 'presentation'] as $category) {
            // Tentukan bobot berdasarkan kategori
            $weight = $category === 'material' ? 20 : 25;

            $resultAssessment = ResultAssessment::create([
                "result_seminar_id" => $resultSeminar->id,
                "dosen_id" => $dosenId,
                "type" => $type,
                "category" => $category,
                "weight" => $weight,
            ]);

            // Ambil semua criteria yang sesuai kategori
            $criterias = ResultCriteria::where('category', $category)->get();

            foreach ($criterias as $criterion) {
                ResultAssessmentCriteria::create([
                    'result_criteria_id' => $criterion->id,
                    'result_assessment_id' => $resultAssessment->id,
                    'score' => 0,
                    'calculated_score' => 0,
                ]);
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResultSeminar $resultSeminar)
    {
        //
    }
}
