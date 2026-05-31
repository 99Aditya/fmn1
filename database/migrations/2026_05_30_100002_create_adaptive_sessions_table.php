<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('adaptive_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('test_id')->constrained()->onDelete('cascade');

            $table->tinyInteger('current_difficulty')->default(2);
            $table->integer('max_questions')->default(12);
            $table->integer('questions_answered')->default(0);
            $table->integer('correct_count')->default(0);
            $table->integer('wrong_count')->default(0);

            // Live state used by the engine.
            $table->json('served_ids')->nullable();   // question ids already shown (no repeats)
            $table->json('log')->nullable();          // [{question_id, difficulty, correct}] for the graph
            $table->unsignedBigInteger('pending_question_id')->nullable(); // the question currently awaiting an answer

            $table->decimal('final_level', 3, 1)->nullable(); // 1.0 – 5.0
            $table->integer('final_score')->nullable();       // 0 – 100
            $table->string('final_band')->nullable();         // Beginner … Expert

            $table->enum('status', ['in_progress', 'completed'])->default('in_progress');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('adaptive_sessions');
    }
};
