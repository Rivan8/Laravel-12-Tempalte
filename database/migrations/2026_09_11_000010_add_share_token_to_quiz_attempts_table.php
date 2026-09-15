<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->string('share_token', 64)->nullable()->unique()->after('id');
        });

        DB::table('quiz_attempts')->whereNull('share_token')->orderBy('id')->eachById(function ($attempt) {
            do {
                $token = Str::random(48);
            } while (DB::table('quiz_attempts')->where('share_token', $token)->exists());

            DB::table('quiz_attempts')->where('id', $attempt->id)->update(['share_token' => $token]);
        });
    }

    public function down(): void
    {
        Schema::table('quiz_attempts', function (Blueprint $table) {
            $table->dropUnique(['share_token']);
            $table->dropColumn('share_token');
        });
    }
};
