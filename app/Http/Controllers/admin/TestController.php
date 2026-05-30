<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::with('category')->withCount('questions')->orderByDesc('created_at')->get();
        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        $categories = Category::forTests()->orderBy('name')->get();
        return view('admin.tests.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'          => 'required|exists:categories,id',
            'title'                => 'required|string|max:255',
            'description'          => 'nullable|string',
            'total_time'           => 'required|integer|min:1',
            'passing_marks'        => 'required|integer|min:0',
            'difficulty'           => 'required|in:beginner,intermediate,advanced',
            'has_certificate'      => 'nullable|boolean',
            'certificate_min_score'=> 'nullable|integer|min:0|max:100',
            'status'               => 'required|in:draft,published',
            'hashtags'             => 'nullable|string',
            'youtube_video_link'   => 'nullable|url',
        ]);

        Test::create([
            'category_id'           => $request->category_id,
            'title'                 => $request->title,
            'slug'                  => Str::slug($request->title),
            'description'           => $request->description,
            'total_time'            => $request->total_time,
            'passing_marks'         => $request->passing_marks,
            'difficulty'            => $request->difficulty,
            'has_certificate'       => $request->boolean('has_certificate'),
            'certificate_min_score' => $request->certificate_min_score ?? 70,
            'status'                => $request->status,
            'hashtags'              => $request->hashtags,
            'youtube_video_link'    => $request->youtube_video_link,
        ]);

        return redirect()->route('admin.tests.index')->with('success', 'Test created successfully.');
    }

    public function edit(Test $test)
    {
        $categories = Category::forTests()->orderBy('name')->get();
        return view('admin.tests.edit', compact('test', 'categories'));
    }

    public function update(Request $request, Test $test)
    {
        $request->validate([
            'category_id'          => 'required|exists:categories,id',
            'title'                => 'required|string|max:255',
            'description'          => 'nullable|string',
            'total_time'           => 'required|integer|min:1',
            'passing_marks'        => 'required|integer|min:0',
            'difficulty'           => 'required|in:beginner,intermediate,advanced',
            'has_certificate'      => 'nullable|boolean',
            'certificate_min_score'=> 'nullable|integer|min:0|max:100',
            'status'               => 'required|in:draft,published',
            'hashtags'             => 'nullable|string',
            'youtube_video_link'   => 'nullable|url',
        ]);

        $test->update([
            'category_id'           => $request->category_id,
            'title'                 => $request->title,
            'slug'                  => Str::slug($request->title),
            'description'           => $request->description,
            'total_time'            => $request->total_time,
            'passing_marks'         => $request->passing_marks,
            'difficulty'            => $request->difficulty,
            'has_certificate'       => $request->boolean('has_certificate'),
            'certificate_min_score' => $request->certificate_min_score ?? 70,
            'status'                => $request->status,
            'hashtags'              => $request->hashtags,
            'youtube_video_link'    => $request->youtube_video_link,
        ]);

        return redirect()->route('admin.tests.index')->with('success', 'Test updated successfully.');
    }

    public function destroy(Test $test)
    {
        $test->delete();
        return redirect()->route('admin.tests.index')->with('success', 'Test deleted.');
    }
}
