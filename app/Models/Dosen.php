<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Dosen extends Model
{
    /** @use HasFactory<\Database\Factories\DosenFactory> */
    use HasFactory;

    protected $table = 'dosens';

    protected $fillable = [
        'user_id',
        'nidn',
        'department_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function schedules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function superVisions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SuperVision::class);
    }

    public function kbk(): BelongsTo
    {
        return $this->belongsTo(Kbk::class);
    }

    public function proposalAssesments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProposalAssessment::class);
    }

    public function seminarProposalReviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SeminarProposalReview::class);
    }

    public function resultAssessments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ResultAssessment::class);
    }

    public function resultSeminarReviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ResultSeminarReview::class);
    }
}
