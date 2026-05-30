@extends('admin.layout.index')
@section('title', 'Tests')
@section('content')

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <h4>MCQ Tests</h4>
                        </div>
                        <div class="col-lg-4">
                            <ul class="breadcrumb-title">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item active">Tests</li>
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
                                        <h5>All Tests</h5>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.bulk.tests.form') }}" class="btn btn-info">
                                                <i class="feather icon-upload-cloud mr-1"></i> Bulk Upload
                                            </a>
                                            <a href="{{ route('admin.tests.create') }}" class="btn btn-success">Add Test</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <div class="table-responsive">
                                        <table id="dt-basic" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    <th>Questions</th>
                                                    <th>Time</th>
                                                    <th>Difficulty</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($tests as $test)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $test->title }}</td>
                                                        <td>{{ $test->category->name ?? '-' }}</td>
                                                        <td>{{ $test->questions_count }}</td>
                                                        <td>{{ $test->total_time }} min</td>
                                                        <td>
                                                            <span class="badge badge-{{ $test->difficulty === 'beginner' ? 'success' : ($test->difficulty === 'intermediate' ? 'warning' : 'danger') }}">
                                                                {{ ucfirst($test->difficulty) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ $test->status === 'published' ? 'success' : 'secondary' }}">
                                                                {{ ucfirst($test->status) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.tests.questions.index', $test) }}" class="btn btn-sm btn-info" title="Questions">
                                                                <i class="feather icon-list"></i> Questions
                                                            </a>
                                                            <a href="{{ route('admin.tests.edit', $test) }}" class="btn btn-sm btn-primary">Edit</a>
                                                            <form action="{{ route('admin.tests.destroy', $test) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this test and all its questions?')">
                                                                @csrf @method('DELETE')
                                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="8" class="text-center text-muted">No tests found</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('admin_custom_scripts')
<script>
    $(document).ready(function() {
        $('#dt-basic').dataTable({ "sPaginationType": "full_numbers" });
    });
</script>
@endpush
@endsection
