<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProposalAssessmentCriteria;
use App\Models\ProposalCriteria;
use App\Models\SeminarProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProposalAssessmentController extends Controller
{

    //


    public function updateEvaluation(Request $request, String $id)
    {
        dd($request->all());
        $seminarproposal = SeminarProposal::findOrFail($id);
        // Pastikan seminarProposal terkait dengan dosen yang login
        $assessment = $seminarproposal->proposalAssessments()->where('dosen_id', Auth::user()->id)->first();

        // Ambil semua kriteria yang terkait dengan seminar proposal ini
        $criterias = ProposalCriteria::all()->groupBy('type'); // Menyesuaikan dengan pembagian type 'material' dan 'presentation'

        // Ambil data assessment criterias yang ada
        $assessmentCriterias = $assessment->proposalAssessmentCriterias->keyBy('proposal_criteria_id');

        $totalCalculatedScore = 0; // Menyimpan total nilai akhir

        // Loop melalui semua kriteria yang diterima dari form
        foreach ($request->scores as $criteriaId => $score) {
            // Ambil kriteria terkait
            $criteria = ProposalCriteria::find($criteriaId);

            // Hitung nilai yang dihitung (calculated_score)
            $calculatedScore = $score * ($criteria->weight / 100);

            // Simpan nilai yang dihitung ke tabel proposal_assessment_criterias
            ProposalAssessmentCriteria::updateOrCreate(
                ['proposal_assessment_id' => $assessment->id, 'proposal_criteria_id' => $criteriaId],
                [
                    'score' => $score,
                    'calculated_score' => $calculatedScore
                ]
            );

            // Tambahkan ke total calculated score
            $totalCalculatedScore += $calculatedScore;
        }

        // Update nilai akhir pada proposal_assessments
        $assessment->update(['score' => $totalCalculatedScore]);

        // Redirect atau tampilkan pesan berhasil
        return redirect()->route('seminarproposals.index')->with('success', 'Assessment updated successfully!');
    }
}
