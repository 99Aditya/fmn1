<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs.
     */
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->get();
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $data = new Blog();
        $data->title = $validated['title'];
        $data->description = $validated['description'];
        if ($data->save()) {
            return redirect()->route('admin.blog')->with('success', 'Blog created successfully.');
        } else {
            return back()->with('error', 'Failed to create blog. Please try again.');
        }
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit($id = 0)
    {
        $blog = Blog::findOrFail($id);  
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(Request $request, $id = 0)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $blog = Blog::where('id', $id)->first();
        $blog->title = $validated['title'];
        $blog->description = $validated['description'];
        if ($blog->save()) {
            return redirect()->route('admin.blog')->with('success', 'Blog updated successfully.');
        } else {
            return back()->with('error', 'Failed to update blog. Please try again.');
        }
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog deleted successfully.');
    }
}
