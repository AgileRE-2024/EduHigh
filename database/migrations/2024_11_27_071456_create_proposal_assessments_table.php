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
        Schema::create('proposal_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seminar_proposal_id');
            $table->unsignedBigInteger('dosen_id');
            $table->enum('type', ['pembimbing_1', 'pembimbing_2', 'penguji'])->default('pembimbing_1');
            $table->decimal('score', 5, 2)->default(0);
            $table->foreign('seminar_proposal_id')->references('id')->on('seminar_proposals')->cascadeOnDelete();
            $table->foreign('dosen_id')->references('id')->on('dosens')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_assesments');
    }
};
