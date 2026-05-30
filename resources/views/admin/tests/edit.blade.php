@extends('admin.layout.index')
@section('title', 'Edit Test')
@section('content')

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8"><h4>Edit Test: {{ $test->title }}</h4></div>
                        <div class="col-lg-4">
                            <ul class="breadcrumb-title">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.tests.index') }}">Tests</a></li>
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
                                    <form action="{{ route('admin.tests.update', $test) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Title <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" class="form-control" value="{{ old('title', $test->title) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Category <span class="text-danger">*</span></label>
                                                    <select name="category_id" class="form-control" required>
                                                        <option value="">-- Select --</option>
                                                        @foreach($categories as $cat)
                                                            <option value="{{ $cat->id }}" {{ old('category_id', $test->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="3">{{ old('description', $test->description) }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Time Limit (minutes) <span class="text-danger">*</span></label>
                                                    <input type="number" name="total_time" class="form-control" value="{{ old('total_time', $test->total_time) }}" min="1" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Passing Marks <span class="text-danger">*</span></label>
                                                    <input type="number" name="passing_marks" class="form-control" value="{{ old('passing_marks', $test->passing_marks) }}" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Difficulty <span class="text-danger">*</span></label>
                                                    <select name="difficulty" class="form-control" required>
                                                        @foreach(['beginner', 'intermediate', 'advanced'] as $d)
                                                            <option value="{{ $d }}" {{ old('difficulty', $test->difficulty) == $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Status <span class="text-danger">*</span></label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="draft" {{ old('status', $test->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                        <option value="published" {{ old('status', $test->status) == 'published' ? 'selected' : '' }}>Published</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="d-flex align-items-center gap-2">
                                                        <input type="checkbox" name="has_certificate" value="1" {{ old('has_certificate', $test->has_certificate) ? 'checked' : '' }} id="hasCert">
                                                        Issue Certificate on Pass
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="certMinScore">
                                                <div class="form-group">
                                                    <label>Min Score for Certificate (%)</label>
                                                    <input type="number" name="certificate_min_score" class="form-control" value="{{ old('certificate_min_score', $test->certificate_min_score) }}" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Hashtags (comma separated)</label>
                                            <input type="text" name="hashtags" class="form-control" value="{{ old('hashtags', $test->hashtags) }}">
                                        </div>
                                        <div class="form-group">
                                            <label>YouTube Video Link</label>
                                            <input type="url" name="youtube_video_link" class="form-control" value="{{ old('youtube_video_link', $test->youtube_video_link) }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Test</button>
                                        <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">Cancel</a>
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

@push('admin_custom_scripts')
<script>
    const hasCert = document.getElementById('hasCert');
    const certBox = document.getElementById('certMinScore');
    certBox.style.display = hasCert.checked ? 'block' : 'none';
    hasCert.addEventListener('change', () => {
        certBox.style.display = hasCert.checked ? 'block' : 'none';
    });
</script>
@endpush
@endsection
