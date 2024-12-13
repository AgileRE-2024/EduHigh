<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResearchQuestion extends Model
{
    /** @use HasFactory<\Database\Factories\ResearchQuestionFactory> */
    use HasFactory;

    protected $table = 'research_questions';

    protected $fillable = [
        'question',
        'proposal_id',
    ];


    public function proposal(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }


    public function reasons(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reason::class);
    }
}
