<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sesis', function (Blueprint $table) {
            $table->id();
            $table->integer('kelas_id');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('link_quiz')->nullable();
            $table->unsignedInteger('urutan')->default(1);
            $table->timestamps();
        });

        Schema::table('materis', function (Blueprint $table) {
            $table->foreign('sesi_id')->references('id')->on('sesis')->cascadeOnDelete();
        });

        Schema::table('sesis', function (Blueprint $table) {
            $table->foreign('kelas_id')->references('id')->on('kelas')->cascadeOnDelete();
        });

        $kelasIds = DB::table('kelas')->pluck('id');
        foreach ($kelasIds as $kelasId) {
            $materiIds = DB::table('materis')->where('kelas_id', $kelasId)->pluck('id');
            if ($materiIds->isEmpty()) {
                continue;
            }

            $sesiId = DB::table('sesis')->insertGetId([
                'kelas_id' => $kelasId,
                'judul' => 'Sesi 1',
                'deskripsi' => null,
                'link_quiz' => null,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('materis')->whereIn('id', $materiIds)->update(['sesi_id' => $sesiId]);
        }
    }

    public function down(): void
    {
        Schema::table('materis', function (Blueprint $table) {
            $table->dropForeign(['sesi_id']);
        });
        Schema::table('sesis', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
        });
        Schema::dropIfExists('sesis');
    }
};
