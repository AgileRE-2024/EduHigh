<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultAssessmentCriteria extends Model
{
    //
    protected $table = "result_assessment_criterias";

    protected $fillable = [
        "result_assessment_id",
        "result_criteria_id",
        "score",
        "calculated_score",
    ];

    public function resultAssessment()
    {
        return $this->belongsTo(ResultAssessment::class);
    }

    public function resultCriteria()
    {
        return $this->belongsTo(ResultCriteria::class);
    }
}
