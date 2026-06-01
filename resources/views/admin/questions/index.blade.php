@extends('admin.layout.index')
@section('title', 'Questions')
@section('content')

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <h4>Questions: {{ $test->title }}</h4>
                            <p class="text-muted mb-0">{{ $questions->count() }} questions &bull; {{ $test->total_marks }} total marks &bull; {{ $test->total_time }} min</p>
                        </div>
                        <div class="col-lg-4">
                            <ul class="breadcrumb-title">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.tests.index') }}">Tests</a></li>
                                <li class="breadcrumb-item active">Questions</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5>Question List</h5>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.bulk.questions.form', $test) }}" class="btn btn-info">
                                                <i class="feather icon-upload-cloud mr-1"></i> Bulk Upload CSV
                                            </a>
                                            <a href="{{ route('admin.tests.questions.create', $test) }}" class="btn btn-success">Add Question</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @forelse($questions as $q)
                                        <div class="card mb-3 border">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div class="flex-grow-1">
                                                        @php
                                                            $lvl = (int) $q->difficulty;
                                                            $d = match (true) {
                                                                $lvl <= 2 => ['Very Easy', 'secondary'],
                                                                $lvl <= 4 => ['Easy', 'success'],
                                                                $lvl <= 6 => ['Medium', 'info'],
                                                                $lvl <= 8 => ['Hard', 'warning'],
                                                                default   => ['Very Hard', 'danger'],
                                                            };
                                                        @endphp
                                                        <p class="mb-1">
                                                            <strong>Q{{ $loop->iteration }}.</strong> {{ $q->question }}
                                                            <span class="badge badge-info ml-2">{{ $q->marks }} mark{{ $q->marks > 1 ? 's' : '' }}</span>
                                                            <span class="badge badge-{{ $d[1] }} ml-1">Lvl {{ $q->difficulty }}/10 · {{ $d[0] }}</span>
                                                            @if($q->is_pooled)
                                                                <span class="badge badge-success ml-1"><i class="feather icon-check"></i> Adaptive pool</span>
                                                            @else
                                                                <span class="badge badge-secondary ml-1">Not pooled</span>
                                                            @endif
                                                            @if($q->topic)<span class="badge badge-light ml-1"><i class="feather icon-tag"></i> {{ $q->topic }}</span>@endif
                                                        </p>
                                                        <div class="row mt-2">
                                                            @foreach($q->options as $i => $opt)
                                                                <div class="col-md-6 mb-1">
                                                                    <span class="badge badge-{{ $opt->is_correct ? 'success' : 'secondary' }} mr-1">
                                                                        {{ chr(65 + $i) }}
                                                                    </span>
                                                                    {{ $opt->option_text }}
                                                                    @if($opt->is_correct)
                                                                        <i class="feather icon-check-circle text-success ml-1"></i>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        @if($q->explanation)
                                                            <p class="mt-2 mb-0 text-muted small"><strong>Explanation:</strong> {{ $q->explanation }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="ml-3 d-flex flex-column gap-1">
                                                        <a href="{{ route('admin.tests.questions.edit', [$test, $q]) }}" class="btn btn-sm btn-primary mb-1">Edit</a>
                                                        <form action="{{ route('admin.tests.questions.destroy', [$test, $q]) }}" method="POST" onsubmit="return confirm('Delete this question?')">
                                                            @csrf @method('DELETE')
                                                            <button class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-5">
                                            <p>No questions yet. <a href="{{ route('admin.tests.questions.create', $test) }}">Add your first question</a>.</p>
                                        </div>
                                    @endforelse
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
