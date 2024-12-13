<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    /** @use HasFactory<\Database\Factories\ProposalFactory> */
    use HasFactory;

    protected $table = 'proposals';

    protected $fillable = [
        'topic',
        'background',
        'user_id',
        'subkbk_id',
        'methodology',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subkbk(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Subkbk::class);
    }

    public function titles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Title::class);
    }

    public function previousResearches(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PreviousResearch::class);
    }

    public function researchQuestions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ResearchQuestion::class);
    }

    public function outputs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Output::class);
    }

    public function backgroundReasons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(BackgroundReason::class);
    }
}
