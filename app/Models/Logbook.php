<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    //

    protected $table = "logbooks";

    protected $fillable = [
        "super_vision_id",
        "notes",
        "date",
        "comment",
        "status",
        'percentage',
    ];

    public function superVision()
    {
        return $this->belongsTo(SuperVision::class);
    }
}
