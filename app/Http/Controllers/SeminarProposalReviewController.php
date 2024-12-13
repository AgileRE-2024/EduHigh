<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProposalAssessment;
use App\Models\ProposalAssessmentCriteria;
use App\Models\ProposalCriteria;
use App\Models\SeminarProposalReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SeminarProposalReviewController extends Controller
{
    //
    public function review(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'comment' => 'nullable|string',
            'review_id' => 'required|exists:seminar_proposal_reviews,id',
        ]);

        try {
            $review = SeminarProposalReview::findOrFail($validated['review_id']);
            $review->status = $validated['status'];
            $review->comment = $validated['comment'];
            $review->save();

            $seminarProposal = $review->seminarProposal;
            $reviews = $seminarProposal->seminarProposalReviews;

            $statuses = $reviews->pluck('status');
            if ($statuses->contains('rejected')) {
                $seminarProposal->status = 'rejected';
            } elseif ($statuses->every(fn($status) => $status === 'approved')) {
                $seminarProposal->status = 'approved';

                $criteria = ProposalCriteria::all();

                $supervisions = $seminarProposal->mahasiswa->superVisions;
                foreach ($supervisions as $supervision) {
                    $proposalAssessment = ProposalAssessment::create([
                        'seminar_proposal_id' => $seminarProposal->id,
                        'dosen_id' => $supervision->dosen_id,
                        'type' => $supervision->dosen_pembimbing,
                    ]);
                }
                foreach ($criteria as $criterion) {
                    ProposalAssessmentCriteria::create([
                        'proposal_criteria_id' => $criterion->id,
                        'proposal_assessment_id' => $proposalAssessment->id,
                        'score' => 0,
                        'calculated_score' => 0,
                    ]);
                }
            } else {
                $seminarProposal->status = 'pending';
            }

            $seminarProposal->save();

            return redirect()->back()->with('success', 'Review berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
