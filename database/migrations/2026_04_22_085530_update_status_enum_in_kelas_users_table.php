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
        // Alter the ENUM to include 'rejected'
        DB::statement("ALTER TABLE kelas_users MODIFY COLUMN status ENUM('requested', 'in_progress', 'completed', 'rejected') DEFAULT 'requested'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE kelas_users MODIFY COLUMN status ENUM('requested', 'in_progress', 'completed') DEFAULT 'requested'");
    }
};
