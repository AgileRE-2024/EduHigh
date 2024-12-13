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
        Schema::create('dosen_sub_kbks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id')->nullable(false);
            $table->unsignedBigInteger('sub_kbk_id')->nullable(false);
            $table->foreign('dosen_id')->references('id')->on('dosens')->cascadeOnDelete();
            $table->foreign('sub_kbk_id')->references('id')->on('subkbks')->cascadeOnDelete();
            $table->unique(['dosen_id', 'sub_kbk_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_sub_kbks');
    }
};
