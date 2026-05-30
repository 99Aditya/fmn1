<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->constrained()
                ->onDelete('cascade');

            $table->string('title');
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->string('thumbnail')->nullable();

            $table->integer('total_questions')->default(0);

            $table->integer('total_marks')->default(0);

            $table->integer('total_time')->comment('minutes');

            $table->integer('passing_marks')->default(0);

            $table->enum('difficulty', [
                'beginner',
                'intermediate',
                'advanced'
            ])->default('beginner');

            $table->boolean('has_certificate')->default(false);

            $table->integer('certificate_min_score')->default(70);

            $table->text('hashtags')->nullable();

            $table->string('youtube_video_link')->nullable();

            $table->decimal('success_rate', 5, 2)->default(0);

            $table->bigInteger('total_attempts')->default(0);

            $table->decimal('avg_score', 5, 2)->default(0);

            $table->enum('status', [
                'draft',
                'published'
            ])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};