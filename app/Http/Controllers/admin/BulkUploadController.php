<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BulkUploadController extends Controller
{
    /* ────────────────────────────────────────────────
     |  QUESTIONS BULK UPLOAD
     |  CSV columns: question, option_a, option_b, option_c, option_d, correct (A/B/C/D), marks, explanation, difficulty (1-5), topic
     * ──────────────────────────────────────────────── */

    public function questionsForm(Test $test)
    {
        return view('admin.bulk.questions', compact('test'));
    }

    public function questionsImport(Request $request, Test $test)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file   = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');

        // skip header row
        $header = fgetcsv($handle);

        $imported = 0;
        $errors   = [];
        $order    = $test->questions()->max('question_order') ?? 0;

        while (($row = fgetcsv($handle)) !== false) {
            // skip blank rows
            if (count(array_filter($row)) === 0) continue;

            [$question, $optA, $optB, $optC, $optD, $correct, $marks, $explanation, $difficulty, $topic] = array_pad($row, 10, '');

            $question = trim($question);
            $correct  = strtoupper(trim($correct));

            // Difficulty must be 1–5; default to 2 (Easy) when missing/invalid.
            $difficulty = (int) trim($difficulty);
            if ($difficulty < 1 || $difficulty > 5) {
                $difficulty = 2;
            }

            if (empty($question)) {
                $errors[] = "Row " . ($imported + 2) . ": question text is empty — skipped.";
                continue;
            }

            $options = [
                'A' => trim($optA),
                'B' => trim($optB),
                'C' => trim($optC),
                'D' => trim($optD),
            ];

            if (!array_key_exists($correct, $options)) {
                $errors[] = "Row " . ($imported + 2) . ": correct column must be A, B, C or D — skipped.";
                continue;
            }

            $order++;
            $q = $test->questions()->create([
                'question'       => $question,
                'explanation'    => trim($explanation),
                'marks'          => max(1, (int) $marks ?: 1),
                'difficulty'     => $difficulty,
                'topic'          => trim($topic) ?: null,
                'is_pooled'      => true,
                'question_order' => $order,
            ]);

            foreach ($options as $letter => $text) {
                if (empty($text)) continue;
                $q->options()->create([
                    'option_text' => $text,
                    'is_correct'  => ($letter === $correct) ? 1 : 0,
                ]);
            }

            $imported++;
        }

        fclose($handle);
        $this->syncTotals($test);

        $message = "Imported {$imported} question(s) successfully.";
        if ($errors) {
            $message .= ' ' . count($errors) . ' row(s) skipped.';
        }

        return redirect()
            ->route('admin.tests.questions.index', $test)
            ->with('success', $message)
            ->with('bulk_errors', $errors);
    }

    public function questionsTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="questions_template.csv"',
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct', 'marks', 'explanation', 'difficulty', 'topic']);
            fputcsv($out, [
                'What does PHP stand for?',
                'PHP: Hypertext Preprocessor',
                'Private Home Page',
                'Personal Hypertext Processor',
                'Preprocessor Home PHP',
                'A',
                '1',
                'PHP originally stood for Personal Home Page but now stands for PHP: Hypertext Preprocessor.',
                '1',
                'basics',
            ]);
            fputcsv($out, [
                'Which keyword is used to define a function in Python?',
                'func', 'def', 'function', 'define',
                'B', '1', 'In Python, the "def" keyword is used to define a function.',
                '2', 'functions',
            ]);
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /* ────────────────────────────────────────────────
     |  TESTS BULK UPLOAD
     |  CSV: title, category_slug, description, total_time, passing_marks, difficulty, has_certificate, certificate_min_score, status, hashtags
     * ──────────────────────────────────────────────── */

    public function testsForm()
    {
        $categories = Category::forTests()->orderBy('name')->get();
        return view('admin.bulk.tests', compact('categories'));
    }

    public function testsImport(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file   = $request->file('csv_file');
        $handle = fopen($file->getRealPath(), 'r');
        fgetcsv($handle); // skip header

        $imported = 0;
        $errors   = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count(array_filter($row)) === 0) continue;

            [
                $title, $categorySlug, $description, $totalTime,
                $passingMarks, $difficulty, $hasCert, $certMinScore,
                $status, $hashtags
            ] = array_pad($row, 10, '');

            $title = trim($title);
            if (empty($title)) {
                $errors[] = "Row " . ($imported + 2) . ": title is empty — skipped.";
                continue;
            }

            $category = Category::where('slug', trim($categorySlug))->where('type', 'test')->first();
            if (!$category) {
                $errors[] = "Row " . ($imported + 2) . ": category '{$categorySlug}' not found — skipped.";
                continue;
            }

            $difficulty = in_array(strtolower(trim($difficulty)), ['beginner', 'intermediate', 'advanced'])
                ? strtolower(trim($difficulty)) : 'beginner';

            $status = in_array(strtolower(trim($status)), ['draft', 'published'])
                ? strtolower(trim($status)) : 'draft';

            Test::create([
                'category_id'           => $category->id,
                'title'                 => $title,
                'slug'                  => Str::slug($title) . '-' . Str::random(4),
                'description'           => trim($description),
                'total_time'            => max(1, (int) $totalTime ?: 30),
                'passing_marks'         => max(0, (int) $passingMarks ?: 0),
                'difficulty'            => $difficulty,
                'has_certificate'       => in_array(strtolower(trim($hasCert)), ['1', 'yes', 'true']) ? 1 : 0,
                'certificate_min_score' => max(0, (int) $certMinScore ?: 70),
                'status'                => $status,
                'hashtags'              => trim($hashtags),
            ]);

            $imported++;
        }

        fclose($handle);

        $message = "Imported {$imported} test(s) successfully.";
        if ($errors) $message .= ' ' . count($errors) . ' row(s) skipped.';

        return redirect()->route('admin.tests.index')
            ->with('success', $message)
            ->with('bulk_errors', $errors);
    }

    public function testsTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="tests_template.csv"',
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['title', 'category_slug', 'description', 'total_time', 'passing_marks', 'difficulty', 'has_certificate', 'certificate_min_score', 'status', 'hashtags']);
            fputcsv($out, ['PHP Basics Quiz', 'php', 'Test your PHP fundamentals', '30', '5', 'beginner', 'yes', '70', 'published', 'php,basics']);
            fputcsv($out, ['Advanced JavaScript', 'javascript', 'ES6+ concepts and patterns', '45', '8', 'advanced', 'yes', '80', 'published', 'js,es6,advanced']);
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function syncTotals(Test $test): void
    {
        $test->refresh();
        $test->update([
            'total_questions' => $test->questions()->count(),
            'total_marks'     => $test->questions()->sum('marks'),
        ]);
    }
}
