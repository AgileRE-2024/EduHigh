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
        Schema::create('seminar_proposal_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id')->nullable(false)->comment('Dosen yang melakukan review');
            $table->unsignedBigInteger('seminar_proposal_id')->nullable(false)->comment('Proposal yang direview');
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
        Schema::dropIfExists('seminar_proposal_reviews');
    }
};
