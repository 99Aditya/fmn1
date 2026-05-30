<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'parent_id', 'depth', 'type'];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function scopeForTests($query)
    {
        return $query->where('type', 'test');
    }

    public function scopeForBlogs($query)
    {
        return $query->where('type', 'blog');
    }
}
