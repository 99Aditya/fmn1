<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category', 'author')
            ->orderByDesc('created_at')
            ->get();
        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::forBlogs()->orderBy('name')->get();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'category_id'      => 'nullable|exists:categories,id',
            'excerpt'          => 'nullable|string|max:400',
            'hashtags'         => 'nullable|string|max:500',
            'meta_title'       => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'status'           => 'required|in:draft,published',
            'featured_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $slug = $this->uniqueSlug($request->title);
        $imagePath = null;

        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('blog', 'public');
        }

        Blog::create([
            'title'            => $request->title,
            'slug'             => $slug,
            'category_id'      => $request->category_id,
            'author_id'        => auth()->id(),
            'content'          => $request->content,
            'excerpt'          => $request->excerpt ?: Str::limit(strip_tags($request->content), 180),
            'featured_image'   => $imagePath,
            'hashtags'         => $request->hashtags,
            'meta_title'       => $request->meta_title ?: $request->title,
            'meta_description' => $request->meta_description ?: Str::limit(strip_tags($request->content), 155),
            'status'           => $request->status,
            'published_at'     => $request->status === 'published' ? now() : null,
            'read_time'        => Blog::calcReadTime($request->content),
        ]);

        return redirect()->route('admin.blog')->with('success', 'Blog post published successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = Category::forBlogs()->orderBy('name')->get();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'category_id'      => 'nullable|exists:categories,id',
            'excerpt'          => 'nullable|string|max:400',
            'hashtags'         => 'nullable|string|max:500',
            'meta_title'       => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'status'           => 'required|in:draft,published',
            'featured_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data = [
            'title'            => $request->title,
            'category_id'      => $request->category_id,
            'content'          => $request->content,
            'excerpt'          => $request->excerpt ?: Str::limit(strip_tags($request->content), 180),
            'hashtags'         => $request->hashtags,
            'meta_title'       => $request->meta_title ?: $request->title,
            'meta_description' => $request->meta_description ?: Str::limit(strip_tags($request->content), 155),
            'status'           => $request->status,
            'read_time'        => Blog::calcReadTime($request->content),
        ];

        if ($request->status === 'published' && ! $blog->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blog', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blog')->with('success', 'Blog post updated.');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blog')->with('success', 'Blog post deleted.');
    }

    private function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }
        return $slug;
    }
}
