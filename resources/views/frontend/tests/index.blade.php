@extends('frontend.layouts.app')
@section('title', 'MCQ Tests')

@section('styles')
<style>
/* ── Page base ── */
.mcq-page { background: #f8faff; min-height: 100vh; }

/* ── Hero ── */
.mcq-hero {
  background: linear-gradient(135deg, #0f172a 0%, #1e40af 60%, #3b82f6 100%);
  padding: 110px 0 70px;
  position: relative;
  overflow: hidden;
}
.mcq-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.mcq-hero .hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(255,255,255,.12);
  border: 1px solid rgba(255,255,255,.2);
  backdrop-filter: blur(8px);
  color: #fff;
  padding: 6px 16px;
  border-radius: 50px;
  font-size: .8rem;
  font-weight: 600;
  letter-spacing: .4px;
  text-transform: uppercase;
  margin-bottom: 18px;
}
.mcq-hero h1 { font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 800; line-height: 1.15; }
.mcq-hero .lead { font-size: 1.1rem; opacity: .8; max-width: 520px; }
.hero-stat { text-align: center; }
.hero-stat .num { font-size: 1.8rem; font-weight: 800; color: #fff; }
.hero-stat .lbl { font-size: .75rem; opacity: .65; text-transform: uppercase; letter-spacing: .5px; }

/* ── Search bar ── */
.search-bar {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 8px 32px rgba(0,0,0,.12);
  padding: 8px 8px 8px 20px;
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: 36px;
}
.search-bar input {
  border: none;
  outline: none;
  flex: 1;
  font-size: 1rem;
  background: transparent;
  color: #0f172a;
}
.search-bar input::placeholder { color: #94a3b8; }
.search-bar .btn { border-radius: 10px; padding: 10px 22px; font-weight: 600; }

/* ── Category chips ── */
.cat-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 32px; }
.cat-chip {
  padding: 6px 16px;
  border-radius: 50px;
  border: 2px solid #e2e8f0;
  background: #fff;
  font-size: .85rem;
  font-weight: 600;
  color: #475569;
  cursor: pointer;
  transition: all .2s;
  text-decoration: none;
}
.cat-chip:hover, .cat-chip.active {
  border-color: #2563eb;
  background: #eff6ff;
  color: #2563eb;
}

/* ── Section headers ── */
.section-label {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
}
.section-label h3 { font-size: 1.35rem; font-weight: 800; margin: 0; color: #0f172a; }
.section-label .line { flex: 1; height: 2px; background: linear-gradient(to right, #e2e8f0, transparent); }
.section-label .count {
  background: #eff6ff;
  color: #2563eb;
  font-size: .78rem;
  font-weight: 700;
  padding: 3px 10px;
  border-radius: 50px;
}

/* ── Test card ── */
.test-card {
  background: #fff;
  border: 1.5px solid #e8edf5;
  border-radius: 16px;
  overflow: hidden;
  transition: transform .22s cubic-bezier(.4,0,.2,1), box-shadow .22s;
  height: 100%;
  display: flex;
  flex-direction: column;
}
.test-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 40px rgba(37,99,235,.12);
  border-color: #bfdbfe;
}
.card-accent { height: 4px; }
.card-accent.beginner { background: linear-gradient(90deg, #10b981, #34d399); }
.card-accent.intermediate { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.card-accent.advanced { background: linear-gradient(90deg, #ef4444, #f87171); }
.card-body-inner { padding: 20px; flex: 1; display: flex; flex-direction: column; }
.diff-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 4px 12px;
  border-radius: 50px;
  font-size: .72rem;
  font-weight: 700;
  letter-spacing: .3px;
}
.diff-badge.beginner { background: #d1fae5; color: #065f46; }
.diff-badge.intermediate { background: #fef3c7; color: #92400e; }
.diff-badge.advanced { background: #fee2e2; color: #991b1b; }
.cert-badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 4px 10px;
  border-radius: 50px;
  font-size: .72rem;
  font-weight: 700;
  background: #fffbeb;
  color: #b45309;
  border: 1px solid #fde68a;
}
.card-title-text {
  font-size: 1rem;
  font-weight: 700;
  color: #0f172a;
  line-height: 1.35;
  margin: 10px 0 6px;
}
.card-desc { font-size: .83rem; color: #64748b; line-height: 1.55; }
.card-meta {
  display: flex;
  gap: 14px;
  margin: 14px 0 16px;
  flex-wrap: wrap;
}
.meta-item { display: flex; align-items: center; gap: 5px; font-size: .78rem; color: #64748b; }
.meta-item i { color: #94a3b8; font-size: .85rem; }
.card-cta {
  display: block;
  text-align: center;
  padding: 10px;
  border-radius: 10px;
  background: linear-gradient(135deg, #2563eb, #3b82f6);
  color: #fff;
  font-weight: 600;
  font-size: .9rem;
  text-decoration: none;
  transition: opacity .2s, transform .15s;
  margin-top: auto;
}
.card-cta:hover { opacity: .9; transform: translateY(-1px); color: #fff; }

/* ── View all ── */
.view-all-link {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: .85rem;
  font-weight: 600;
  color: #2563eb;
  text-decoration: none;
  padding: 6px 14px;
  border: 1.5px solid #bfdbfe;
  border-radius: 50px;
  transition: all .2s;
}
.view-all-link:hover { background: #eff6ff; color: #1d4ed8; }

/* ── Empty state ── */
.empty-state { text-align: center; padding: 60px 20px; }
.empty-state .icon { font-size: 3.5rem; color: #cbd5e1; margin-bottom: 16px; }
.empty-state h5 { color: #475569; font-weight: 700; }
.empty-state p { color: #94a3b8; }

@media (max-width: 576px) {
  .mcq-hero { padding: 90px 0 50px; }
  .search-bar { flex-direction: column; align-items: stretch; gap: 8px; }
  .hero-stats-row { gap: 16px !important; }
}
</style>
@endsection

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
