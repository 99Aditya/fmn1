<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'category_id', 'author_id', 'content', 'excerpt',
        'featured_image', 'hashtags', 'meta_title', 'meta_description',
        'canonical_url', 'status', 'published_at', 'read_time', 'views',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views'        => 'integer',
        'read_time'    => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
    }

    public function getTagsArrayAttribute(): array
    {
        return $this->hashtags
            ? array_map('trim', explode(',', $this->hashtags))
            : [];
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? asset('storage/' . $this->featured_image) : null;
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    // Auto calculate read time from content word count
    public static function calcReadTime(string $content): int
    {
        $words = str_word_count(strip_tags($content));
        return max(1, (int) ceil($words / 200));
    }
}
