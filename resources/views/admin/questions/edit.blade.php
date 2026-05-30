@extends('admin.layout.index')
@section('title', 'Edit Question')
@section('content')

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8"><h4>Edit Question — {{ $test->title }}</h4></div>
                        <div class="col-lg-4">
                            <ul class="breadcrumb-title">
                                <li class="breadcrumb-item"><a href="{{ route('admin.tests.index') }}">Tests</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.tests.questions.index', $test) }}">Questions</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-block">
                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                                        </div>
                                    @endif
                                    <form action="{{ route('admin.tests.questions.update', [$test, $question]) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="form-group">
                                            <label>Question <span class="text-danger">*</span></label>
                                            <textarea name="question" class="form-control" rows="3" required>{{ old('question', $question->question) }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Marks <span class="text-danger">*</span></label>
                                            <input type="number" name="marks" class="form-control" value="{{ old('marks', $question->marks) }}" min="1" style="width: 120px" required>
                                        </div>

                                        <hr>
                                        <h6>Options <small class="text-muted">(select the correct answer)</small></h6>

                                        @php
                                            $letters = ['A', 'B', 'C', 'D'];
                                            $oldCorrect = old('correct');
                                            if ($oldCorrect === null) {
                                                $correctIdx = $question->options->search(fn($o) => $o->is_correct);
                                            } else {
                                                $correctIdx = $oldCorrect;
                                            }
                                        @endphp

                                        @for($i = 0; $i < 4; $i++)
                                            @php $opt = $question->options->get($i); @endphp
                                            <div class="form-group d-flex align-items-center gap-2">
                                                <div class="mr-3">
                                                    <label class="d-flex align-items-center">
                                                        <input type="radio" name="correct" value="{{ $i }}" {{ $correctIdx == $i ? 'checked' : '' }} required class="mr-2">
                                                        <span class="badge badge-secondary">{{ $letters[$i] }}</span>
                                                    </label>
                                                </div>
                                                <input type="text" name="options[]" class="form-control"
                                                    value="{{ old("options.$i", $opt?->option_text) }}"
                                                    placeholder="Option {{ $letters[$i] }}" required>
                                            </div>
                                        @endfor

                                        <div class="form-group">
                                            <label>Explanation <small class="text-muted">(shown after answering)</small></label>
                                            <textarea name="explanation" class="form-control" rows="2">{{ old('explanation', $question->explanation) }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update Question</button>
                                        <a href="{{ route('admin.tests.questions.index', $test) }}" class="btn btn-secondary">Cancel</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
