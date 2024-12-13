<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subkbk extends Model
{
    /** @use HasFactory<\Database\Factories\SubkbkFactory> */
    use HasFactory;

    protected $table = 'subkbks';

    protected $fillable = [
        'name',
        'description',
        'kbk_id',
    ];

    public function kbk(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Kbk::class);
    }

    public function proposals(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Proposal::class);
    }
}
