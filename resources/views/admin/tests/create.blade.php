@extends('admin.layout.index')
@section('title', 'Add Test')
@section('content')

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8"><h4>Add New Test</h4></div>
                        <div class="col-lg-4">
                            <ul class="breadcrumb-title">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.tests.index') }}">Tests</a></li>
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
                                    <form action="{{ route('admin.tests.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>Title <span class="text-danger">*</span></label>
                                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Category <span class="text-danger">*</span></label>
                                                    <select name="category_id" class="form-control" required>
                                                        <option value="">-- Select --</option>
                                                        @foreach($categories as $cat)
                                                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Time Limit (minutes) <span class="text-danger">*</span></label>
                                                    <input type="number" name="total_time" class="form-control" value="{{ old('total_time', 30) }}" min="1" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Passing Marks <span class="text-danger">*</span></label>
                                                    <input type="number" name="passing_marks" class="form-control" value="{{ old('passing_marks', 0) }}" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Difficulty <span class="text-danger">*</span></label>
                                                    <select name="difficulty" class="form-control" required>
                                                        <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                                        <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                        <option value="advanced" {{ old('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Status <span class="text-danger">*</span></label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="d-flex align-items-center gap-2">
                                                        <input type="checkbox" name="has_certificate" value="1" {{ old('has_certificate') ? 'checked' : '' }} id="hasCert">
                                                        Issue Certificate on Pass
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-4" id="certMinScore">
                                                <div class="form-group">
                                                    <label>Min Score for Certificate (%)</label>
                                                    <input type="number" name="certificate_min_score" class="form-control" value="{{ old('certificate_min_score', 70) }}" min="0" max="100">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Hashtags (comma separated)</label>
                                            <input type="text" name="hashtags" class="form-control" value="{{ old('hashtags') }}" placeholder="php, laravel, backend">
                                        </div>
                                        <div class="form-group">
                                            <label>YouTube Video Link</label>
                                            <input type="url" name="youtube_video_link" class="form-control" value="{{ old('youtube_video_link') }}">
                                        </div>
                                        <button type="submit" class="btn btn-success">Save Test</button>
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
