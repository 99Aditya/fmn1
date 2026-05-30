<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete()->after('slug');
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete()->after('category_id');
            $table->text('excerpt')->nullable()->after('author_id');
            $table->string('featured_image')->nullable()->after('excerpt');
            $table->string('hashtags')->nullable()->after('featured_image');
            // SEO
            $table->string('meta_title')->nullable()->after('hashtags');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('canonical_url')->nullable()->after('meta_description');
            // Status & timing
            $table->enum('status', ['draft', 'published'])->default('draft')->after('canonical_url');
            $table->timestamp('published_at')->nullable()->after('status');
            $table->unsignedInteger('read_time')->default(1)->comment('minutes')->after('published_at');
            $table->unsignedBigInteger('views')->default(0)->after('read_time');

            // rename description → content (longText already exists, just add content)
        });

        // rename description to content
        Schema::table('blogs', function (Blueprint $table) {
            $table->renameColumn('description', 'content');
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->renameColumn('content', 'description');
            $table->dropForeign(['category_id']);
            $table->dropForeign(['author_id']);
            $table->dropColumn([
                'slug','category_id','author_id','excerpt','featured_image',
                'hashtags','meta_title','meta_description','canonical_url',
                'status','published_at','read_time','views',
            ]);
        });
    }
};
