@extends('admin.layout.index')
@section('title', 'Bulk Upload Tests')
@section('content')

<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">

        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8">
              <h4>Bulk Upload Tests</h4>
            </div>
            <div class="col-lg-4">
              <ul class="breadcrumb-title">
                <li class="breadcrumb-item"><a href="{{ route('admin.tests.index') }}">Tests</a></li>
                <li class="breadcrumb-item active">Bulk Upload</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="page-body">
          <div class="row">
            <div class="col-lg-8">

              @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
              @endif
              @if(session('bulk_errors'))
                <div class="alert alert-warning">
                  <strong>Skipped rows:</strong>
                  <ul class="mb-0 mt-1">
                    @foreach(session('bulk_errors') as $err)
                      <li>{{ $err }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
              @endif

              {{-- Available categories --}}
              @if($categories->count())
                <div class="alert alert-info">
                  <strong>Available category slugs</strong> (use these in the <code>category_slug</code> column):
                  <div class="mt-1">
                    @foreach($categories as $cat)
                      <code class="mr-2">{{ $cat->slug }}</code>
                    @endforeach
                  </div>
                </div>
              @else
                <div class="alert alert-warning">
                  No test categories found. <a href="{{ route('admin.categories.create') }}">Create one first</a>.
                </div>
              @endif

              <div class="card">
                <div class="card-header"><h5 class="mb-0">Upload CSV File</h5></div>
                <div class="card-block">
                  <form action="{{ route('admin.bulk.tests.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label>Select CSV File <span class="text-danger">*</span></label>
                      <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required>
                      <small class="text-muted">Max 2MB.</small>
                    </div>
                    <div class="d-flex gap-2">
                      <button type="submit" class="btn btn-success">
                        <i class="feather icon-upload mr-1"></i> Import Tests
                      </button>
                      <a href="{{ route('admin.bulk.tests.template') }}" class="btn btn-outline-secondary">
                        <i class="feather icon-download mr-1"></i> Download Template
                      </a>
                      <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                  </form>
                </div>
              </div>

              <div class="card mt-3">
                <div class="card-header"><h5 class="mb-0">CSV Format Guide</h5></div>
                <div class="card-block">
                  <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                      <thead class="thead-light">
                        <tr><th>Column</th><th>Required</th><th>Values / Notes</th></tr>
                      </thead>
                      <tbody>
                        <tr><td><code>title</code></td><td><span class="badge badge-danger">Yes</span></td><td>Test title</td></tr>
                        <tr><td><code>category_slug</code></td><td><span class="badge badge-danger">Yes</span></td><td>Must match an existing category slug</td></tr>
                        <tr><td><code>description</code></td><td><span class="badge badge-secondary">No</span></td><td>Short description</td></tr>
                        <tr><td><code>total_time</code></td><td><span class="badge badge-secondary">No</span></td><td>Minutes (default: 30)</td></tr>
                        <tr><td><code>passing_marks</code></td><td><span class="badge badge-secondary">No</span></td><td>Integer (default: 0)</td></tr>
                        <tr><td><code>difficulty</code></td><td><span class="badge badge-secondary">No</span></td><td>beginner / intermediate / advanced</td></tr>
                        <tr><td><code>has_certificate</code></td><td><span class="badge badge-secondary">No</span></td><td>yes / no (default: no)</td></tr>
                        <tr><td><code>certificate_min_score</code></td><td><span class="badge badge-secondary">No</span></td><td>0–100 (default: 70)</td></tr>
                        <tr><td><code>status</code></td><td><span class="badge badge-secondary">No</span></td><td>draft / published (default: draft)</td></tr>
                        <tr><td><code>hashtags</code></td><td><span class="badge badge-secondary">No</span></td><td>Comma-separated tags</td></tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header"><h5 class="mb-0">After Import</h5></div>
                <div class="card-block">
                  <ul class="list-unstyled">
                    <li class="mb-2"><i class="feather icon-check-circle text-success mr-1"></i> Tests are created as <strong>draft</strong> by default</li>
                    <li class="mb-2"><i class="feather icon-check-circle text-success mr-1"></i> Go to Tests → Questions to add questions</li>
                    <li class="mb-2"><i class="feather icon-check-circle text-success mr-1"></i> Or use the questions bulk upload per test</li>
                    <li class="mb-2"><i class="feather icon-check-circle text-success mr-1"></i> Change status to <strong>published</strong> when ready</li>
                  </ul>
                  <a href="{{ route('admin.bulk.tests.template') }}" class="btn btn-block btn-outline-primary">
                    <i class="feather icon-download mr-1"></i> Download Template CSV
                  </a>
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
