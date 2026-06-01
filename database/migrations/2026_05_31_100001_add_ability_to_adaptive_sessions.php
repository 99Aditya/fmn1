<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adaptive_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('adaptive_sessions', 'ability')) {
                // Elo-style skill rating, 0–100. Updated after every answer.
                $table->decimal('ability', 5, 2)->default(50)->after('current_difficulty');
            }
        });
    }

    public function down(): void
    {
        Schema::table('adaptive_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('adaptive_sessions', 'ability')) {
                $table->dropColumn('ability');
            }
        });
    }
};
