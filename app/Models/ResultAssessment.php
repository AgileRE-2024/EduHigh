<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultAssessment extends Model
{
    //

    protected $table = "result_assessments";
    protected $fillable = [
        "result_seminar_id",
        "dosen_id",
        "score",
        "type",
        "category",
        'is_submitted',
        "weight",
        "calculated_score",
    ];

    public function resultSeminar()
    {
        return $this->belongsTo(ResultSeminar::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function resultAssessmentCriterias()
    {
        return $this->hasMany(ResultAssessmentCriteria::class);
    }
}
