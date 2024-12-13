<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeminarProposalReview extends Model
{
    //

    protected $table = "seminar_proposal_reviews";

    protected $fillable = [
        "dosen_id",
        "seminar_proposal_id",
        "status",
        "comment"
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function seminarProposal()
    {
        return $this->belongsTo(SeminarProposal::class);
    }
}
