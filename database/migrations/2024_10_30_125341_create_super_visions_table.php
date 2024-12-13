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
        Schema::create('super_visions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id')->nullable(false);
            $table->unsignedBigInteger('mahasiswa_id')->nullable(false);
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed',])->default('pending');
            $table->text('comment')->nullable();
            $table->enum('dosen_pembimbing', ['pembimbing_1', 'pembimbing_2'])->nullable();
            $table->unique(['dosen_id', 'mahasiswa_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('super_visions');
    }
};
