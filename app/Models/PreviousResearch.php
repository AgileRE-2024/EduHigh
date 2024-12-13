<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousResearch extends Model
{
    /** @use HasFactory<\Database\Factories\PreviousResearchFactory> */
    use HasFactory;

    protected $table = 'previous_researches';

    protected $fillable = [
        'title',
        'doi',
        'authors',
        'problem_statement',
        'results',
        'proposal_id',
    ];

    public function proposal(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }
}
