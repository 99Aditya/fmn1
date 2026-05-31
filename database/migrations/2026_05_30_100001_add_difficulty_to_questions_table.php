<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            if (!Schema::hasColumn('questions', 'difficulty')) {
                // 1 = easiest … 5 = hardest. Drives the adaptive difficulty ladder.
                $table->tinyInteger('difficulty')->default(2)->after('marks');
            }
            if (!Schema::hasColumn('questions', 'topic')) {
                $table->string('topic')->nullable()->after('difficulty');
            }
            if (!Schema::hasColumn('questions', 'is_pooled')) {
                // Whether this question may be served in adaptive sessions.
                $table->boolean('is_pooled')->default(true)->after('topic');
            }
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            foreach (['difficulty', 'topic', 'is_pooled'] as $col) {
                if (Schema::hasColumn('questions', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
