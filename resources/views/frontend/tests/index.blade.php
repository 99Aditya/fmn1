@extends('frontend.layouts.app')
@section('title', 'MCQ Tests')

@section('content')
<div class="mcq-page">

{{-- ── Hero ── --}}
<section class="mcq-hero text-white">
  <div class="container position-relative">
    <div class="row align-items-center g-4">
      <div class="col-lg-7">
        <div class="hero-badge">
          <i class="bi bi-lightning-charge-fill"></i> Practice &amp; Get Certified
        </div>
        <h1 class="mb-3">Master Any Topic with<br>Category-Wise MCQ Tests</h1>
        <p class="lead mb-4">Attempt real-exam style tests, get instant AI-reviewed results, and earn shareable certificates.</p>

        {{-- Search --}}
        <div class="search-bar">
          <i class="bi bi-search text-muted"></i>
          <input type="text" id="searchInput" placeholder="Search tests, topics, categories…">
          <button class="btn btn-primary">Search</button>
        </div>
      </div>

      <div class="col-lg-5 d-none d-lg-flex justify-content-end">
        <div class="d-flex gap-4 hero-stats-row">
          @php
            $totalTests    = \App\Models\Test::where('status','published')->count();
            $totalAttempts = \App\Models\TestAttempt::count();
            $totalCerts    = \App\Models\Certificate::count();
          @endphp
          <div class="hero-stat">
            <div class="num">{{ $totalTests }}+</div>
            <div class="lbl">Tests</div>
          </div>
          <div class="hero-stat">
            <div class="num">{{ number_format($totalAttempts) }}</div>
            <div class="lbl">Attempts</div>
          </div>
          <div class="hero-stat">
            <div class="num">{{ $totalCerts }}+</div>
            <div class="lbl">Certificates</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ── Content ── --}}
<section class="py-5">
  <div class="container">

    {{-- Category chips --}}
    @if($categories->count())
    <div class="cat-chips">
      <a href="{{ route('tests.index') }}" class="cat-chip active">All</a>
      @foreach($categories as $cat)
        <a href="{{ route('tests.category', $cat->slug) }}" class="cat-chip">{{ $cat->name }}</a>
      @endforeach
    </div>
    @endif

    @forelse($categories as $category)
      <div class="mb-5 category-group" data-name="{{ strtolower($category->name) }}">
        <div class="section-label">
          <h3>{{ $category->name }}</h3>
          <span class="count">{{ $category->tests_count }} test{{ $category->tests_count != 1 ? 's' : '' }}</span>
          <div class="line"></div>
          @if($category->tests_count > 3)
            <a href="{{ route('tests.category', $category->slug) }}" class="view-all-link">
              View all <i class="bi bi-arrow-right"></i>
            </a>
          @endif
        </div>

        <div class="row g-3">
          @foreach($category->tests->take(3) as $test)
            <div class="col-sm-6 col-lg-4 test-item" data-title="{{ strtolower($test->title) }}">
              @include('frontend.tests.partials.card', ['test' => $test, 'category' => $category])
            </div>
          @endforeach
        </div>
      </div>
    @empty
      <div class="empty-state">
        <div class="icon"><i class="bi bi-clipboard2-x"></i></div>
        <h5>No tests available yet</h5>
        <p>Check back soon — tests are being added regularly.</p>
      </div>
    @endforelse

  </div>
</section>

</div>
@endsection

@section('scripts')
<script>
  const input = document.getElementById('searchInput');
  if (input) {
    input.addEventListener('input', function () {
      const q = this.value.toLowerCase().trim();
      document.querySelectorAll('.test-item').forEach(el => {
        el.style.display = q === '' || el.dataset.title.includes(q) ? '' : 'none';
      });
      document.querySelectorAll('.category-group').forEach(group => {
        const visible = [...group.querySelectorAll('.test-item')].some(el => el.style.display !== 'none');
        group.style.display = visible ? '' : 'none';
      });
    });
  }
</script>
@endsection
