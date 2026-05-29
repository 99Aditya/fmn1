<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('test_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('attempt_id')
                ->constrained('test_attempts')
                ->onDelete('cascade');

            $table->string('certificate_no')->unique();

            $table->string('certificate_url')->nullable();

            $table->timestamp('issued_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};