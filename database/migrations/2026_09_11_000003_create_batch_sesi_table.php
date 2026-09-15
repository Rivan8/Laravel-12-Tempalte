<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batch_sesi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches')->cascadeOnDelete();
            $table->foreignId('sesi_id')->constrained('sesis')->cascadeOnDelete();
            $table->date('tanggal_pelaksanaan');
            $table->timestamps();
            $table->unique(['batch_id', 'sesi_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_sesi');
    }
};
