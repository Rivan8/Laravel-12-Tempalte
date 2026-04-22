<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kelas_users', function (Blueprint $table) {
            $table->text('rejection_reason')->nullable()->after('status');
        });

        // Update enum to include 'rejected' status
        // For SQLite compatibility, we use a raw statement approach
        // If using MySQL, this would be an ALTER COLUMN
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas_users', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
        });
    }
};
