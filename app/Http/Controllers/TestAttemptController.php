<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Services\CertificateService;
use App\Services\TestScoringService;
use Illuminate\Http\Request;

class TestAttemptController extends Controller
{
    public function start(Test $test)
    {
        abort_if($test->status !== 'published', 404);
        abort_if($test->questions()->count() === 0, 422, 'This test has no questions yet.');

        $attempt = TestAttempt::create([
            'user_id'    => auth()->id(),
            'test_id'    => $test->id,
            'started_at' => now(),
        ]);

        return redirect()->route('tests.attempt.show', [$test, $attempt]);
    }

    public function show(Test $test, TestAttempt $attempt)
    {
        abort_if($attempt->user_id !== auth()->id(), 403);
        abort_if($attempt->completed_at !== null, 302, route('tests.attempt.result', [$test, $attempt]));

        if ($attempt->completed_at) {
            return redirect()->route('tests.attempt.result', [$test, $attempt]);
        }

        $questions = $test->questions()
            ->with('options')
            ->orderBy('question_order')
            ->get();

        $timeLimit    = $test->total_time * 60;
        $elapsed      = now()->diffInSeconds($attempt->started_at);
        $timeRemaining = max(0, $timeLimit - $elapsed);

        if ($timeRemaining <= 0) {
            return redirect()->route('tests.attempt.submit', [$test, $attempt])
                ->withMethod('POST')
                ->with('answers', []);
        }

        return view('frontend.tests.attempt', compact('test', 'attempt', 'questions', 'timeRemaining'));
    }

    public function submit(Request $request, Test $test, TestAttempt $attempt)
    {
        abort_if($attempt->user_id !== auth()->id(), 403);

        if ($attempt->completed_at) {
            return redirect()->route('tests.attempt.result', [$test, $attempt]);
        }

        $answers = $request->input('answers', []);

        $scoring = app(TestScoringService::class);
        $scoring->score($attempt, $answers);

        if ($attempt->fresh()->certificate_earned) {
            $certService = app(CertificateService::class);
            $certService->issue($attempt->fresh());
        }

        return redirect()->route('tests.attempt.result', [$test, $attempt]);
    }

    public function result(Test $test, TestAttempt $attempt)
    {
        abort_if($attempt->user_id !== auth()->id(), 403);
        abort_if($attempt->completed_at === null, 404);

        $attempt->load('answers.question.options');

        $questions = $test->questions()->with('options')->orderBy('question_order')->get();

        $answersMap = $attempt->answers->keyBy('question_id');

        $certificate = null;
        if ($attempt->certificate_earned) {
            $certificate = Certificate::where('attempt_id', $attempt->id)->first();
        }

        return view('frontend.tests.result', compact('test', 'attempt', 'questions', 'answersMap', 'certificate'));
    }
}
