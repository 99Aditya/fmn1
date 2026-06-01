<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Test;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Test $test)
    {
        $questions = $test->questions()->with('options')->orderBy('question_order')->get();
        return view('admin.questions.index', compact('test', 'questions'));
    }

    public function create(Test $test)
    {
        return view('admin.questions.create', compact('test'));
    }

    public function store(Request $request, Test $test)
    {
        $request->validate([
            'question'    => 'required|string',
            'explanation' => 'nullable|string',
            'marks'       => 'required|integer|min:1',
            'difficulty'  => 'required|integer|min:1|max:10',
            'topic'       => 'nullable|string|max:120',
            'is_pooled'   => 'nullable|boolean',
            'options'     => 'required|array|min:2',
            'options.*'   => 'required|string',
            'correct'     => 'required|integer',
        ]);

        $order = $test->questions()->max('question_order') + 1;

        $question = $test->questions()->create([
            'question'       => $request->question,
            'explanation'    => $request->explanation,
            'marks'          => $request->marks,
            'difficulty'     => $request->difficulty,
            'topic'          => $request->topic,
            'is_pooled'      => $request->boolean('is_pooled'),
            'question_order' => $order,
        ]);

        foreach ($request->options as $i => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct'  => ($i == $request->correct) ? 1 : 0,
            ]);
        }

        $this->syncTestTotals($test);

        return redirect()->route('admin.tests.questions.index', $test)->with('success', 'Question added.');
    }

    public function edit(Test $test, Question $question)
    {
        $question->load('options');
        return view('admin.questions.edit', compact('test', 'question'));
    }

    public function update(Request $request, Test $test, Question $question)
    {
        $request->validate([
            'question'    => 'required|string',
            'explanation' => 'nullable|string',
            'marks'       => 'required|integer|min:1',
            'difficulty'  => 'required|integer|min:1|max:10',
            'topic'       => 'nullable|string|max:120',
            'is_pooled'   => 'nullable|boolean',
            'options'     => 'required|array|min:2',
            'options.*'   => 'required|string',
            'correct'     => 'required|integer',
        ]);

        $question->update([
            'question'    => $request->question,
            'explanation' => $request->explanation,
            'marks'       => $request->marks,
            'difficulty'  => $request->difficulty,
            'topic'       => $request->topic,
            'is_pooled'   => $request->boolean('is_pooled'),
        ]);

        $question->options()->delete();

        foreach ($request->options as $i => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct'  => ($i == $request->correct) ? 1 : 0,
            ]);
        }

        $this->syncTestTotals($test);

        return redirect()->route('admin.tests.questions.index', $test)->with('success', 'Question updated.');
    }

    public function destroy(Test $test, Question $question)
    {
        $question->delete();
        $this->syncTestTotals($test);
        return redirect()->route('admin.tests.questions.index', $test)->with('success', 'Question deleted.');
    }

    private function syncTestTotals(Test $test): void
    {
        $test->refresh();
        $total_questions = $test->questions()->count();
        $total_marks     = $test->questions()->sum('marks');
        $test->update([
            'total_questions' => $total_questions,
            'total_marks'     => $total_marks,
        ]);
    }
}
