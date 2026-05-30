@extends('frontend.layouts.app')
@section('title', $test->title . ' — Test')

@section('styles')
<style>
/* ─── Reset for quiz layout ─── */
body { background: #f4f7ff; }
.quiz-wrap { display: flex; flex-direction: column; min-height: 100vh; }

/* ─── Top bar ─── */
.quiz-topbar {
  position: fixed;
  top: 0; left: 0; right: 0;
  z-index: 200;
  background: #0f172a;
  height: 60px;
  display: flex;
  align-items: center;
  box-shadow: 0 2px 16px rgba(0,0,0,.3);
}
.quiz-topbar .container-fluid { display: flex; align-items: center; gap: 16px; padding: 0 20px; }
.quiz-title { font-size: .9rem; font-weight: 700; color: #fff; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.timer-box {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(255,255,255,.1);
  border: 1px solid rgba(255,255,255,.15);
  border-radius: 10px;
  padding: 7px 14px;
  font-size: .95rem;
  font-weight: 700;
  color: #fff;
  font-variant-numeric: tabular-nums;
  min-width: 96px;
}
.timer-box.warn { background: rgba(245,158,11,.2); border-color: rgba(245,158,11,.4); color: #fbbf24; }
.timer-box.danger { background: rgba(239,68,68,.2); border-color: rgba(239,68,68,.4); color: #f87171; animation: pulse 1s ease-in-out infinite; }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.55} }
.topbar-progress { flex: 1; max-width: 180px; display: flex; align-items: center; gap: 8px; }
.topbar-progress .bar { flex:1; height:5px; background:rgba(255,255,255,.15); border-radius:99px; overflow:hidden; }
.topbar-progress .fill { height:100%; background:linear-gradient(90deg,#10b981,#34d399); border-radius:99px; transition:width .4s; }
.topbar-progress .label { font-size:.72rem; color:rgba(255,255,255,.55); white-space:nowrap; }

/* ─── Main layout ─── */
.quiz-main { padding-top: 60px; flex: 1; }
.quiz-inner { display: grid; grid-template-columns: 1fr 300px; gap: 24px; padding: 24px 0; max-width: 1100px; margin: 0 auto; padding-left: 20px; padding-right: 20px; }

/* ─── Question panel ─── */
.q-panel {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 4px 24px rgba(0,0,0,.06);
  border: 1.5px solid #e8edf5;
  overflow: hidden;
  min-height: 500px;
  display: flex;
  flex-direction: column;
}
.q-header {
  background: linear-gradient(135deg, #eff6ff, #f8faff);
  padding: 20px 28px;
  border-bottom: 1.5px solid #e8edf5;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 10px;
}
.q-number { font-size: .8rem; font-weight: 700; color: #2563eb; text-transform: uppercase; letter-spacing: .5px; }
.q-marks { background: #eff6ff; color: #1d4ed8; padding: 4px 12px; border-radius: 50px; font-size: .75rem; font-weight: 700; border: 1px solid #bfdbfe; }
.q-body { padding: 28px; flex: 1; }
.q-text { font-size: 1.05rem; font-weight: 600; color: #0f172a; line-height: 1.65; margin-bottom: 28px; }
.options-grid { display: flex; flex-direction: column; gap: 10px; }
.option-wrap { position: relative; }
.option-input { position: absolute; opacity: 0; pointer-events: none; }
.option-label {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 18px;
  border: 2px solid #e8edf5;
  border-radius: 12px;
  cursor: pointer;
  transition: all .18s cubic-bezier(.4,0,.2,1);
  background: #fafbfc;
  user-select: none;
}
.option-label:hover { border-color: #93c5fd; background: #f0f7ff; transform: translateX(3px); }
.option-input:checked + .option-label {
  border-color: #2563eb;
  background: #eff6ff;
  box-shadow: 0 0 0 3px rgba(37,99,235,.12);
}
.option-letter {
  width: 34px; height: 34px;
  border-radius: 10px;
  background: #e8edf5;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: .85rem;
  color: #64748b;
  flex-shrink: 0;
  transition: all .18s;
}
.option-input:checked + .option-label .option-letter {
  background: #2563eb;
  color: #fff;
}
.option-text { font-size: .95rem; color: #334155; line-height: 1.45; }

/* ─── Nav footer ─── */
.q-footer {
  padding: 18px 28px;
  border-top: 1.5px solid #f1f5f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 10px;
}
.nav-btn {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 10px 20px;
  border-radius: 10px;
  font-size: .88rem;
  font-weight: 600;
  cursor: pointer;
  border: 2px solid #e2e8f0;
  background: #fff;
  color: #475569;
  transition: all .15s;
  text-decoration: none;
}
.nav-btn:hover { border-color: #2563eb; color: #2563eb; background: #eff6ff; }
.nav-btn:disabled { opacity: .4; pointer-events: none; }
.nav-btn.primary { background: linear-gradient(135deg,#2563eb,#3b82f6); border-color: transparent; color: #fff; }
.nav-btn.primary:hover { opacity: .9; box-shadow: 0 4px 16px rgba(37,99,235,.3); }
.nav-btn.success { background: linear-gradient(135deg,#059669,#10b981); border-color: transparent; color: #fff; }
.nav-btn.success:hover { opacity: .9; box-shadow: 0 4px 16px rgba(5,150,105,.3); }

/* ─── Sidebar ─── */
.quiz-sidebar { display: flex; flex-direction: column; gap: 16px; }
.sidebar-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 24px rgba(0,0,0,.06);
  border: 1.5px solid #e8edf5;
  overflow: hidden;
}
.sidebar-card-header { padding: 14px 18px; background: #f8faff; border-bottom: 1.5px solid #e8edf5; font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; }
.sidebar-card-body { padding: 16px; }

/* ─── Question grid navigator ─── */
.q-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 6px; }
.q-btn {
  aspect-ratio: 1;
  border-radius: 8px;
  border: 2px solid #e2e8f0;
  background: #fafbfc;
  font-size: .8rem;
  font-weight: 700;
  color: #64748b;
  cursor: pointer;
  transition: all .15s;
  display: flex;
  align-items: center;
  justify-content: center;
}
.q-btn:hover { border-color: #93c5fd; background: #eff6ff; color: #2563eb; }
.q-btn.current { border-color: #2563eb; background: #2563eb; color: #fff; box-shadow: 0 4px 12px rgba(37,99,235,.3); }
.q-btn.answered { border-color: #10b981; background: #d1fae5; color: #065f46; }
.q-btn.current.answered { background: #2563eb; border-color: #2563eb; color: #fff; }

/* Legend */
.legend { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px; }
.legend-item { display: flex; align-items: center; gap: 5px; font-size: .72rem; color: #64748b; }
.legend-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }

/* Progress */
.prog-ring-wrap { text-align: center; padding: 8px 0; }
.prog-ring-wrap .big-num { font-size: 2rem; font-weight: 800; color: #0f172a; line-height: 1; }
.prog-ring-wrap .sub { font-size: .75rem; color: #94a3b8; margin-top: 2px; }

/* Submit confirm modal */
.modal-header { border: none; padding: 24px 24px 8px; }
.modal-body { padding: 8px 24px 16px; color: #475569; }
.modal-footer { border: none; padding: 0 24px 24px; }

/* ─── Responsive ─── */
@media (max-width: 900px) {
  .quiz-inner { grid-template-columns: 1fr; }
  .quiz-sidebar { order: -1; }
  .q-grid { grid-template-columns: repeat(8, 1fr); }
  .topbar-progress { display: none; }
}
@media (max-width: 576px) {
  .quiz-inner { padding: 12px; gap: 12px; }
  .q-body { padding: 20px 16px; }
  .q-header { padding: 14px 16px; }
  .q-footer { padding: 14px 16px; }
  .quiz-title { max-width: 120px; }
  .q-grid { grid-template-columns: repeat(6, 1fr); }
}
</style>
@endsection

@section('content')

<form id="quiz-form" action="{{ route('tests.attempt.submit', [$test, $attempt]) }}" method="POST">
@csrf

<div class="quiz-wrap">

  {{-- ── Top Bar ── --}}
  <div class="quiz-topbar">
    <div class="container-fluid">
      <div class="quiz-title">{{ $test->title }}</div>

      <div class="topbar-progress d-none d-md-flex">
        <div class="bar"><div class="fill" id="top-progress" style="width:0%"></div></div>
        <div class="label" id="top-label">0/{{ $questions->count() }}</div>
      </div>

      <div class="timer-box" id="timer-box">
        <i class="bi bi-clock"></i>
        <span id="timer-display">--:--</span>
      </div>

      <button type="button" class="nav-btn primary d-none d-sm-inline-flex" onclick="confirmSubmit()" style="padding:8px 16px">
        <i class="bi bi-send-check"></i> Submit
      </button>
    </div>
  </div>

  {{-- ── Main ── --}}
  <div class="quiz-main">
    <div class="quiz-inner">

      {{-- ── Question Panel ── --}}
      <div>
        @foreach($questions as $i => $question)
          <div class="q-panel question-slide {{ $i > 0 ? 'd-none' : '' }}" data-qi="{{ $i }}">
            <div class="q-header">
              <span class="q-number">Question {{ $i + 1 }} / {{ $questions->count() }}</span>
              <span class="q-marks"><i class="bi bi-star-fill me-1" style="font-size:.6rem"></i>{{ $question->marks }} mark{{ $question->marks > 1 ? 's' : '' }}</span>
            </div>
            <div class="q-body">
              <div class="q-text">{{ $question->question }}</div>
              <div class="options-grid">
                @php $letters = ['A','B','C','D','E']; @endphp
                @foreach($question->options as $j => $option)
                  <div class="option-wrap">
                    <input type="radio"
                      name="answers[{{ $question->id }}]"
                      id="opt_{{ $question->id }}_{{ $option->id }}"
                      value="{{ $option->id }}"
                      class="option-input"
                      onchange="onAnswer({{ $i }})">
                    <label for="opt_{{ $question->id }}_{{ $option->id }}" class="option-label">
                      <span class="option-letter">{{ $letters[$j] ?? ($j+1) }}</span>
                      <span class="option-text">{{ $option->option_text }}</span>
                    </label>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="q-footer">
              <button type="button" class="nav-btn" id="prevBtn_{{ $i }}" onclick="navigate(-1)" {{ $i === 0 ? 'disabled' : '' }}>
                <i class="bi bi-arrow-left"></i> Previous
              </button>
              <span style="font-size:.8rem;color:#94a3b8" id="skip-hint-{{ $i }}">
                @if($i < $questions->count()-1) You can come back to this later @endif
              </span>
              @if($i < $questions->count() - 1)
                <button type="button" class="nav-btn primary" onclick="navigate(1)">
                  Next <i class="bi bi-arrow-right"></i>
                </button>
              @else
                <button type="button" class="nav-btn success" onclick="confirmSubmit()">
                  <i class="bi bi-check2-all"></i> Finish Test
                </button>
              @endif
            </div>
          </div>
        @endforeach
      </div>

      {{-- ── Sidebar ── --}}
      <div class="quiz-sidebar">

        {{-- Progress card --}}
        <div class="sidebar-card">
          <div class="sidebar-card-header">Progress</div>
          <div class="sidebar-card-body">
            <div class="prog-ring-wrap mb-2">
              <div class="big-num"><span id="ans-count">0</span><span style="font-size:1rem;color:#94a3b8">/{{ $questions->count() }}</span></div>
              <div class="sub">Questions answered</div>
            </div>
            <div style="height:6px;background:#f1f5f9;border-radius:99px;overflow:hidden">
              <div id="sidebar-progress" style="height:100%;width:0%;background:linear-gradient(90deg,#10b981,#34d399);border-radius:99px;transition:width .4s"></div>
            </div>
          </div>
        </div>

        {{-- Question navigator --}}
        <div class="sidebar-card">
          <div class="sidebar-card-header">Question Navigator</div>
          <div class="sidebar-card-body">
            <div class="q-grid" id="q-grid">
              @foreach($questions as $i => $q)
                <button type="button" class="q-btn {{ $i === 0 ? 'current' : '' }}" id="qb_{{ $i }}" onclick="jumpTo({{ $i }})">{{ $i + 1 }}</button>
              @endforeach
            </div>
            <div class="legend">
              <div class="legend-item"><div class="legend-dot" style="background:#2563eb;border-radius:3px"></div> Current</div>
              <div class="legend-item"><div class="legend-dot" style="background:#d1fae5;border:1.5px solid #10b981"></div> Answered</div>
              <div class="legend-item"><div class="legend-dot" style="background:#fafbfc;border:1.5px solid #e2e8f0"></div> Not visited</div>
            </div>
          </div>
        </div>

        {{-- Mobile submit --}}
        <button type="button" class="nav-btn success d-sm-none w-100 justify-content-center" onclick="confirmSubmit()" style="padding:13px">
          <i class="bi bi-send-check"></i> Submit Test
        </button>

      </div>

    </div>
  </div>
</div>

{{-- Submit Modal --}}
<div class="modal fade" id="submitModal" tabindex="-1" aria-modal="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
    <div class="modal-content" style="border-radius:20px;border:none;box-shadow:0 24px 64px rgba(0,0,0,.15)">
      <div class="modal-header">
        <div>
          <h5 style="font-weight:800;color:#0f172a;margin:0">Submit Test?</h5>
          <div style="font-size:.8rem;color:#94a3b8;margin-top:2px">This action cannot be undone.</div>
        </div>
      </div>
      <div class="modal-body" id="modal-body-text">
        Loading…
      </div>
      <div class="modal-footer">
        <button type="button" class="nav-btn" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="nav-btn success" onclick="document.getElementById('quiz-form').submit()">
          <i class="bi bi-send-check"></i> Yes, Submit Now
        </button>
      </div>
    </div>
  </div>
</div>

</form>
@endsection

@section('scripts')
<script>
const TOTAL     = {{ $questions->count() }};
const TIMELIMIT = {{ $timeRemaining }};
let current     = 0;
let answered    = new Set();
let timeLeft    = TIMELIMIT;

/* ── Timer ── */
const timerEl   = document.getElementById('timer-box');
const timerDisp = document.getElementById('timer-display');

function updateTimerDisplay() {
  const m = String(Math.floor(timeLeft / 60)).padStart(2, '0');
  const s = String(timeLeft % 60).padStart(2, '0');
  timerDisp.textContent = m + ':' + s;
  if (timeLeft <= 0) {
    timerEl.className = 'timer-box danger';
    clearInterval(tick);
    document.getElementById('quiz-form').submit();
  } else if (timeLeft <= 60) {
    timerEl.className = 'timer-box danger';
  } else if (timeLeft <= 5 * 60) {
    timerEl.className = 'timer-box warn';
  }
}
updateTimerDisplay();
const tick = setInterval(() => { timeLeft--; updateTimerDisplay(); }, 1000);

/* ── Question navigation ── */
function showQuestion(idx) {
  document.querySelectorAll('.question-slide').forEach(el => el.classList.add('d-none'));
  document.querySelector(`[data-qi="${idx}"]`).classList.remove('d-none');

  // Update nav grid
  document.querySelectorAll('.q-btn').forEach((btn, i) => {
    btn.className = 'q-btn';
    if (answered.has(i))  btn.classList.add('answered');
    if (i === idx)         btn.classList.add('current');
  });

  current = idx;
}

function navigate(dir) {
  const next = current + dir;
  if (next >= 0 && next < TOTAL) showQuestion(next);
}

function jumpTo(idx) { showQuestion(idx); }

function onAnswer(idx) {
  answered.add(idx);
  // Update progress
  document.getElementById('ans-count').textContent = answered.size;
  const pct = (answered.size / TOTAL) * 100;
  document.getElementById('sidebar-progress').style.width = pct + '%';
  document.getElementById('top-progress').style.width     = pct + '%';
  document.getElementById('top-label').textContent = answered.size + '/' + TOTAL;
  // Refresh nav
  showQuestion(current);
}

/* ── Submit ── */
function confirmSubmit() {
  const unanswered = TOTAL - answered.size;
  let msg;
  if (unanswered === 0) {
    msg = '<div style="display:flex;align-items:center;gap:10px"><div style="width:40px;height:40px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="bi bi-check-lg" style="color:#059669;font-size:1.2rem"></i></div><span>All <strong>' + TOTAL + '</strong> questions answered. Ready to submit!</span></div>';
  } else {
    msg = '<div style="display:flex;align-items:center;gap:10px"><div style="width:40px;height:40px;background:#fef3c7;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="bi bi-exclamation-triangle-fill" style="color:#d97706;font-size:1rem"></i></div><span>You have <strong>' + unanswered + '</strong> unanswered question' + (unanswered > 1 ? 's' : '') + '. Unanswered questions will score 0. Submit anyway?</span></div>';
  }
  document.getElementById('modal-body-text').innerHTML = msg;
  new bootstrap.Modal(document.getElementById('submitModal')).show();
}
</script>
@endsection
