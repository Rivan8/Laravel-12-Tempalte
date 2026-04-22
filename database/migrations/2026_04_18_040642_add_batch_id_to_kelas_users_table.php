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
        Schema::table('kelas_users', function (Blueprint $table) {
            $table->unsignedBigInteger('batch_id')->nullable();
            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('set null');
        });

        // Data migration: Create default batches and assign them
        $kelases = \Illuminate\Support\Facades\DB::table('kelas')->get();
        foreach ($kelases as $kelas) {
            $defaultBatchId = \Illuminate\Support\Facades\DB::table('batches')->insertGetId([
                'kelas_id' => $kelas->id,
                'nama_batch' => 'Batch Default',
                'start_date' => now(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \Illuminate\Support\Facades\DB::table('kelas_users')
                ->where('kelas_id', $kelas->id)
                ->whereNull('batch_id')
                ->update(['batch_id' => $defaultBatchId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas_users', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropColumn('batch_id');
        });
    }
};
