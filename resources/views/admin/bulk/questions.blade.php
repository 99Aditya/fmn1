@extends('admin.layout.index')
@section('title', 'Bulk Upload Questions')
@section('content')

<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">

        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8">
              <h4>Bulk Upload Questions</h4>
              <p class="text-muted mb-0">Test: <strong>{{ $test->title }}</strong></p>
            </div>
            <div class="col-lg-4">
              <ul class="breadcrumb-title">
                <li class="breadcrumb-item"><a href="{{ route('admin.tests.index') }}">Tests</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tests.questions.index', $test) }}">Questions</a></li>
                <li class="breadcrumb-item active">Bulk Upload</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="page-body">
          <div class="row">
            <div class="col-lg-8">

              {{-- Success / errors --}}
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

              {{-- Upload card --}}
              <div class="card">
                <div class="card-header">
                  <h5 class="mb-0">Upload CSV File</h5>
                </div>
                <div class="card-block">
                  <form action="{{ route('admin.bulk.questions.import', $test) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label>Select CSV File <span class="text-danger">*</span></label>
                      <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required>
                      <small class="text-muted">Max 2MB. Must be a valid CSV file.</small>
                    </div>
                    <div class="d-flex gap-2">
                      <button type="submit" class="btn btn-success">
                        <i class="feather icon-upload mr-1"></i> Import Questions
                      </button>
                      <a href="{{ route('admin.bulk.questions.template', $test) }}" class="btn btn-outline-secondary">
                        <i class="feather icon-download mr-1"></i> Download Template
                      </a>
                      <a href="{{ route('admin.tests.questions.index', $test) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                  </form>
                </div>
              </div>

              {{-- Format guide --}}
              <div class="card mt-3">
                <div class="card-header">
                  <h5 class="mb-0">CSV Format Guide</h5>
                </div>
                <div class="card-block">
                  <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                      <thead class="thead-light">
                        <tr>
                          <th>Column</th>
                          <th>Required</th>
                          <th>Description</th>
                          <th>Example</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr><td><code>question</code></td><td><span class="badge badge-danger">Yes</span></td><td>The question text</td><td>What does HTML stand for?</td></tr>
                        <tr><td><code>option_a</code></td><td><span class="badge badge-danger">Yes</span></td><td>Option A text</td><td>HyperText Markup Language</td></tr>
                        <tr><td><code>option_b</code></td><td><span class="badge badge-danger">Yes</span></td><td>Option B text</td><td>Home Tool Markup Language</td></tr>
                        <tr><td><code>option_c</code></td><td><span class="badge badge-secondary">No</span></td><td>Option C text</td><td>Hyperlinks and Text Markup</td></tr>
                        <tr><td><code>option_d</code></td><td><span class="badge badge-secondary">No</span></td><td>Option D text</td><td>Hyper Transfer Markup Language</td></tr>
                        <tr><td><code>correct</code></td><td><span class="badge badge-danger">Yes</span></td><td>Correct option letter: A, B, C or D</td><td>A</td></tr>
                        <tr><td><code>marks</code></td><td><span class="badge badge-secondary">No</span></td><td>Marks for this question (default: 1)</td><td>1</td></tr>
                        <tr><td><code>explanation</code></td><td><span class="badge badge-secondary">No</span></td><td>Explanation shown after answering</td><td>HTML is HyperText Markup Language</td></tr>
                        <tr><td><code>difficulty</code></td><td><span class="badge badge-secondary">No</span></td><td>Adaptive difficulty 1–5 (1=very easy, 5=very hard; default 2)</td><td>3</td></tr>
                        <tr><td><code>topic</code></td><td><span class="badge badge-secondary">No</span></td><td>Sub-topic label for variety in adaptive sessions</td><td>arrays</td></tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="alert alert-info mt-3 mb-0">
                    <i class="feather icon-info mr-1"></i>
                    <strong>Tips:</strong>
                    <ul class="mb-0 mt-1">
                      <li>First row must be the header row (column names).</li>
                      <li>The <code>correct</code> column must be exactly <strong>A</strong>, <strong>B</strong>, <strong>C</strong>, or <strong>D</strong> (uppercase).</li>
                      <li>Wrap values containing commas in double quotes.</li>
                      <li>Blank rows are automatically skipped.</li>
                    </ul>
                  </div>
                </div>
              </div>

            </div>

            {{-- Preview panel --}}
            <div class="col-lg-4">
              <div class="card">
                <div class="card-header"><h5 class="mb-0">CSV Preview</h5></div>
                <div class="card-block">
                  <p class="text-muted small">Example CSV content:</p>
                  <pre class="bg-dark text-white p-3 rounded" style="font-size:.72rem;overflow-x:auto">question,option_a,option_b,option_c,option_d,correct,marks,explanation,difficulty,topic
"What is PHP?","Scripting lang","A database","A framework","An OS",A,1,"PHP is server-side",1,basics
"Which tag for links?","&lt;a&gt;","&lt;link&gt;","&lt;href&gt;","&lt;url&gt;",A,1,"&lt;a&gt; is the anchor tag",2,html</pre>
                  <a href="{{ route('admin.bulk.questions.template', $test) }}" class="btn btn-block btn-outline-primary mt-2">
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
