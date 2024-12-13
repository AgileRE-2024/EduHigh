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
        Schema::create('result_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('result_seminar_id');
            $table->unsignedBigInteger('dosen_id');
            $table->enum('type', ['pembimbing_1', 'pembimbing_2', 'penguji_1', 'penguji_2'])->default('pembimbing_1');
            $table->enum('category', ['material', 'presentation'])->default('material');
            $table->decimal('calculated_score', 8, 2)->default(0);
            $table->decimal('weight', 8, 2)->default(0);
            $table->boolean('is_submitted')->default(value: false);
            $table->decimal('score', 8, 2)->default(0);
            $table->foreign('result_seminar_id')->references('id')->on('result_seminars')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id')->on('dosens')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_assessments');
    }
};
