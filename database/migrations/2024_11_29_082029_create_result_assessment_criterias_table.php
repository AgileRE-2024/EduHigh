<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('result_assessment_criterias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('result_criteria_id');
            $table->unsignedBigInteger('result_assessment_id');
            $table->decimal('score', 8, 2)->default(0);
            $table->decimal('calculated_score', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_assessment_criterias');
    }
};
