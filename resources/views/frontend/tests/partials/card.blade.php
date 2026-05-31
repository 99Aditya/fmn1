<div class="test-card">
  <div class="card-accent {{ $test->difficulty }}"></div>
  <div class="card-body-inner">
    <div class="d-flex justify-content-between align-items-center">
      <span class="diff-badge {{ $test->difficulty }}">
        @if($test->difficulty === 'beginner') <i class="bi bi-circle-fill" style="font-size:.5rem"></i>
        @elseif($test->difficulty === 'intermediate') <i class="bi bi-circle-half" style="font-size:.5rem"></i>
        @else <i class="bi bi-circle" style="font-size:.5rem"></i>
        @endif
        {{ ucfirst($test->difficulty) }}
      </span>
      @if($test->has_certificate)
        <span class="cert-badge"><i class="bi bi-award-fill"></i> Certificate</span>
      @endif
    </div>

    <h2 class="card-title-text">{{ $test->title }}</h2>

    @if($test->description)
      <p class="card-desc">{{ Str::limit($test->description, 85) }}</p>
    @endif

    <div class="card-meta">
      <span class="meta-item"><i class="bi bi-question-circle-fill"></i> {{ $test->questions_count ?? $test->total_questions }} Questions</span>
      <span class="meta-item"><i class="bi bi-clock-fill"></i> {{ $test->total_time }} min</span>
      <span class="meta-item"><i class="bi bi-people-fill"></i> {{ number_format($test->total_attempts) }}</span>
    </div>

    @if($test->total_attempts > 0)
      <div class="mb-3 pass-rate-wrap">
        <div class="d-flex justify-content-between mb-1 pass-rate-header">
          <span>Pass rate</span>
          <span class="pass-rate-value">{{ $test->success_rate }}%</span>
        </div>
        <div class="pass-rate-track">
          <div class="pass-rate-fill" style="width:{{ $test->success_rate }}%"></div>
        </div>
      </div>
    @endif

    <a href="{{ route('tests.show', [$category->slug, $test->slug]) }}" class="card-cta">
      Start Test <i class="bi bi-arrow-right ms-1"></i>
    </a>
  </div>
</div>
