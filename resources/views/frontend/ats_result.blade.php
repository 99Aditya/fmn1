@extends('frontend.layouts.app')

@section('title', 'ATS Analysis Result')

@section('content')
<main class="container my-5">
  @php
    $score = $result['score'] ?? 0;
    if ($score >= 90) {
      $statusLabel = 'Excellent';
      $scoreClass = 'success';
      $scoreEmoji = '🌟';
    } elseif ($score >= 75) {
      $statusLabel = 'Good';
      $scoreClass = 'info';
      $scoreEmoji = '👍';
    } elseif ($score >= 55) {
      $statusLabel = 'Average';
      $scoreClass = 'warning';
      $scoreEmoji = '⚠️';
    } else {
      $statusLabel = 'Needs Improvement';
      $scoreClass = 'danger';
      $scoreEmoji = '❌';
    }
    $isPaid = data_get($job, 'paid', false);
    $details = $result['details'] ?? [];
    $sections = $result['sections'] ?? [];
    $breakdown = $result['breakdown'] ?? [];
    $suggestions = $result['suggestions'] ?? [];
    $notes = $result['notes'] ?? [];
    $rawResume = $result['raw'] ?? '';
    $basicSuggestions = array_slice($suggestions, 0, 3);
  @endphp

  <div class="card shadow-sm p-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
      <div>
        <h3 class="mb-1">ATS Analysis Result</h3>
        <p class="mb-1 text-muted">Job ID: <strong>{{ $id }}</strong></p>
        <span class="badge bg-{{ $scoreClass }} py-2 px-3 fs-6">{{ $statusLabel }} {{ $scoreEmoji }}</span>
        <span class="badge bg-{{ $isPaid ? 'primary' : 'warning' }} py-2 px-3 fs-6 ms-2">{{ $isPaid ? 'Premium Access' : 'Basic Scan' }}</span>
      </div>
      <div class="text-md-end">
        <div class="fs-1 fw-bold">{{ $score }}%</div>
        <div class="text-muted">Resume ATS friendliness score</div>
      </div>
    </div>

    @unless($isPaid)
      <div class="alert alert-warning rounded-3">
        This is a basic ATS scan. Unlock the full premium ATS DeepCheck and CV vs JD matching for deeper insights and smart interview preparation.
      </div>
    @endunless

    <div class="row g-3 mb-4">
      <div class="col-md-6 col-lg-4">
        <div class="border rounded p-3 h-100">
          <h6>Contact</h6>
          <p class="mb-1">Email: <strong>{{ $details['email'] ?? false ? '✅' : '❌' }}</strong></p>
          <p class="mb-1">Phone: <strong>{{ $details['phone'] ?? false ? '✅' : '❌' }}</strong></p>
          <p class="mb-1">Header: <strong>{{ $details['header'] ?? false ? '✅' : '❌' }}</strong></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="border rounded p-3 h-100">
          <h6>Structure</h6>
          <p class="mb-1">Summary: <strong>{{ $sections['summary'] ?? false ? '✅' : '❌' }}</strong></p>
          <p class="mb-1">Experience: <strong>{{ $sections['experience'] ?? false ? '✅' : '❌' }}</strong></p>
          <p class="mb-1">Skills: <strong>{{ $sections['skills'] ?? false ? '✅' : '❌' }}</strong></p>
        </div>
      </div>
      <div class="col-md-6 col-lg-4">
        <div class="border rounded p-3 h-100">
          <h6>Formatting</h6>
          <p class="mb-1">Bullets: <strong>{{ $details['bullets'] ?? false ? '✅' : '❌' }}</strong></p>
          <p class="mb-1">Headings: <strong>{{ $details['headings'] ?? false ? '✅' : '❌' }}</strong></p>
          <p class="mb-1">Dates: <strong>{{ $details['dates'] ?? false ? '✅' : '❌' }}</strong></p>
        </div>
      </div>
    </div>

    <div class="row gy-4">
      <div class="col-lg-8">
        <div class="border rounded p-3 h-100 bg-light">
          <h5>Upgrade for Deep Insights</h5>
          <p class="mb-3">Get the full resume audit with premium scoring, detailed issue mapping, and CV-to-JD match recommendations.</p>
          <p class="mb-2"><strong>Current strengths:</strong></p>
          <div class="mb-2">Keyword hits: <strong>{{ $breakdown['keywords_found'] ?? 0 }}</strong></div>
          <div class="mb-2">Metrics found: <strong>{{ $breakdown['metrics_found'] ?? 0 }}</strong></div>
          <div class="mb-2">Date ranges found: <strong>{{ $breakdown['date_ranges_found'] ?? 0 }}</strong></div>
          @unless($isPaid)
            <div class="mt-3">
              <span class="badge bg-primary">Premium upgrade available</span>
            </div>
          @endunless
        </div>
      </div>

      @if($isPaid)
        <div class="col-lg-4">
          <div class="border rounded p-3 h-100">
            <h5>Section Summary</h5>
            <ul class="list-group list-group-flush">
              @foreach($sections as $section => $found)
                <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-0">
                  <span>{{ ucfirst($section) }}</span>
                  <span class="badge bg-{{ $found ? 'success' : 'secondary' }} rounded-pill">{{ $found ? 'Detected' : 'Missing' }}</span>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="border rounded p-3 h-100">
            <h5>Top Suggestions</h5>
            <ul class="list-unstyled mb-0">
              @forelse($basicSuggestions as $s)
                <li class="mb-2">• {{ $s }}</li>
              @empty
                <li>No suggestions available.</li>
              @endforelse
            </ul>
          </div>
        </div>
      @else
        <div class="col-lg-4">
          <div class="border rounded p-3 h-100 text-center">
            <h5>Premium Exclusive</h5>
            <p class="mb-3">Section Summary and Top Suggestions are available only with premium access.</p>
            <button type="button" class="btn btn-primary">Upgrade now</button>
          </div>
        </div>
      @endif
    </div>

    @if($isPaid)
      <div class="row gy-4 mt-4">
        <div class="col-lg-6">
          <div class="border rounded p-3 h-100">
            <h5>Detailed Notes</h5>
            <ul class="list-unstyled mb-0">
              @forelse($notes as $note)
                <li class="mb-2">• {{ $note }}</li>
              @empty
                <li>No issues detected.</li>
              @endforelse
            </ul>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="border rounded p-3 h-100">
            <h5>Score Breakdown</h5>
            <ul class="list-unstyled mb-0">
              <li>Contact: <strong>{{ $breakdown['contact_score'] ?? 0 }}</strong></li>
              <li>Structure: <strong>{{ $breakdown['structure_score'] ?? 0 }}</strong></li>
              <li>Achievement: <strong>{{ $breakdown['achievement_score'] ?? 0 }}</strong></li>
              <li>Formatting: <strong>{{ $breakdown['format_score'] ?? 0 }}</strong></li>
              <li>Quality: <strong>{{ $breakdown['quality_score'] ?? 0 }}</strong></li>
              <li>Penalty: <strong>-{{ $breakdown['penalty'] ?? 0 }}</strong></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="mt-4">
        <h5>Resume Preview</h5>
        <pre class="p-3" style="max-height:300px;overflow:auto;background:#f8f9fa;border-radius:12px;">{{ $rawResume }}</pre>
      </div>
    @else
      <div class="row gy-4 mt-4">
        <div class="col-12">
          <div class="border rounded p-4 text-center bg-white">
            <h5 class="mb-3">Unlock Full ATS DeepCheck</h5>
            <p class="mb-3">Upgrade to premium to access the complete analysis, complete score breakdown, resume preview, and resume-JD matching feature.</p>
            <button type="button" class="btn btn-primary">Contact us to upgrade</button>
          </div>
        </div>
      </div>
    @endif
  </div>
</main>
@endsection
