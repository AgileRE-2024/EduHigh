<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackgroundReason extends Model
{
    /** @use HasFactory<\Database\Factories\BackgroundReasonFactory> */
    use HasFactory;

    protected $table = 'background_reasons';
    protected $fillable = ['reason', 'proposal_id'];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class);
    }
}
