<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\ResultAssessment;
use App\Models\ResultAssessmentCriteria;
use App\Models\ResultCriteria;
use App\Models\ResultSeminarReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResultSeminarReviewController extends Controller
{
    //
    public function review(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'comment' => 'nullable|string',
            'review_id' => 'required|exists:result_seminar_reviews,id',
        ]);

        try {
            // Ambil review seminar
            $resultSeminarReview = ResultSeminarReview::findOrFail($validated['review_id']);
            $resultSeminarReview->update([
                'status' => $validated['status'],
                'comment' => $validated['comment'],
            ]);

            $resultSeminar = $resultSeminarReview->resultSeminar;
            $resultSeminarReviews = $resultSeminar->resultSeminarReviews;

            // Update status seminar
            $statuses = $resultSeminarReviews->pluck('status');
            if ($statuses->contains('rejected')) {
                $resultSeminar->update(['status' => 'rejected']);
            } elseif ($statuses->every(fn($status) => $status === 'approved')) {
                $proposalAssessments = $resultSeminar->mahasiswa->seminarProposal->proposalAssessments;

                foreach ($proposalAssessments as $proposalAssessment) {
                    $resultAssessments = [];

                    foreach (['material', 'presentation'] as $category) {
                        $weight = match ($category) {
                            'material' => in_array($proposalAssessment->type, ['pembimbing_1', 'pembimbing_2']) ? 30 : 20,
                            'presentation' => 25,
                            default => 0,
                        };

                        $type = $proposalAssessment->type;

                        if ($type === 'penguji') {
                            $type = 'penguji_1';
                        }

                        $resultAssessments[] = ResultAssessment::create([
                            'result_seminar_id' => $resultSeminar->id,
                            'dosen_id' => $proposalAssessment->dosen_id,
                            'type' => $type,
                            'category' => $category,
                            'weight' => $weight,
                        ]);
                    }

                    foreach ($resultAssessments as $resultAssessment) {
                        $resultCriterias = ResultCriteria::where('category', $resultAssessment->category)->get();
                        foreach ($resultCriterias as $resultCriteria) {
                            ResultAssessmentCriteria::create([
                                'result_criteria_id' => $resultCriteria->id,
                                'result_assessment_id' => $resultAssessment->id,
                                'score' => 0,
                                'calculated_score' => 0,
                            ]);
                        }
                    }
                }
                $resultSeminar->update(['status' => 'approved']);
            } else {
                $resultSeminar->update(['status' => 'pending']);
            }

            return redirect()->back()->with('success', 'Review berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
