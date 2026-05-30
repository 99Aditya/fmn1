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
      <div class="mb-3">
        <div class="d-flex justify-content-between mb-1" style="font-size:.72rem; color:#94a3b8">
          <span>Pass rate</span>
          <span style="color:#0f172a; font-weight:700">{{ $test->success_rate }}%</span>
        </div>
        <div style="height:4px; background:#f1f5f9; border-radius:99px; overflow:hidden">
          <div style="width:{{ $test->success_rate }}%; height:100%; background:linear-gradient(90deg,#10b981,#34d399); border-radius:99px; transition:width .6s"></div>
        </div>
      </div>
    @endif

    <a href="{{ route('tests.show', [$category->slug, $test->slug]) }}" class="card-cta">
      Start Test <i class="bi bi-arrow-right ms-1"></i>
    </a>
  </div>
</div>
