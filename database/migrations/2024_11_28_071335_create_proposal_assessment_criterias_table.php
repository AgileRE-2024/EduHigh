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
        Schema::create('proposal_assessment_criterias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_criteria_id');
            $table->unsignedBigInteger('proposal_assessment_id');
            $table->decimal('score', 10, 2);
            $table->decimal('calculated_score', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_assessment_criterias');
    }
};

