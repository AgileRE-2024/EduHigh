<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    /** @use HasFactory<\Database\Factories\MahasiswaFactory> */
    use HasFactory;

    protected $table = 'mahasiswas';

    protected $fillable = [
        'user_id',
        'nim',
        'department_id',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function superVisions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SuperVision::class);
    }

    public function seminarProposal(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(SeminarProposal::class);
    }

    public function resultSeminar(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ResultSeminar::class);
    }
}
