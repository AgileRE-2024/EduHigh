<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultCriteria extends Model
{
    //
    protected $table = "result_criterias";

    protected $fillable = [
        "name",
        "weight",
        "type"
    ];

    public function resultAssesmentCriterias()
    {
        return $this->hasMany(ResultAssessmentCriteria::class);
    }
}
