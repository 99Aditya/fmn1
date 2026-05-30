<?php

namespace App\Services;

use App\Models\Test;
use App\Models\TestAttempt;
use Illuminate\Support\Arr;

class TestScoringService
{
    public function score(TestAttempt $attempt, array $answers): void
    {
        $test      = $attempt->test()->with('questions.options')->first();
        $questions = $test->questions->keyBy('id');

        $correct = 0;
        $wrong   = 0;
        $score   = 0;

        $toInsert = [];

        foreach ($answers as $questionId => $selectedOptionId) {
            $question = $questions->get($questionId);
            if (! $question) {
                continue;
            }

            $correctOption = $question->options->firstWhere('is_correct', 1);
            $isCorrect     = $correctOption && $correctOption->id == $selectedOptionId;

            if ($isCorrect) {
                $correct++;
                $score += $question->marks;
            } else {
                $wrong++;
            }

            $toInsert[] = [
                'attempt_id'         => $attempt->id,
                'question_id'        => $questionId,
                'selected_option_id' => $selectedOptionId ?: null,
                'is_correct'         => $isCorrect ? 1 : 0,
                'created_at'         => now(),
                'updated_at'         => now(),
            ];
        }

        \App\Models\AttemptAnswer::insert($toInsert);

        $totalQuestions = $questions->count();
        $totalMarks     = $test->total_marks ?: 1;
        $percentage     = round(($score / $totalMarks) * 100, 2);
        $passed         = $score >= $test->passing_marks;
        $certEarned     = $test->has_certificate && $percentage >= $test->certificate_min_score;

        $attempt->update([
            'score'            => $score,
            'correct_answers'  => $correct,
            'wrong_answers'    => $wrong,
            'total_questions'  => $totalQuestions,
            'percentage'       => $percentage,
            'passed'           => $passed,
            'certificate_earned' => $certEarned,
            'completed_at'     => now(),
        ]);

        $this->updateTestStats($test);
    }

    private function updateTestStats(Test $test): void
    {
        $attempts     = $test->attempts()->whereNotNull('completed_at');
        $totalCount   = $attempts->count();
        $passedCount  = $attempts->where('passed', 1)->count();
        $avgScore     = $attempts->avg('percentage') ?? 0;
        $successRate  = $totalCount > 0 ? round(($passedCount / $totalCount) * 100, 2) : 0;

        $test->update([
            'total_attempts' => $totalCount,
            'avg_score'      => $avgScore,
            'success_rate'   => $successRate,
        ]);
    }
}
