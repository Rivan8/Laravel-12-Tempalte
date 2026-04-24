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
        Schema::table('kelas', function (Blueprint $table) {
            $table->string('handbook_name')->nullable()->after('handbook');
            $table->string('tools_name')->nullable()->after('tools');
            $table->string('slide_name')->nullable()->after('slide');
            for ($i = 4; $i <= 12; $i++) {
                $table->string('file_'.$i)->nullable();
                $table->string('file_'.$i.'_name')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn([
                'handbook_name', 'tools_name', 'slide_name'
            ]);
            for ($i = 4; $i <= 12; $i++) {
                $table->dropColumn(['file_'.$i, 'file_'.$i.'_name']);
            }
        });
    }
};
