<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_id')->constrained('sesis')->cascadeOnDelete();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('passing_score')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unique('sesi_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
