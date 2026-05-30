@extends('frontend.layouts.app')
@section('title', 'Result — ' . $test->title)

@section('styles')
<style>
.result-page { background: #f4f7ff; min-height: 100vh; }

/* ── Score hero ── */
.result-hero {
  background: linear-gradient(135deg, #0f172a 0%, #1e40af 60%, #3b82f6 100%);
  padding: 110px 0 80px;
  position: relative;
  overflow: hidden;
}
.result-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* Animated score ring */
.score-ring-wrap { position: relative; width: 180px; height: 180px; margin: 0 auto 24px; }
.score-ring-svg { transform: rotate(-90deg); }
.score-ring-bg { fill: none; stroke: rgba(255,255,255,.1); stroke-width: 10; }
.score-ring-fill { fill: none; stroke-width: 10; stroke-linecap: round; transition: stroke-dashoffset 1.4s cubic-bezier(.4,0,.2,1); }
.score-ring-fill.pass { stroke: #34d399; }
.score-ring-fill.fail { stroke: #f87171; }
.score-ring-text { position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; }
.score-pct { font-size: 2.2rem; font-weight: 800; color: #fff; line-height: 1; }
.score-label { font-size: .78rem; font-weight: 700; letter-spacing: .6px; text-transform: uppercase; margin-top: 4px; }
.score-label.pass { color: #34d399; }
.score-label.fail { color: #f87171; }

/* Stats chips */
.result-stats { display: flex; flex-wrap: wrap; justify-content: center; gap: 12px; margin-top: 28px; }
.result-stat {
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.15);
  backdrop-filter: blur(8px);
  border-radius: 14px;
  padding: 14px 22px;
  text-align: center;
  min-width: 100px;
}
.result-stat .num { font-size: 1.5rem; font-weight: 800; color: #fff; }
.result-stat .lbl { font-size: .72rem; color: rgba(255,255,255,.6); text-transform: uppercase; letter-spacing: .4px; }

/* ── Certificate banner ── */
.cert-banner {
  background: linear-gradient(135deg, #fffbeb, #fef9c3);
  border: 2px solid #fde68a;
  border-radius: 20px;
  padding: 24px 28px;
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 28px;
  box-shadow: 0 8px 24px rgba(251,191,36,.12);
}
.cert-icon { width: 60px; height: 60px; background: #fef3c7; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; flex-shrink: 0; }
.cert-banner-title { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
.cert-banner-sub { font-size: .85rem; color: #64748b; }
.cert-view-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  background: linear-gradient(135deg, #f59e0b, #fbbf24);
  color: #fff;
  font-weight: 700;
  padding: 10px 20px;
  border-radius: 10px;
  text-decoration: none;
  font-size: .9rem;
  transition: opacity .2s, transform .15s;
  white-space: nowrap;
  flex-shrink: 0;
}
.cert-view-btn:hover { opacity: .9; transform: translateY(-2px); color: #fff; }

/* ── Answer review ── */
.review-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  flex-wrap: wrap;
  gap: 12px;
}
.review-header h4 { font-weight: 800; color: #0f172a; margin: 0; font-size: 1.2rem; }
.filter-tabs { display: flex; gap: 6px; }
.filter-tab {
  padding: 6px 14px;
  border-radius: 50px;
  font-size: .8rem;
  font-weight: 600;
  cursor: pointer;
  border: 1.5px solid #e2e8f0;
  background: #fff;
  color: #475569;
  transition: all .15s;
}
.filter-tab.active-all { border-color: #2563eb; background: #eff6ff; color: #2563eb; }
.filter-tab.active-correct { border-color: #10b981; background: #d1fae5; color: #065f46; }
.filter-tab.active-wrong { border-color: #ef4444; background: #fee2e2; color: #991b1b; }

.answer-card {
  background: #fff;
  border-radius: 16px;
  border: 2px solid #e8edf5;
  overflow: hidden;
  margin-bottom: 14px;
  transition: box-shadow .2s;
}
.answer-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.07); }
.answer-card.correct { border-color: #86efac; }
.answer-card.wrong { border-color: #fca5a5; }
.answer-card.skipped { border-color: #e2e8f0; }
.answer-accent { height: 4px; }
.answer-accent.correct { background: linear-gradient(90deg, #10b981, #34d399); }
.answer-accent.wrong { background: linear-gradient(90deg, #ef4444, #f87171); }
.answer-accent.skipped { background: #e2e8f0; }
.answer-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 12px;
  padding: 18px 20px 12px;
}
.q-idx { font-size: .75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: .4px; flex-shrink: 0; margin-top: 2px; }
.q-text-review { font-size: .95rem; font-weight: 600; color: #0f172a; line-height: 1.55; flex: 1; }
.status-chip { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 50px; font-size: .75rem; font-weight: 700; flex-shrink: 0; }
.status-chip.correct { background: #d1fae5; color: #065f46; }
.status-chip.wrong { background: #fee2e2; color: #991b1b; }
.status-chip.skipped { background: #f1f5f9; color: #475569; }
.options-review { padding: 0 20px 16px; display: grid; grid-template-columns: 1fr 1fr; gap: 7px; }
.opt-row {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 9px 12px;
  border-radius: 9px;
  font-size: .85rem;
  border: 1.5px solid transparent;
  background: #f8faff;
}
.opt-row.correct-opt { background: #d1fae5; border-color: #86efac; }
.opt-row.wrong-opt { background: #fee2e2; border-color: #fca5a5; }
.opt-icon { font-size: .85rem; flex-shrink: 0; }
.opt-text { flex: 1; color: #334155; }
.opt-tag { font-size: .68rem; font-weight: 700; padding: 2px 7px; border-radius: 50px; flex-shrink: 0; }
.opt-tag.c { background: #059669; color: #fff; }
.opt-tag.w { background: #ef4444; color: #fff; }
.explanation-box {
  margin: 0 20px 16px;
  background: linear-gradient(135deg, #f0f7ff, #eff6ff);
  border-left: 4px solid #3b82f6;
  border-radius: 0 10px 10px 0;
  padding: 12px 16px;
  font-size: .85rem;
  color: #334155;
  line-height: 1.55;
}
.explanation-box strong { color: #1d4ed8; }

/* ── Action bar ── */
.action-bar {
  background: #fff;
  border-top: 1.5px solid #e8edf5;
  padding: 20px 0;
  position: sticky;
  bottom: 0;
  z-index: 50;
  box-shadow: 0 -4px 24px rgba(0,0,0,.07);
}
.action-inner { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }
.action-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 11px 22px;
  border-radius: 12px;
  font-weight: 600;
  font-size: .9rem;
  text-decoration: none;
  transition: all .15s;
}
.action-btn.outline { border: 2px solid #e2e8f0; color: #475569; background: #fff; }
.action-btn.outline:hover { border-color: #2563eb; color: #2563eb; background: #eff6ff; }
.action-btn.primary { background: linear-gradient(135deg, #2563eb, #3b82f6); color: #fff; border: none; }
.action-btn.primary:hover { opacity: .9; box-shadow: 0 6px 20px rgba(37,99,235,.3); color: #fff; }

@media (max-width: 576px) {
  .result-hero { padding: 90px 0 60px; }
  .cert-banner { flex-direction: column; text-align: center; }
  .cert-view-btn { width: 100%; justify-content: center; }
  .options-review { grid-template-columns: 1fr; }
  .review-header { flex-direction: column; align-items: flex-start; }
  .filter-tabs { flex-wrap: wrap; }
}
</style>
@endsection

@section('content')
<div class="result-page">

{{-- ── Hero Score ── --}}
<section class="result-hero text-white">
  <div class="container position-relative text-center">
    <div class="mb-2" style="font-size:.85rem;opacity:.6;text-transform:uppercase;letter-spacing:.6px">{{ $test->category->name ?? '' }}</div>
    <h1 style="font-weight:800;font-size:clamp(1.4rem,3vw,2rem);margin-bottom:28px">{{ $test->title }}</h1>

    {{-- Animated ring --}}
    @php $r = 80; $circ = 2 * M_PI * $r; $offset = $circ * (1 - $attempt->percentage / 100); @endphp
    <div class="score-ring-wrap">
      <svg class="score-ring-svg" width="180" height="180" viewBox="0 0 180 180">
        <circle class="score-ring-bg" cx="90" cy="90" r="{{ $r }}"/>
        <circle class="score-ring-fill {{ $attempt->passed ? 'pass' : 'fail' }}"
          cx="90" cy="90" r="{{ $r }}"
          stroke-dasharray="{{ $circ }}"
          stroke-dashoffset="{{ $circ }}"
          id="ring-fill"/>
      </svg>
      <div class="score-ring-text">
        <div class="score-pct">{{ $attempt->percentage }}%</div>
        <div class="score-label {{ $attempt->passed ? 'pass' : 'fail' }}">{{ $attempt->passed ? 'PASSED' : 'FAILED' }}</div>
      </div>
    </div>

    <div class="result-stats">
      <div class="result-stat">
        <div class="num">{{ $attempt->score }}<span style="font-size:1rem;opacity:.5">/{{ $test->total_marks }}</span></div>
        <div class="lbl">Score</div>
      </div>
      <div class="result-stat" style="border-color:rgba(52,211,153,.3)">
        <div class="num" style="color:#34d399">{{ $attempt->correct_answers }}</div>
        <div class="lbl">Correct</div>
      </div>
      <div class="result-stat" style="border-color:rgba(248,113,113,.3)">
        <div class="num" style="color:#f87171">{{ $attempt->wrong_answers }}</div>
        <div class="lbl">Wrong</div>
      </div>
      <div class="result-stat">
        <div class="num" style="color:#94a3b8">{{ $attempt->total_questions - $attempt->correct_answers - $attempt->wrong_answers }}</div>
        <div class="lbl">Skipped</div>
      </div>
    </div>
  </div>
</section>

{{-- ── Review Section ── --}}
<section class="py-4 py-md-5">
  <div class="container" style="max-width:800px">

    {{-- Certificate banner --}}
    @if($certificate)
      <div class="cert-banner">
        <div class="cert-icon">🏆</div>
        <div class="flex-grow-1">
          <div class="cert-banner-title">Certificate Earned!</div>
          <div class="cert-banner-sub">
            Certificate No: <code>{{ $certificate->certificate_no }}</code> &bull;
            Issued {{ $certificate->issued_at->format('d M Y') }}
          </div>
        </div>
        <a href="{{ route('certificates.show', $certificate->certificate_no) }}" class="cert-view-btn" target="_blank">
          <i class="bi bi-award-fill"></i> View Certificate
        </a>
      </div>
    @endif

    {{-- Review header + filters --}}
    <div class="review-header">
      <h4>Answer Review</h4>
      <div class="filter-tabs">
        <button class="filter-tab active-all" onclick="filterReview('all', this)">All ({{ $questions->count() }})</button>
        <button class="filter-tab" onclick="filterReview('correct', this)">Correct ({{ $attempt->correct_answers }})</button>
        <button class="filter-tab" onclick="filterReview('wrong', this)">Wrong ({{ $attempt->wrong_answers }})</button>
        <button class="filter-tab" onclick="filterReview('skipped', this)">Skipped ({{ $attempt->total_questions - $attempt->correct_answers - $attempt->wrong_answers }})</button>
      </div>
    </div>

    {{-- Answer cards --}}
    @foreach($questions as $i => $question)
      @php
        $answer   = $answersMap->get($question->id);
        $selected = $answer?->selected_option_id;
        $correct  = $question->options->firstWhere('is_correct', 1);
        $status   = !$answer ? 'skipped' : ($answer->is_correct ? 'correct' : 'wrong');
      @endphp

      <div class="answer-card {{ $status }}" data-status="{{ $status }}">
        <div class="answer-accent {{ $status }}"></div>
        <div class="answer-header">
          <span class="q-idx">Q{{ $i + 1 }}</span>
          <div class="q-text-review">{{ $question->question }}</div>
          <span class="status-chip {{ $status }}">
            @if($status === 'correct')
              <i class="bi bi-check-lg"></i> +{{ $question->marks }}
            @elseif($status === 'wrong')
              <i class="bi bi-x-lg"></i> 0
            @else
              <i class="bi bi-dash"></i> Skipped
            @endif
          </span>
        </div>

        <div class="options-review">
          @foreach($question->options as $j => $opt)
            @php
              $isCorrect  = (bool) $opt->is_correct;
              $isSelected = $opt->id == $selected;
              $cls = '';
              if ($isCorrect) $cls = 'correct-opt';
              elseif ($isSelected && !$isCorrect) $cls = 'wrong-opt';
            @endphp
            <div class="opt-row {{ $cls }}">
              @if($isCorrect)
                <i class="opt-icon bi bi-check-circle-fill text-success"></i>
              @elseif($isSelected)
                <i class="opt-icon bi bi-x-circle-fill text-danger"></i>
              @else
                <i class="opt-icon bi bi-circle" style="color:#cbd5e1"></i>
              @endif
              <span class="opt-text">{{ $opt->option_text }}</span>
              @if($isCorrect && $isSelected) <span class="opt-tag c">Your answer ✓</span>
              @elseif($isCorrect)            <span class="opt-tag c">Correct</span>
              @elseif($isSelected)           <span class="opt-tag w">Your answer</span>
              @endif
            </div>
          @endforeach
        </div>

        @if($question->explanation)
          <div class="explanation-box">
            <strong><i class="bi bi-lightbulb-fill me-1"></i>Explanation:</strong> {{ $question->explanation }}
          </div>
        @endif
      </div>
    @endforeach

  </div>
</section>

{{-- ── Sticky action bar ── --}}
<div class="action-bar">
  <div class="action-inner">
    <a href="{{ route('tests.index') }}" class="action-btn outline">
      <i class="bi bi-grid-3x3-gap"></i> Browse Tests
    </a>
    <form action="{{ route('tests.start', $test) }}" method="POST" class="d-inline">
      @csrf
      <button type="submit" class="action-btn outline">
        <i class="bi bi-arrow-counterclockwise"></i> Retake Test
      </button>
    </form>
    <a href="{{ route('dashboard') }}" class="action-btn primary">
      <i class="bi bi-speedometer2"></i> My Dashboard
    </a>
  </div>
</div>

</div>
@endsection

@section('scripts')
<script>
// Animate ring on load
window.addEventListener('load', () => {
  const fill = document.getElementById('ring-fill');
  const r = 80, circ = 2 * Math.PI * r;
  const pct = {{ $attempt->percentage }};
  const offset = circ * (1 - pct / 100);
  setTimeout(() => { fill.style.strokeDashoffset = offset; }, 200);
});

// Filter
function filterReview(type, btn) {
  document.querySelectorAll('.filter-tab').forEach(t => t.className = 'filter-tab');
  btn.classList.add('active-' + type);
  document.querySelectorAll('.answer-card').forEach(card => {
    card.style.display = (type === 'all' || card.dataset.status === type) ? '' : 'none';
  });
}
</script>
@endsection
