<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()
            ->with('category', 'author')
            ->orderByDesc('published_at')
            ->paginate(9);

        $categories = Category::forBlogs()
            ->whereHas('blogs', fn($q) => $q->published())
            ->withCount(['blogs' => fn($q) => $q->published()])
            ->orderBy('name')
            ->get();

        $popular = Blog::published()
            ->orderByDesc('views')
            ->limit(4)
            ->get();

        $tags = Blog::published()
            ->whereNotNull('hashtags')
            ->pluck('hashtags')
            ->flatMap(fn($h) => array_map('trim', explode(',', $h)))
            ->filter()
            ->countBy()
            ->sortDesc()
            ->take(20)
            ->keys();

        return view('frontend.blog.index', compact('blogs', 'categories', 'popular', 'tags'));
    }

    public function category(Category $category)
    {
        $blogs = Blog::published()
            ->where('category_id', $category->id)
            ->with('author')
            ->orderByDesc('published_at')
            ->paginate(9);

        $categories = Category::forBlogs()
            ->whereHas('blogs', fn($q) => $q->published())
            ->withCount(['blogs' => fn($q) => $q->published()])
            ->orderBy('name')
            ->get();

        $tags = Blog::published()
            ->whereNotNull('hashtags')
            ->pluck('hashtags')
            ->flatMap(fn($h) => array_map('trim', explode(',', $h)))
            ->filter()
            ->countBy()
            ->sortDesc()
            ->take(20)
            ->keys();

        return view('frontend.blog.index', compact('blogs', 'categories', 'tags'))
            ->with('activeCategory', $category);
    }

    public function tag(string $tag)
    {
        $blogs = Blog::published()
            ->where('hashtags', 'like', "%{$tag}%")
            ->with('category', 'author')
            ->orderByDesc('published_at')
            ->paginate(9);

        $categories = Category::forBlogs()
            ->whereHas('blogs', fn($q) => $q->published())
            ->withCount(['blogs' => fn($q) => $q->published()])
            ->orderBy('name')
            ->get();

        $tags = Blog::published()
            ->whereNotNull('hashtags')
            ->pluck('hashtags')
            ->flatMap(fn($h) => array_map('trim', explode(',', $h)))
            ->filter()
            ->countBy()
            ->sortDesc()
            ->take(20)
            ->keys();

        return view('frontend.blog.index', compact('blogs', 'categories', 'tags'))
            ->with('activeTag', $tag);
    }

    public function show(string $slug)
    {
        $blog = Blog::published()
            ->with('category', 'author')
            ->where('slug', $slug)
            ->firstOrFail();

        $blog->incrementViews();

        $related = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where(function ($q) use ($blog) {
                if ($blog->category_id) $q->where('category_id', $blog->category_id);
            })
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('frontend.blog.show', compact('blog', 'related'));
    }
}
