<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultSeminarReview extends Model
{
    //
    protected $table = "result_seminar_reviews";

    protected $fillable = [
        "result_seminar_id",
        "dosen_id",
        "status",
        "comment",
    ];

    public $timestamps = false;
    public function resultSeminar()
    {
        return $this->belongsTo(ResultSeminar::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
