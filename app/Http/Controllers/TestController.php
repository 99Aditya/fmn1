<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        $categories = Category::forTests()
            ->with(['tests' => fn($q) => $q->where('status', 'published')->withCount('questions')])
            ->withCount(['tests' => fn($q) => $q->where('status', 'published')])
            ->having('tests_count', '>', 0)
            ->get();

        return view('frontend.tests.index', compact('categories'));
    }

    public function category(Category $category)
    {
        $tests = $category->tests()
            ->where('status', 'published')
            ->withCount('questions')
            ->orderByDesc('created_at')
            ->get();

        return view('frontend.tests.category', compact('category', 'tests'));
    }

    public function show(Category $category, Test $test)
    {
        abort_if($test->status !== 'published', 404);

        $test->load(['questions' => fn($q) => $q->count()]);
        $questionsCount = $test->questions()->count();

        $userAttempts = [];
        if (auth()->check()) {
            $userAttempts = $test->attempts()
                ->where('user_id', auth()->id())
                ->orderByDesc('created_at')
                ->get();
        }

        return view('frontend.tests.show', compact('test', 'category', 'questionsCount', 'userAttempts'));
    }
}
