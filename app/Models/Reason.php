<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    /** @use HasFactory<\Database\Factories\ReasonFactory> */
    use HasFactory;

    protected $table = 'reasons';

    protected $fillable = [
        'reason',
        'reasearch_question_id',
    ];


    public function researchQuestion(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ResearchQuestion::class);
    }
}
