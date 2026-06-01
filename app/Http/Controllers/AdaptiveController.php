<?php

namespace App\Http\Controllers;

use App\Models\AdaptiveSession;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdaptiveController extends Controller
{
    // Question difficulty is authored on a 1–10 scale.
    private const MIN_DIFFICULTY = 1;
    private const MAX_DIFFICULTY = 10;

    // User ability is an Elo-style rating on a 0–100 scale.
    private const START_ABILITY = 50.0;
    private const MIN_ABILITY = 0.0;
    private const MAX_ABILITY = 100.0;
    private const K_FACTOR = 16.0;   // how fast ability moves per answer
    private const ELO_SCALE = 25.0;  // spread of the logistic curve

    private const DEFAULT_MAX_QUESTIONS = 12;

    /** Landing / start screen for an adaptive test. */
    public function show(Test $test)
    {
        $pool = $test->questions()->where('is_pooled', true)->count();

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

        $session = AdaptiveSession::where('user_id', Auth::id())
            ->where('test_id', $test->id)
            ->where('status', 'in_progress')
            ->latest()
            ->first();

        if (!$session) {
            $session = AdaptiveSession::create([
                'user_id'            => Auth::id(),
                'test_id'            => $test->id,
                'ability'            => self::START_ABILITY,
                'current_difficulty' => $this->abilityToDifficulty(self::START_ABILITY),
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

    /** Grade the pending answer, update the Elo rating, return next question or finish. */
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

        $option = $question->options->firstWhere('id', (int) $data['option_id']);
        if (!$option) {
            return response()->json(['message' => 'Invalid option.'], 422);
        }

        $isCorrect = (bool) $option->is_correct;
        $correctOption = $question->options->firstWhere('is_correct', true);

        // --- Elo update ---
        $ability    = (float) $session->ability;
        $qRating    = $this->difficultyToRating((int) $question->difficulty);
        $expected   = 1 / (1 + pow(10, ($qRating - $ability) / self::ELO_SCALE));
        $actual     = $isCorrect ? 1.0 : 0.0;
        $ability   += self::K_FACTOR * ($actual - $expected);
        $ability    = max(self::MIN_ABILITY, min(self::MAX_ABILITY, $ability));

        $session->ability = round($ability, 2);
        $session->current_difficulty = $this->abilityToDifficulty($ability);

        if ($isCorrect) {
            $session->correct_count++;
        } else {
            $session->wrong_count++;
        }
        $session->questions_answered++;

        $log = $session->log ?? [];
        $log[] = [
            'question_id' => $question->id,
            'difficulty'  => (int) $question->difficulty,
            'ability'     => round($ability, 1),
            'correct'     => $isCorrect,
        ];
        $session->log = $log;
        $session->pending_question_id = null;
        $session->save();

        $feedback = [
            'correct'           => $isCorrect,
            'correct_option_id' => $correctOption?->id,
            'explanation'       => $question->explanation,
            'ability'           => (int) round($ability),
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

    /** Final result page with the ability-progression graph. */
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
     * Pick the next unseen question whose difficulty best matches the user's
     * current ability, and return the JSON payload the front-end renders.
     */
    private function serveNext(AdaptiveSession $session): array
    {
        $served = $session->served_ids ?? [];
        $target = $this->abilityToDifficulty((float) $session->ability);
        $question = $this->pickQuestion($session->test_id, $target, $served);

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
            'ability'  => (int) round($session->ability),
            'question' => [
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

    /** Close the session: final ability becomes the 0–100 skill score + band. */
    private function finalize(AdaptiveSession $session): void
    {
        $ability = (float) $session->ability;
        $score = (int) round($ability);
        $score = max(0, min(100, $score));

        $session->final_score = $score;
        $session->final_level = round($ability / 10, 1); // legacy 0–10 representation
        $session->final_band  = $this->band($ability);
        $session->status = 'completed';
        $session->completed_at = now();
        $session->save();
    }

    /** Map a 1–10 question difficulty to a 0–100 rating (centre of its band). */
    private function difficultyToRating(int $difficulty): float
    {
        $difficulty = max(self::MIN_DIFFICULTY, min(self::MAX_DIFFICULTY, $difficulty));
        return ($difficulty - 0.5) * 10; // 1 → 5, 5 → 45, 10 → 95
    }

    /** Map a 0–100 ability back to the closest 1–10 difficulty band. */
    private function abilityToDifficulty(float $ability): int
    {
        $d = (int) round($ability / 10 + 0.5);
        return max(self::MIN_DIFFICULTY, min(self::MAX_DIFFICULTY, $d));
    }

    private function band(float $ability): string
    {
        return match (true) {
            $ability < 20 => 'Beginner',
            $ability < 40 => 'Elementary',
            $ability < 60 => 'Intermediate',
            $ability < 80 => 'Advanced',
            default       => 'Expert',
        };
    }

    private function authorizeSession(AdaptiveSession $session): void
    {
        if ($session->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
