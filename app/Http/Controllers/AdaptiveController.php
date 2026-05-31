<?php

namespace App\Http\Controllers;

use App\Models\AdaptiveSession;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdaptiveController extends Controller
{
    private const START_DIFFICULTY = 2;
    private const MIN_DIFFICULTY = 1;
    private const MAX_DIFFICULTY = 5;
    private const DEFAULT_MAX_QUESTIONS = 12;

    /** Landing / start screen for an adaptive test. */
    public function show(Test $test)
    {
        $pool = $test->questions()->where('is_pooled', true)->count();

        // Resume an in-progress session if one exists.
        $session = AdaptiveSession::where('user_id', Auth::id())
            ->where('test_id', $test->id)
            ->where('status', 'in_progress')
            ->latest()
            ->first();

        return view('frontend.tests.adaptive', [
            'test'        => $test,
            'poolCount'   => $pool,
            'hasSession'  => (bool) $session,
            'sessionId'   => $session?->id,
        ]);
    }

    /** Create a fresh session and hand back the first question (JSON). */
    public function start(Test $test)
    {
        $poolCount = $test->questions()->where('is_pooled', true)->count();
        if ($poolCount < 3) {
            return response()->json(['message' => 'This test does not have enough questions for an adaptive session yet.'], 422);
        }

        // Reuse any existing in-progress session instead of stacking duplicates.
        $session = AdaptiveSession::where('user_id', Auth::id())
            ->where('test_id', $test->id)
            ->where('status', 'in_progress')
            ->latest()
            ->first();

        if (!$session) {
            $session = AdaptiveSession::create([
                'user_id'            => Auth::id(),
                'test_id'            => $test->id,
                'current_difficulty' => self::START_DIFFICULTY,
                'max_questions'      => min(self::DEFAULT_MAX_QUESTIONS, $poolCount),
                'served_ids'         => [],
                'log'                => [],
                'status'             => 'in_progress',
                'started_at'         => now(),
            ]);
        }

        $payload = $this->serveNext($session);
        $payload['session_id'] = $session->id;

        return response()->json($payload);
    }

    /** Grade the pending answer, move the ladder, return the next question or finish. */
    public function answer(Request $request, AdaptiveSession $session)
    {
        $this->authorizeSession($session);

        if ($session->status === 'completed') {
            return response()->json(['done' => true, 'redirect' => route('adaptive.result', $session->id)]);
        }

        $data = $request->validate([
            'question_id' => 'required|integer',
            'option_id'   => 'required|integer',
        ]);

        // The answered question must be the one we are actually waiting on (anti-tamper).
        if ((int) $data['question_id'] !== (int) $session->pending_question_id) {
            return response()->json(['message' => 'Unexpected question. Please refresh and try again.'], 422);
        }

        $question = Question::with('options')->find($data['question_id']);
        if (!$question) {
            return response()->json(['message' => 'Question not found.'], 404);
        }

        // The selected option must belong to this question.
        $option = $question->options->firstWhere('id', (int) $data['option_id']);
        if (!$option) {
            return response()->json(['message' => 'Invalid option.'], 422);
        }

        $isCorrect = (bool) $option->is_correct;
        $correctOption = $question->options->firstWhere('is_correct', true);

        // --- Difficulty ladder ---
        if ($isCorrect) {
            $session->correct_count++;
            $session->current_difficulty = min(self::MAX_DIFFICULTY, $session->current_difficulty + 1);
        } else {
            $session->wrong_count++;
            $session->current_difficulty = max(self::MIN_DIFFICULTY, $session->current_difficulty - 1);
        }

        $session->questions_answered++;

        $log = $session->log ?? [];
        $log[] = [
            'question_id' => $question->id,
            'difficulty'  => (int) $question->difficulty,
            'correct'     => $isCorrect,
        ];
        $session->log = $log;
        $session->pending_question_id = null;
        $session->save();

        $feedback = [
            'correct'            => $isCorrect,
            'correct_option_id'  => $correctOption?->id,
            'explanation'        => $question->explanation,
            'current_level'      => $session->current_difficulty,
        ];

        // Finished?
        if ($session->questions_answered >= $session->max_questions) {
            $this->finalize($session);
            return response()->json([
                'done'     => true,
                'feedback' => $feedback,
                'redirect' => route('adaptive.result', $session->id),
            ]);
        }

        $next = $this->serveNext($session);

        // Pool exhausted before reaching max — finish gracefully.
        if (!empty($next['done'])) {
            $this->finalize($session);
            return response()->json([
                'done'     => true,
                'feedback' => $feedback,
                'redirect' => route('adaptive.result', $session->id),
            ]);
        }

        $next['feedback'] = $feedback;
        return response()->json($next);
    }

    /** Final result page with the difficulty-progression graph. */
    public function result(AdaptiveSession $session)
    {
        $this->authorizeSession($session);

        if ($session->status !== 'completed') {
            $this->finalize($session);
        }

        $session->load('test');

        return view('frontend.tests.adaptive_result', [
            'session' => $session,
            'test'    => $session->test,
        ]);
    }

    /**
     * Pick the next unseen question near the current difficulty and return the
     * JSON payload the front-end renders. Sets it as the pending question.
     */
    private function serveNext(AdaptiveSession $session): array
    {
        $served = $session->served_ids ?? [];
        $question = $this->pickQuestion($session->test_id, $session->current_difficulty, $served);

        if (!$question) {
            return ['done' => true, 'redirect' => route('adaptive.result', $session->id)];
        }

        $served[] = $question->id;
        $session->served_ids = $served;
        $session->pending_question_id = $question->id;
        $session->save();

        return [
            'done'     => false,
            'progress' => [
                'answered' => $session->questions_answered,
                'total'    => $session->max_questions,
            ],
            'current_level' => $session->current_difficulty,
            'question'      => [
                'id'         => $question->id,
                'text'       => $question->question,
                'difficulty' => (int) $question->difficulty,
                'options'    => $question->options->map(fn($o) => [
                    'id'   => $o->id,
                    'text' => $o->option_text,
                ])->values(),
            ],
        ];
    }

    /**
     * Find a pooled, unseen question at the target difficulty, widening the
     * search outward (±1, ±2 …) until something is found.
     */
    private function pickQuestion(int $testId, int $target, array $served): ?Question
    {
        for ($delta = 0; $delta < self::MAX_DIFFICULTY; $delta++) {
            $candidates = collect([$target - $delta, $target + $delta])
                ->unique()
                ->filter(fn($d) => $d >= self::MIN_DIFFICULTY && $d <= self::MAX_DIFFICULTY);

            foreach ($candidates as $difficulty) {
                $q = Question::with('options')
                    ->where('test_id', $testId)
                    ->where('is_pooled', true)
                    ->where('difficulty', $difficulty)
                    ->whereNotIn('id', $served)
                    ->inRandomOrder()
                    ->first();

                if ($q) {
                    return $q;
                }
            }
        }

        return null;
    }

    /** Compute the final level, score and band, then close the session. */
    private function finalize(AdaptiveSession $session): void
    {
        $log = $session->log ?? [];
        $answered = max(1, count($log));

        // Final level = average difficulty of the last few questions they faced.
        $tail = array_slice($log, -5);
        $level = count($tail) ? array_sum(array_column($tail, 'difficulty')) / count($tail) : self::START_DIFFICULTY;
        $level = round($level, 1);

        $accuracy = $session->correct_count / $answered; // 0–1

        // Blend difficulty reached (70%) with accuracy (30%) into a 0–100 score.
        $score = (int) round(($level / self::MAX_DIFFICULTY) * 70 + $accuracy * 30);
        $score = max(0, min(100, $score));

        $session->final_level = $level;
        $session->final_score = $score;
        $session->final_band  = $this->band($level);
        $session->status = 'completed';
        $session->completed_at = now();
        $session->save();
    }

    private function band(float $level): string
    {
        return match (true) {
            $level < 1.5 => 'Beginner',
            $level < 2.5 => 'Elementary',
            $level < 3.5 => 'Intermediate',
            $level < 4.5 => 'Advanced',
            default      => 'Expert',
        };
    }

    private function authorizeSession(AdaptiveSession $session): void
    {
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
