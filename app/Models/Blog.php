<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'slug', 'excerpt', 'content', 'featured_image', 'published_at', 'is_active', 'view_count'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'blog_category');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
