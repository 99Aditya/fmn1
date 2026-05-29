<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('test_attempts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('test_id')
                ->constrained()
                ->onDelete('cascade');

            $table->decimal('score', 5, 2)->default(0);

            $table->integer('correct_answers')->default(0);

            $table->integer('wrong_answers')->default(0);

            $table->integer('total_questions')->default(0);

            $table->decimal('percentage', 5, 2)->default(0);

            $table->boolean('passed')->default(false);

            $table->boolean('certificate_earned')->default(false);

            $table->timestamp('started_at')->nullable();

            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_attempts');
    }
};