@extends('frontend.layouts.app')
@section('title', 'Adaptive Result · ' . $test->title)

@section('styles')
<style>
.ar { background:#eef2fb; min-height:100vh; padding:90px 0 60px; font-family:'Inter',-apple-system,Segoe UI,Roboto,sans-serif; }
.ar-wrap { max-width:860px; margin:0 auto; padding:0 18px; }
.hero { background:linear-gradient(135deg,#0b1220,#1e3a8a 55%,#2563eb); color:#fff; border-radius:20px; padding:34px; text-align:center; position:relative; overflow:hidden; }
.hero::after { content:''; position:absolute; inset:0; background:radial-gradient(circle at 80% 15%,rgba(255,255,255,.12),transparent 45%); }
.hero > * { position:relative; z-index:2; }
.hero .ey { font-size:.74rem; letter-spacing:2px; text-transform:uppercase; opacity:.65; font-weight:700; }
.band { font-size:2.2rem; font-weight:900; margin:8px 0 2px; }
.lvl { opacity:.85; font-weight:600; }
.score-ring { width:150px; height:150px; margin:18px auto 0; position:relative; }
.score-ring svg { transform:rotate(-90deg); }
.score-ring .mid { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.score-ring .n { font-size:2.4rem; font-weight:900; }
.score-ring .o { font-size:.66rem; opacity:.7; letter-spacing:1px; }

.cards { display:grid; grid-template-columns:repeat(4,1fr); gap:12px; margin:18px 0; }
@media(max-width:620px){ .cards{ grid-template-columns:1fr 1fr; } }
.kpi { background:#fff; border:1px solid #e6ebf5; border-radius:14px; padding:16px; text-align:center; box-shadow:0 6px 20px rgba(15,23,42,.05); }
.kpi .v { font-size:1.5rem; font-weight:900; color:#0f172a; }
.kpi .l { font-size:.7rem; color:#64748b; font-weight:700; text-transform:uppercase; letter-spacing:.4px; margin-top:4px; }

.card { background:#fff; border:1px solid #e6ebf5; border-radius:16px; padding:24px; box-shadow:0 8px 26px rgba(15,23,42,.06); margin-bottom:18px; }
.card h5 { font-weight:800; color:#0f172a; margin:0 0 4px; display:flex; align-items:center; gap:8px; }
.card h5 .ic { color:#2563eb; }
.card .hint { color:#94a3b8; font-size:.84rem; margin:0 0 16px; }

.legend { display:flex; gap:18px; margin-top:12px; font-size:.8rem; color:#64748b; }
.legend i { font-style:normal; }
.dotc { display:inline-block; width:10px; height:10px; border-radius:50%; vertical-align:middle; margin-right:5px; }

.btns { display:flex; gap:12px; flex-wrap:wrap; }
.btn-a { flex:1; min-width:180px; text-align:center; padding:13px; border-radius:12px; font-weight:800; text-decoration:none; transition:.18s; }
.btn-primary2 { background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff; }
.btn-primary2:hover { box-shadow:0 10px 26px rgba(37,99,235,.3); color:#fff; }
.btn-ghost2 { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
.btn-ghost2:hover { background:#eef4ff; color:#2563eb; }
</style>
@endsection

@php
  $log = $session->log ?? [];
  $score = (int) ($session->final_score ?? 0);
  $radius = 64; $circ = 2 * M_PI * $radius; $offset = $circ - ($score/100)*$circ;
  $accuracy = $session->questions_answered ? round($session->correct_count / $session->questions_answered * 100) : 0;
@endphp

@section('content')
<div class="ar">
  <div class="ar-wrap">

    <div class="hero">
      <div class="ey">Adaptive Result · {{ $test->title }}</div>
      <div class="band">{{ $session->final_band }}</div>
      <div class="lvl">Your skill rating is {{ (int) round($session->ability) }} / 100</div>
      <div class="score-ring">
        <svg width="150" height="150">
          <circle cx="75" cy="75" r="64" fill="none" stroke="rgba(255,255,255,.16)" stroke-width="11"/>
          <circle cx="75" cy="75" r="64" fill="none" stroke="#34d399" stroke-width="11" stroke-linecap="round"
                  stroke-dasharray="{{ $circ }}" stroke-dashoffset="{{ $circ }}" id="ring" data-target="{{ $offset }}"/>
        </svg>
        <div class="mid"><div class="n" id="scoreNum" data-target="{{ $score }}">0</div><div class="o">SKILL SCORE</div></div>
      </div>
    </div>

    <div class="cards">
      <div class="kpi"><div class="v">{{ $session->questions_answered }}</div><div class="l">Questions</div></div>
      <div class="kpi"><div class="v" style="color:#16a34a">{{ $session->correct_count }}</div><div class="l">Correct</div></div>
      <div class="kpi"><div class="v" style="color:#ef4444">{{ $session->wrong_count }}</div><div class="l">Wrong</div></div>
      <div class="kpi"><div class="v">{{ $accuracy }}%</div><div class="l">Accuracy</div></div>
    </div>

    <div class="card">
      <h5><i class="bi bi-graph-up ic"></i>How your skill rating evolved</h5>
      <p class="hint">Each point is a question. Your rating rose when you answered correctly and dropped when you missed — converging on your true skill level.</p>
      <canvas id="diffChart" height="170"></canvas>
      <div class="legend">
        <i><span class="dotc" style="background:#16a34a"></span>Correct</i>
        <i><span class="dotc" style="background:#ef4444"></span>Wrong</i>
        <i><span class="dotc" style="background:#2563eb"></span>Skill rating (0–100)</i>
      </div>
    </div>

    <div class="card">
      <h5><i class="bi bi-flag ic"></i>What this means</h5>
      <p class="hint" style="margin:0">
        @switch($session->final_band)
          @case('Expert') You’re performing at the top tier — comfortably handling the hardest questions. Aim for real-world projects and advanced certifications. @break
          @case('Advanced') Strong command of the topic. A little more practice on edge cases and you’ll reach Expert. @break
          @case('Intermediate') Solid foundation. Focus on the harder concepts where the difficulty dipped to climb higher. @break
          @case('Elementary') You’ve got the basics. Drill the core concepts and retake to push your level up. @break
          @default Great start! Review the fundamentals and try again — your level will climb quickly. @break
        @endswitch
      </p>
    </div>

    <div class="btns">
      <a href="{{ route('adaptive.show', $test->id) }}" class="btn-a btn-primary2"><i class="bi bi-arrow-repeat"></i> Retake Adaptive Test</a>
      <a href="{{ route('tests.index') }}" class="btn-a btn-ghost2"><i class="bi bi-grid"></i> Browse More Tests</a>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Score + ring animation
  var n = document.getElementById('scoreNum'), target = {{ $score }}, cur = 0;
  var t = setInterval(function(){ cur += Math.max(1, Math.round(target/40)); if (cur>=target){cur=target;clearInterval(t);} n.textContent = cur; }, 22);
  var ring = document.getElementById('ring');
  if (ring) setTimeout(function(){ ring.style.transition='stroke-dashoffset 1.1s ease'; ring.style.strokeDashoffset = ring.dataset.target; }, 120);

  // Skill-rating progression chart (0–100 Elo ability)
  var log = @json($log);
  var labels = log.map(function(_, i){ return 'Q' + (i+1); });
  var data = log.map(function(e){ return e.ability; });
  var ptColors = log.map(function(e){ return e.correct ? '#16a34a' : '#ef4444'; });

  new Chart(document.getElementById('diffChart'), {
    type: 'line',
    data: { labels: labels, datasets: [{
      data: data, borderColor: '#2563eb', borderWidth: 2.5, tension: .3,
      fill: true, backgroundColor: 'rgba(37,99,235,.08)',
      pointBackgroundColor: ptColors, pointBorderColor: ptColors, pointRadius: 6, pointHoverRadius: 8
    }]},
    options: {
      scales: {
        y: { min: 0, max: 100, ticks: { stepSize: 20, color:'#94a3b8' }, grid:{color:'#eef1f7'} },
        x: { ticks:{ color:'#94a3b8' }, grid:{ display:false } }
      },
      plugins: { legend: { display: false }, tooltip: { callbacks: {
        label: function(c){ var e = log[c.dataIndex]; return 'Skill ' + e.ability + '/100 · Q-difficulty ' + e.difficulty + '/10 · ' + (e.correct ? 'Correct' : 'Wrong'); }
      }}}
    }
  });
});
</script>
@endsection
