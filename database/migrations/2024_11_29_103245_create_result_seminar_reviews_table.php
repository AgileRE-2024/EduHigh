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
        Schema::create('result_seminar_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id')->nullable(false);
            $table->unsignedBigInteger('result_seminar_id')->nullable(false);
            $table->foreign('dosen_id')->references('id')->on('dosens')->cascadeOnDelete();
            $table->foreign('result_seminar_id')->references('id')->on('result_seminars')->cascadeOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected'])->nullable(false)->comment('Status review')->default('pending');
            $table->text('comment')->nullable()->comment('Komentar dari dosen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_seminar_reviews');
    }
};
