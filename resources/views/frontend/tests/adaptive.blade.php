@extends('frontend.layouts.app')
@section('title', 'Adaptive Test · ' . $test->title)

@section('styles')
<style>
.ad { background:#eef2fb; min-height:100vh; padding:90px 0 60px; font-family:'Inter',-apple-system,Segoe UI,Roboto,sans-serif; }
.ad-wrap { max-width:760px; margin:0 auto; padding:0 18px; }
.card { background:#fff; border-radius:18px; border:1px solid #e6ebf5; box-shadow:0 10px 32px rgba(15,23,42,.08); padding:30px; }

/* Intro */
.intro { text-align:center; }
.intro .ic { width:74px; height:74px; border-radius:20px; background:linear-gradient(135deg,#2563eb,#60a5fa); color:#fff; font-size:2rem; display:flex; align-items:center; justify-content:center; margin:0 auto 18px; }
.intro h1 { font-size:1.7rem; font-weight:800; color:#0f172a; margin:0 0 8px; }
.intro p { color:#64748b; max-width:520px; margin:0 auto 22px; line-height:1.6; }
.feat { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin:24px 0; }
@media(max-width:560px){ .feat{ grid-template-columns:1fr; } }
.feat .f { background:#f8fafc; border:1px solid #eef1f7; border-radius:12px; padding:16px 12px; }
.feat .f i { color:#2563eb; font-size:1.3rem; }
.feat .f .t { font-weight:700; color:#0f172a; font-size:.9rem; margin-top:6px; }
.feat .f .d { color:#94a3b8; font-size:.76rem; margin-top:3px; }
.btn-go { border:none; border-radius:12px; padding:14px 30px; font-weight:800; font-size:1.02rem; color:#fff; background:linear-gradient(135deg,#2563eb,#3b82f6); cursor:pointer; transition:.18s; display:inline-flex; align-items:center; gap:9px; }
.btn-go:hover:not(:disabled){ box-shadow:0 12px 30px rgba(37,99,235,.32); transform:translateY(-1px); }
.btn-go:disabled{ opacity:.6; cursor:not-allowed; }

/* Quiz */
.quiz { display:none; }
.qbar { display:flex; align-items:center; gap:14px; margin-bottom:18px; }
.qbar .track { flex:1; height:9px; background:#e4e9f4; border-radius:50px; overflow:hidden; }
.qbar .fill { height:100%; width:0; background:linear-gradient(90deg,#2563eb,#3b82f6); border-radius:50px; transition:width .4s; }
.qbar .lvl { font-size:.78rem; font-weight:800; color:#1d4ed8; white-space:nowrap; }
.diff-pills { display:flex; gap:4px; }
.diff-pills span { width:18px; height:6px; border-radius:50px; background:#e2e8f0; }
.diff-pills span.on { background:#f59e0b; }
.qno { font-size:.76rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px; color:#94a3b8; }
.qtext { font-size:1.18rem; font-weight:700; color:#0f172a; line-height:1.5; margin:8px 0 20px; }
.opts { display:flex; flex-direction:column; gap:11px; }
.opt { border:1.6px solid #e2e8f0; border-radius:12px; padding:15px 17px; cursor:pointer; font-size:.96rem; color:#1e293b; transition:.14s; display:flex; align-items:center; gap:12px; }
.opt:hover { border-color:#93c5fd; background:#f8fbff; }
.opt .dot { width:22px; height:22px; border-radius:50%; border:2px solid #cbd5e1; flex-shrink:0; transition:.14s; }
.opt.sel { border-color:#2563eb; background:#eff4ff; }
.opt.sel .dot { border-color:#2563eb; background:#2563eb; box-shadow:inset 0 0 0 3px #fff; }
.opt.correct { border-color:#16a34a; background:#f0fdf4; }
.opt.correct .dot { border-color:#16a34a; background:#16a34a; box-shadow:inset 0 0 0 3px #fff; }
.opt.wrong { border-color:#ef4444; background:#fef2f2; }
.opt.wrong .dot { border-color:#ef4444; background:#ef4444; box-shadow:inset 0 0 0 3px #fff; }
.opt.lock { pointer-events:none; }
.feedback { display:none; margin-top:16px; border-radius:12px; padding:14px 16px; font-size:.88rem; line-height:1.5; }
.feedback.ok { background:#f0fdf4; border:1px solid #bbf7d0; color:#14532d; }
.feedback.no { background:#fef2f2; border:1px solid #fecaca; color:#7f1d1d; }
.feedback .ttl { font-weight:800; display:flex; align-items:center; gap:7px; margin-bottom:4px; }
.qactions { margin-top:20px; display:flex; justify-content:flex-end; }
.btn-next { border:none; border-radius:11px; padding:12px 26px; font-weight:800; color:#fff; background:linear-gradient(135deg,#2563eb,#3b82f6); cursor:pointer; transition:.18s; }
.btn-next:disabled { opacity:.5; cursor:not-allowed; }
.spinner { width:16px; height:16px; border:2.5px solid rgba(255,255,255,.4); border-top-color:#fff; border-radius:50%; animation:spin .7s linear infinite; display:inline-block; vertical-align:middle; }
@keyframes spin { to { transform:rotate(360deg); } }
.err { display:none; background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:10px; padding:11px 14px; font-size:.86rem; margin-top:14px; }
</style>
@endsection

@section('content')
<div class="ad">
  <div class="ad-wrap">
    <div class="card">

      {{-- Intro --}}
      <div class="intro" id="introBox">
        <div class="ic"><i class="bi bi-graph-up-arrow"></i></div>
        <h1>{{ $test->title }} — Adaptive Challenge</h1>
        <p>This isn’t a normal test. Each question adapts to your skill: answer correctly and it gets harder, slip up and it eases off — until we pinpoint your true level.</p>

        <div class="feat">
          <div class="f"><i class="bi bi-bullseye"></i><div class="t">Adapts live</div><div class="d">Difficulty shifts every answer</div></div>
          <div class="f"><i class="bi bi-stack"></i><div class="t">{{ $test->max_questions ?? 12 }} questions</div><div class="d">Smart, not exhausting</div></div>
          <div class="f"><i class="bi bi-award"></i><div class="t">Your level</div><div class="d">A precise skill rating</div></div>
        </div>

        @if($poolCount < 3)
          <div class="err" style="display:block">This test doesn’t have enough pooled questions yet. Please check back soon.</div>
        @else
          <button class="btn-go" id="startBtn">
            <i class="bi bi-play-fill"></i> {{ $hasSession ? 'Resume Challenge' : 'Start Adaptive Challenge' }}
          </button>
        @endif
        <div class="err" id="startErr"></div>
      </div>

      {{-- Quiz --}}
      <div class="quiz" id="quizBox">
        <div class="qbar">
          <span class="qno" id="qNo">Question 1</span>
          <div class="track"><div class="fill" id="qFill"></div></div>
          <span class="lvl">Level <span id="lvlNum">2</span></span>
        </div>
        <div class="diff-pills" id="diffPills"></div>

        <div class="qtext" id="qText">Loading…</div>
        <div class="opts" id="optBox"></div>

        <div class="feedback" id="feedbackBox">
          <div class="ttl" id="fbTitle"></div>
          <div id="fbBody"></div>
        </div>

        <div class="err" id="quizErr"></div>

        <div class="qactions">
          <button class="btn-next" id="nextBtn" disabled>Submit Answer</button>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
  var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  var startUrl  = "{{ route('adaptive.start', $test->id) }}";
  var answerTpl = "{{ url('adaptive/session') }}/__SID__/answer";

  var introBox = document.getElementById('introBox');
  var quizBox  = document.getElementById('quizBox');
  var startBtn = document.getElementById('startBtn');
  var startErr = document.getElementById('startErr');

  var qNo = document.getElementById('qNo'), qFill = document.getElementById('qFill');
  var lvlNum = document.getElementById('lvlNum'), diffPills = document.getElementById('diffPills');
  var qText = document.getElementById('qText'), optBox = document.getElementById('optBox');
  var feedbackBox = document.getElementById('feedbackBox'), fbTitle = document.getElementById('fbTitle'), fbBody = document.getElementById('fbBody');
  var nextBtn = document.getElementById('nextBtn'), quizErr = document.getElementById('quizErr');

  var sessionId = @json($sessionId);
  var state = 'idle';       // 'answering' | 'reviewing'
  var current = null;       // current question payload
  var selectedOptionId = null;

  function post(url, body) {
    return fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
      body: JSON.stringify(body || {})
    }).then(function (r) { return r.json().then(function (d) { return { ok: r.ok, d: d }; }); });
  }

  function renderPills(level) {
    diffPills.innerHTML = '';
    for (var i = 1; i <= 5; i++) {
      var s = document.createElement('span');
      if (i <= level) s.className = 'on';
      diffPills.appendChild(s);
    }
  }

  function renderQuestion(payload) {
    current = payload.question;
    selectedOptionId = null;
    state = 'answering';
    feedbackBox.style.display = 'none';
    quizErr.style.display = 'none';

    var answered = payload.progress.answered, total = payload.progress.total;
    qNo.textContent = 'Question ' + (answered + 1) + ' of ' + total;
    qFill.style.width = ((answered / total) * 100) + '%';
    lvlNum.textContent = payload.current_level;
    renderPills(payload.current_level);

    qText.textContent = current.text;
    optBox.innerHTML = '';
    current.options.forEach(function (o) {
      var el = document.createElement('div');
      el.className = 'opt';
      el.dataset.id = o.id;
      el.innerHTML = '<span class="dot"></span><span>' + escapeHtml(o.text) + '</span>';
      el.addEventListener('click', function () {
        if (state !== 'answering') return;
        optBox.querySelectorAll('.opt').forEach(function (x) { x.classList.remove('sel'); });
        el.classList.add('sel');
        selectedOptionId = o.id;
        nextBtn.disabled = false;
      });
      optBox.appendChild(el);
    });

    nextBtn.disabled = true;
    nextBtn.textContent = 'Submit Answer';
  }

  function showFeedback(fb) {
    // Mark options correct/wrong and lock them.
    optBox.querySelectorAll('.opt').forEach(function (el) {
      el.classList.add('lock');
      var id = parseInt(el.dataset.id, 10);
      if (id === fb.correct_option_id) el.classList.add('correct');
      else if (id === selectedOptionId && !fb.correct) el.classList.add('wrong');
    });

    feedbackBox.className = 'feedback ' + (fb.correct ? 'ok' : 'no');
    feedbackBox.style.display = 'block';
    fbTitle.innerHTML = fb.correct
      ? '<i class="bi bi-check-circle-fill"></i> Correct! Difficulty increased to level ' + fb.current_level
      : '<i class="bi bi-x-circle-fill"></i> Not quite — difficulty eased to level ' + fb.current_level;
    fbBody.textContent = fb.explanation || '';
    lvlNum.textContent = fb.current_level;
    renderPills(fb.current_level);
  }

  function escapeHtml(s) {
    var d = document.createElement('div'); d.textContent = s; return d.innerHTML;
  }

  // Start / resume
  startBtn && startBtn.addEventListener('click', function () {
    startBtn.disabled = true;
    startErr.style.display = 'none';
    var orig = startBtn.innerHTML;
    startBtn.innerHTML = '<span class="spinner"></span> Preparing…';
    post(startUrl).then(function (res) {
      if (!res.ok) throw new Error(res.d.message || 'Could not start the session.');
      sessionId = res.d.session_id || sessionId;
      // start returns the first question payload directly
      introBox.style.display = 'none';
      quizBox.style.display = 'block';
      renderQuestion(res.d);
    }).catch(function (e) {
      startBtn.disabled = false; startBtn.innerHTML = orig;
      startErr.textContent = e.message; startErr.style.display = 'block';
    });
  });

  // Submit answer OR advance to next
  nextBtn.addEventListener('click', function () {
    if (state === 'answering') {
      if (!selectedOptionId) return;
      state = 'submitting';
      nextBtn.disabled = true;
      nextBtn.innerHTML = '<span class="spinner"></span>';
      var url = answerTpl.replace('__SID__', sessionId);
      post(url, { question_id: current.id, option_id: selectedOptionId }).then(function (res) {
        if (!res.ok) throw new Error(res.d.message || 'Could not submit your answer.');
        var d = res.d;
        if (d.feedback) showFeedback(d.feedback);

        if (d.done) {
          state = 'done';
          nextBtn.textContent = 'See Your Result →';
          nextBtn.disabled = false;
          nextBtn.onclick = function () { window.location = d.redirect; };
        } else {
          // stash next question to render when user clicks Next
          pendingNext = d;
          state = 'reviewing';
          nextBtn.textContent = 'Next Question →';
          nextBtn.disabled = false;
        }
      }).catch(function (e) {
        state = 'answering';
        nextBtn.disabled = false; nextBtn.textContent = 'Submit Answer';
        quizErr.textContent = e.message; quizErr.style.display = 'block';
      });
    } else if (state === 'reviewing') {
      renderQuestion(pendingNext);
      pendingNext = null;
    }
  });

  var pendingNext = null;
})();
</script>
@endsection
