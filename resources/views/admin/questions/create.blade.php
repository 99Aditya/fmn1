@extends('admin.layout.index')
@section('title', 'Add Question')
@section('content')

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8"><h4>Add Question — {{ $test->title }}</h4></div>
                        <div class="col-lg-4">
                            <ul class="breadcrumb-title">
                                <li class="breadcrumb-item"><a href="{{ route('admin.tests.index') }}">Tests</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.tests.questions.index', $test) }}">Questions</a></li>
                                <li class="breadcrumb-item active">Add</li>
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
                                    <form action="{{ route('admin.tests.questions.store', $test) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Question <span class="text-danger">*</span></label>
                                            <textarea name="question" class="form-control" rows="3" required>{{ old('question') }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Marks <span class="text-danger">*</span></label>
                                                    <input type="number" name="marks" class="form-control" value="{{ old('marks', 1) }}" min="1" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Difficulty <span class="text-danger">*</span> <small class="text-muted">(adaptive)</small></label>
                                                    <select name="difficulty" class="form-control" required>
                                                        @php $bands = [1=>'Very Easy',2=>'Very Easy',3=>'Easy',4=>'Easy',5=>'Medium',6=>'Medium',7=>'Hard',8=>'Hard',9=>'Very Hard',10=>'Very Hard']; @endphp
                                                        @for($v = 1; $v <= 10; $v++)
                                                            <option value="{{ $v }}" {{ old('difficulty', 5) == $v ? 'selected' : '' }}>{{ $v }} — {{ $bands[$v] }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Topic <small class="text-muted">(optional)</small></label>
                                                    <input type="text" name="topic" class="form-control" value="{{ old('topic') }}" placeholder="e.g. closures">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-flex align-items-center" style="gap:8px">
                                                <input type="checkbox" name="is_pooled" value="1" {{ old('is_pooled', '1') ? 'checked' : '' }}>
                                                <span>Include in the <strong>adaptive</strong> question pool</span>
                                            </label>
                                        </div>

                                        <hr>
                                        <h6>Options <small class="text-muted">(select the correct answer)</small></h6>

                                        @php $letters = ['A', 'B', 'C', 'D']; @endphp
                                        @for($i = 0; $i < 4; $i++)
                                            <div class="form-group d-flex align-items-center gap-2">
                                                <div class="mr-3">
                                                    <label class="d-flex align-items-center">
                                                        <input type="radio" name="correct" value="{{ $i }}" {{ old('correct', 0) == $i ? 'checked' : '' }} required class="mr-2">
                                                        <span class="badge badge-secondary">{{ $letters[$i] }}</span>
                                                    </label>
                                                </div>
                                                <input type="text" name="options[]" class="form-control" value="{{ old("options.$i") }}" placeholder="Option {{ $letters[$i] }}" required>
                                            </div>
                                        @endfor

                                        <div class="form-group">
                                            <label>Explanation <small class="text-muted">(shown after answering)</small></label>
                                            <textarea name="explanation" class="form-control" rows="2">{{ old('explanation') }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success">Save Question</button>
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
