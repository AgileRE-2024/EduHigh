<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Output extends Model
{
    /** @use HasFactory<\Database\Factories\OutputFactory> */
    use HasFactory;

    protected $table = 'outputs';

    protected $fillable = [
        'research_output',
        'proposal_id',
    ];

    public function proposal(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Proposal::class);
    }
}
