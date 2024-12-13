<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalAssessment extends Model
{
    //
    protected $table = "proposal_assessments";
    protected $fillable = [
        "seminar_proposal_id",
        "dosen_id",
        "score",
        "type",
    ];

    public function seminarProposal()
    {
        return $this->belongsTo(SeminarProposal::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function proposalAssessmentCriterias()
    {
        return $this->hasMany(ProposalAssessmentCriteria::class);
    }
}
