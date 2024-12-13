<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalCriteria extends Model
{
    //
    protected $table = "proposal_criterias";
    protected $fillable = [
        "name",
        "weight",
        "type"
    ];

    public function proposalAssesmentCriterias()
    {
        return $this->hasMany(ProposalAssessmentCriteria::class);
    }
}
