<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\TestAttempt;

class UserDashboardController extends Controller
{
    public function index()
    {
        $attempts = TestAttempt::where('user_id', auth()->id())
            ->with('test.category')
            ->whereNotNull('completed_at')
            ->orderByDesc('completed_at')
            ->get();

        $certificates = Certificate::where('user_id', auth()->id())
            ->with('test')
            ->orderByDesc('issued_at')
            ->get();

        return view('frontend.dashboard.index', compact('attempts', 'certificates'));
    }

    public function certificates()
    {
        $certificates = Certificate::where('user_id', auth()->id())
            ->with('test')
            ->orderByDesc('issued_at')
            ->get();

        return view('frontend.dashboard.certificates', compact('certificates'));
    }
}
