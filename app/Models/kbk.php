<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kbk extends Model
{
    /** @use HasFactory<\Database\Factories\KbkFactory> */
    use HasFactory;

    protected $table = 'kbks';

    protected $fillable = [
        'name',
        'description',
    ];

    public function subkbks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Subkbk::class);
    }

    public function dosen(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Dosen::class);
    }
}
