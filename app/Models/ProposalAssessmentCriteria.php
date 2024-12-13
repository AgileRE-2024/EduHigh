<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalAssessmentCriteria extends Model
{
    //

    protected $table = "proposal_assessment_criterias";
    protected $fillable = [
        "proposal_criteria_id",
        "proposal_assessment_id",
        "score",
        "calculated_score"
    ];

    public function proposalCriteria()
    {
        return $this->belongsTo(ProposalCriteria::class);
    }

    public function proposalAssessment()
    {
        return $this->belongsTo(ProposalAssessment::class);
    }
}
