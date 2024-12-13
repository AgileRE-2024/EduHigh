<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeminarProposal extends Model
{
    //

    protected $table = "seminar_proposals";

    protected $fillable = [
        "mahasiswa_id",
        "status",
        "result",
        "numeric_grade",
        "letter_grade",
        "date",
        "time",
        "location"
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function proposalAssessments()
    {
        return $this->hasMany(ProposalAssessment::class);
    }

    public function seminarProposalReviews()
    {
        return $this->hasMany(SeminarProposalReview::class);
    }
}
