@extends('frontend.layouts.app')
@section('title', 'ATS Analysis Report')

@section('styles')
<style>
.ats { background:#eef2fb; min-height:100vh; padding-bottom:60px; font-family:'Inter',-apple-system,Segoe UI,Roboto,sans-serif; }
.ats-hero { background:linear-gradient(135deg,#0b1220 0%,#1e3a8a 55%,#2563eb 100%); color:#fff; padding:54px 0 90px; position:relative; overflow:hidden; }
.ats-hero::after { content:''; position:absolute; inset:0; background:radial-gradient(circle at 80% 20%,rgba(255,255,255,.12),transparent 45%); }
.ats-hero .container { position:relative; z-index:2; }
.ats-eyebrow { font-size:.75rem; letter-spacing:2px; text-transform:uppercase; opacity:.65; font-weight:700; }
.ats-hero h1 { font-size:1.9rem; font-weight:800; margin:6px 0 0; }
.ats-hero .sub { opacity:.8; font-size:.95rem; margin-top:6px; }

.ring-wrap { display:flex; align-items:center; gap:26px; flex-wrap:wrap; }
.ring { position:relative; width:160px; height:160px; flex-shrink:0; }
.ring svg { transform:rotate(-90deg); }
.ring .ring-center { position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; }
.ring .num { font-size:2.8rem; font-weight:900; line-height:1; }
.ring .out-of { font-size:.7rem; opacity:.7; margin-top:2px; letter-spacing:1px; }
.verdict { }
.verdict .badge-v { display:inline-block; padding:7px 16px; border-radius:50px; font-weight:800; font-size:.85rem; margin-bottom:10px; }
.verdict h2 { font-size:1.4rem; font-weight:800; margin:0 0 6px; }
.verdict p { opacity:.85; font-size:.92rem; max-width:380px; margin:0; }

.wrap { max-width:980px; margin:-56px auto 0; padding:0 18px; position:relative; z-index:5; }
.grid { display:grid; grid-template-columns:1fr 320px; gap:18px; }
@media(max-width:860px){ .grid{ grid-template-columns:1fr; } }

.card { background:#fff; border-radius:16px; border:1px solid #e6ebf5; padding:22px; box-shadow:0 6px 24px rgba(15,23,42,.06); margin-bottom:18px; }
.card h5 { font-size:1.02rem; font-weight:800; color:#0f172a; margin:0 0 16px; display:flex; align-items:center; gap:8px; }
.card h5 .ic { color:#2563eb; }

.user-head { display:flex; align-items:center; gap:16px; }
.avatar { width:62px; height:62px; border-radius:16px; background:linear-gradient(135deg,#2563eb,#60a5fa); color:#fff; font-size:1.5rem; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.user-head .name { font-size:1.2rem; font-weight:800; color:#0f172a; margin:0; }
.user-head .title { color:#2563eb; font-weight:600; font-size:.9rem; margin:2px 0 0; }
.contact-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-top:18px; padding-top:18px; border-top:1px solid #eef1f7; }
@media(max-width:520px){ .contact-grid{ grid-template-columns:1fr; } }
.c-item { display:flex; gap:10px; align-items:flex-start; font-size:.86rem; }
.c-item .ci { width:30px; height:30px; border-radius:8px; background:#eff4ff; color:#2563eb; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.c-item .cl { color:#94a3b8; font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.4px; }
.c-item .cv { color:#0f172a; font-weight:600; word-break:break-word; }
.c-item a.cv { color:#2563eb; text-decoration:none; }
.c-item a.cv:hover { text-decoration:underline; }
.missing { color:#cbd5e1; font-weight:600; }

.skill-group { margin-bottom:14px; }
.skill-group:last-child { margin-bottom:0; }
.skill-group .sg-label { font-size:.7rem; font-weight:800; text-transform:uppercase; letter-spacing:.5px; color:#94a3b8; margin-bottom:7px; }
.tags { display:flex; flex-wrap:wrap; gap:7px; }
.tag { background:#eff4ff; color:#1d4ed8; padding:5px 13px; border-radius:50px; font-size:.78rem; font-weight:600; border:1px solid #dbe7ff; }

.cat { margin-bottom:16px; }
.cat:last-child { margin-bottom:0; }
.cat-top { display:flex; justify-content:space-between; align-items:baseline; margin-bottom:7px; }
.cat-top .cn { font-weight:700; color:#1e293b; font-size:.9rem; }
.cat-top .cs { font-weight:800; font-size:.82rem; }
.track { height:9px; background:#eef1f7; border-radius:50px; overflow:hidden; }
.fill { height:100%; border-radius:50px; width:0; transition:width 1s cubic-bezier(.4,0,.2,1); }

.rec { display:flex; gap:13px; padding:14px 16px; border-radius:12px; background:#fff8ed; border:1px solid #fde9c8; margin-bottom:11px; }
.rec:last-child { margin-bottom:0; }
.rec .rn { width:26px; height:26px; border-radius:50%; background:#f59e0b; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:.82rem; flex-shrink:0; }
.rec .rt { font-size:.88rem; color:#92580a; line-height:1.5; font-weight:500; }
.all-good { display:flex; gap:12px; align-items:center; padding:16px; border-radius:12px; background:#ecfdf5; border:1px solid #bbf7d0; color:#065f46; font-weight:600; font-size:.9rem; }

.stats { display:grid; grid-template-columns:1fr 1fr; gap:11px; }
.stat { background:linear-gradient(135deg,#f8faff,#eef4ff); border:1px solid #e6ecfb; border-radius:12px; padding:14px 12px; text-align:center; }
.stat .sv { font-size:1.45rem; font-weight:900; color:#1e293b; line-height:1; }
.stat .sl { font-size:.68rem; color:#64748b; font-weight:700; text-transform:uppercase; letter-spacing:.4px; margin-top:6px; }

.cta { background:linear-gradient(135deg,#1e3a8a,#2563eb); border:none; color:#fff; }
.cta h5 { color:#fff; }
.cta p { font-size:.86rem; opacity:.85; margin:0 0 14px; }
.btn-stack { display:flex; flex-direction:column; gap:9px; }
.btn-a { display:flex; align-items:center; justify-content:center; gap:7px; padding:11px; border-radius:10px; font-weight:700; font-size:.9rem; text-decoration:none; transition:.18s; }
.btn-white { background:#fff; color:#1e3a8a; }
.btn-white:hover { background:#eef4ff; color:#1e3a8a; }
.btn-ghost { background:rgba(255,255,255,.12); color:#fff; border:1px solid rgba(255,255,255,.25); }
.btn-ghost:hover { background:rgba(255,255,255,.22); color:#fff; }

.note { font-size:.8rem; color:#94a3b8; margin-top:10px; }
</style>
@endsection

@php
    $score      = (int) ($result['score'] ?? 0);
    $breakdown  = $result['breakdown'] ?? [];
    $contact    = $result['contact'] ?? [];
    $skills     = $result['skills_found'] ?? [];
    $grouped    = $result['skills_grouped'] ?? [];
    $suggestions= array_slice($result['suggestions'] ?? [], 0, 4);
    $notes      = $result['notes'] ?? [];

    if ($score >= 85)      { $tier='excellent'; $vColor='#10b981'; $vBg='#d1fae5'; $vText='#065f46'; $vLabel='Excellent'; $vMsg='Your resume is highly ATS-compatible. Recruiters and parsing systems will read it cleanly.'; }
    elseif ($score >= 70)  { $tier='good';      $vColor='#3b82f6'; $vBg='#dbeafe'; $vText='#1e40af'; $vLabel='Good';      $vMsg='Solid resume. A few tweaks below will push it into the top tier.'; }
    elseif ($score >= 50)  { $tier='average';   $vColor='#f59e0b'; $vBg='#fef3c7'; $vText='#92400e'; $vLabel='Needs Work'; $vMsg='Your resume passes basic checks but is leaving points on the table. Apply the fixes below.'; }
    else                   { $tier='poor';      $vColor='#ef4444'; $vBg='#fee2e2'; $vText='#991b1b'; $vLabel='At Risk';   $vMsg='This resume may be filtered out by ATS systems. Prioritise the recommendations below.'; }

    $nameForInit = $contact['name'] ?? (($user ?? null)?->name ?? 'Resume');
    $initParts = preg_split('/\s+/', trim($nameForInit));
    $initials = strtoupper(substr($initParts[0] ?? 'R', 0, 1) . (isset($initParts[1]) ? substr($initParts[1], 0, 1) : ''));

    // SVG ring math
    $radius = 70; $circ = 2 * M_PI * $radius; $offset = $circ - ($score / 100) * $circ;

    // Category definitions with real maximums for accurate percentages
    $cats = [
        ['Contact Info',  $breakdown['contact_score'] ?? 0,     17, '#2563eb'],
        ['Structure',     $breakdown['structure_score'] ?? 0,   32, '#7c3aed'],
        ['Achievements',  $breakdown['achievement_score'] ?? 0, 20, '#0ea5e9'],
        ['Formatting',    $breakdown['format_score'] ?? 0,      19, '#10b981'],
        ['Writing',       $breakdown['quality_score'] ?? 0,      5, '#f59e0b'],
    ];
@endphp

@section('content')
<div class="ats">

  {{-- Hero --}}
  <div class="ats-hero">
    <div class="container">
      <div class="ats-eyebrow">ATS Analysis Report</div>
      <h1>Resume Compatibility Score</h1>
      <p class="sub">{{ ($job['original'] ?? null) ?: 'Your resume' }} &middot; analysed against applicant tracking system standards</p>

      <div class="ring-wrap" style="margin-top:30px">
        <div class="ring">
          <svg width="160" height="160">
            <circle cx="80" cy="80" r="70" fill="none" stroke="rgba(255,255,255,.15)" stroke-width="12"/>
            <circle cx="80" cy="80" r="70" fill="none" stroke="{{ $vColor }}" stroke-width="12"
                    stroke-linecap="round" stroke-dasharray="{{ $circ }}"
                    stroke-dashoffset="{{ $circ }}" id="ringFill"
                    data-target="{{ $offset }}"/>
          </svg>
          <div class="ring-center">
            <div class="num" id="scoreNum" data-target="{{ $score }}">0</div>
            <div class="out-of">/ 100</div>
          </div>
        </div>
        <div class="verdict">
          <span class="badge-v" style="background:{{ $vBg }};color:{{ $vText }}">{{ $vLabel }}</span>
          <h2>{{ $vLabel === 'Excellent' ? 'Great job!' : 'Here’s your breakdown' }}</h2>
          <p>{{ $vMsg }}</p>
        </div>
      </div>
    </div>
  </div>

  {{-- Body --}}
  <div class="wrap">
    <div class="grid">

      {{-- LEFT --}}
      <div>

        {{-- Candidate --}}
        <div class="card">
          <div class="user-head">
            <div class="avatar">{{ $initials }}</div>
            <div>
              <p class="name">{{ $contact['name'] ?? (($user ?? null)?->name ?? 'Candidate') }}</p>
              @if(!empty($contact['title']))<p class="title">{{ $contact['title'] }}</p>@endif
            </div>
          </div>

          <div class="contact-grid">
            <div class="c-item">
              <div class="ci"><i class="bi bi-envelope"></i></div>
              <div><div class="cl">Email</div>
                @if(!empty($contact['email']))<div class="cv">{{ $contact['email'] }}</div>
                @else<div class="cv missing">Not found</div>@endif
              </div>
            </div>
            <div class="c-item">
              <div class="ci"><i class="bi bi-telephone"></i></div>
              <div><div class="cl">Phone</div>
                @if(!empty($contact['phone']))<div class="cv">{{ $contact['phone'] }}</div>
                @else<div class="cv missing">Not found</div>@endif
              </div>
            </div>
            <div class="c-item">
              <div class="ci"><i class="bi bi-geo-alt"></i></div>
              <div><div class="cl">Location</div>
                @if(!empty($contact['location']))<div class="cv">{{ $contact['location'] }}</div>
                @else<div class="cv missing">Not found</div>@endif
              </div>
            </div>
            <div class="c-item">
              <div class="ci"><i class="bi bi-linkedin"></i></div>
              <div><div class="cl">LinkedIn</div>
                @if(!empty($contact['linkedin']))<a class="cv" href="{{ \Illuminate\Support\Str::startsWith($contact['linkedin'],'http') ? $contact['linkedin'] : 'https://'.$contact['linkedin'] }}" target="_blank" rel="noopener">View profile</a>
                @else<div class="cv missing">Not found</div>@endif
              </div>
            </div>
            @if(!empty($contact['github']))
            <div class="c-item">
              <div class="ci"><i class="bi bi-github"></i></div>
              <div><div class="cl">GitHub</div><a class="cv" href="{{ \Illuminate\Support\Str::startsWith($contact['github'],'http') ? $contact['github'] : 'https://'.$contact['github'] }}" target="_blank" rel="noopener">View profile</a></div>
            </div>
            @endif
            @if(!empty($contact['website']))
            <div class="c-item">
              <div class="ci"><i class="bi bi-globe"></i></div>
              <div><div class="cl">Website</div><a class="cv" href="{{ $contact['website'] }}" target="_blank" rel="noopener">{{ \Illuminate\Support\Str::limit(preg_replace('#https?://#','',$contact['website']),28) }}</a></div>
            </div>
            @endif
          </div>
        </div>

        {{-- Skills --}}
        @if(!empty($skills))
        <div class="card">
          <h5><i class="bi bi-stars ic"></i>Skills Detected <span style="color:#94a3b8;font-weight:600;font-size:.8rem">({{ count($skills) }})</span></h5>
          @forelse($grouped as $category => $list)
            <div class="skill-group">
              <div class="sg-label">{{ $category }}</div>
              <div class="tags">@foreach($list as $s)<span class="tag">{{ $s }}</span>@endforeach</div>
            </div>
          @empty
            <div class="tags">@foreach($skills as $s)<span class="tag">{{ $s }}</span>@endforeach</div>
          @endforelse
        </div>
        @endif

        @if($isPro ?? false)
        {{-- Breakdown --}}
        <div class="card">
          <h5><i class="bi bi-bar-chart-line ic"></i>Score Breakdown</h5>
          @foreach($cats as [$cn, $cv, $cmax, $col])
            @php $pct = $cmax > 0 ? min(100, round(($cv/$cmax)*100)) : 0; @endphp
            <div class="cat">
              <div class="cat-top">
                <span class="cn">{{ $cn }}</span>
                <span class="cs" style="color:{{ $col }}">{{ $cv }}/{{ $cmax }}</span>
              </div>
              <div class="track"><div class="fill" style="background:{{ $col }}" data-w="{{ $pct }}"></div></div>
            </div>
          @endforeach
        </div>

        {{-- Recommendations --}}
        <div class="card">
          <h5><i class="bi bi-lightbulb ic"></i>Top Recommendations</h5>
          @if(!empty($suggestions))
            @foreach($suggestions as $i => $s)
              <div class="rec"><div class="rn">{{ $i+1 }}</div><div class="rt">{{ $s }}</div></div>
            @endforeach
          @else
            <div class="all-good"><i class="bi bi-check-circle-fill" style="font-size:1.2rem"></i> No critical issues found — your resume is well optimised.</div>
          @endif
        </div>
        @else
        {{-- Free user: lock advanced breakdown + recommendations behind Pro --}}
        <div class="card" style="text-align:center;border:2px dashed #c7d4ee;background:linear-gradient(135deg,#f8faff,#eef4ff)">
          <div style="width:58px;height:58px;border-radius:16px;background:linear-gradient(135deg,#2563eb,#60a5fa);color:#fff;font-size:1.5rem;display:flex;align-items:center;justify-content:center;margin:4px auto 14px"><i class="bi bi-lock-fill"></i></div>
          <h5 style="justify-content:center">Unlock your full ATS report</h5>
          <p style="color:#64748b;font-size:.9rem;max-width:420px;margin:0 auto 16px">You’ve got your score. Upgrade to <strong>Pro</strong> for the category-by-category breakdown and personalised recommendations to fix your resume.</p>
          <a href="{{ route('pricing') }}" style="display:inline-flex;align-items:center;gap:7px;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;padding:12px 26px;border-radius:11px;font-weight:800;text-decoration:none"><i class="bi bi-stars"></i> Upgrade to Pro</a>
        </div>
        @endif

      </div>

      {{-- RIGHT --}}
      <div>
        <div class="card">
          <h5><i class="bi bi-clipboard-data ic"></i>Resume Stats</h5>
          <div class="stats">
            <div class="stat"><div class="sv">{{ $result['word_count'] ?? 0 }}</div><div class="sl">Words</div></div>
            <div class="stat"><div class="sv">{{ $breakdown['keywords_found'] ?? 0 }}</div><div class="sl">Keywords</div></div>
            <div class="stat"><div class="sv">{{ $breakdown['metrics_found'] ?? 0 }}</div><div class="sl">Metrics</div></div>
            <div class="stat"><div class="sv">{{ $breakdown['action_verbs_found'] ?? 0 }}</div><div class="sl">Action Verbs</div></div>
            <div class="stat"><div class="sv">{{ $breakdown['date_ranges_found'] ?? 0 }}</div><div class="sl">Date Ranges</div></div>
            <div class="stat"><div class="sv">{{ count($skills) }}</div><div class="sl">Skills</div></div>
          </div>
        </div>

        <div class="card cta">
          <h5 style="color:#fff"><i class="bi bi-rocket-takeoff"></i>Next Steps</h5>
          <p>Apply the recommendations, then re-check your resume to track improvement.</p>
          <div class="btn-stack">
            <a href="{{ route('ats') }}" class="btn-a btn-white"><i class="bi bi-arrow-repeat"></i> Check Another Resume</a>
            <a href="{{ route('blog.index') }}" class="btn-a btn-ghost"><i class="bi bi-journal-text"></i> Resume Writing Tips</a>
          </div>
        </div>
      </div>

    </div>

    @if(!empty($notes) && empty($result['raw']))
      <p class="note"><i class="bi bi-info-circle"></i> {{ $notes[0] }}</p>
    @endif
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Animate score number
  var numEl = document.getElementById('scoreNum');
  var target = parseInt(numEl.dataset.target, 10) || 0;
  var cur = 0, step = Math.max(1, Math.round(target / 40));
  var t = setInterval(function () {
    cur += step;
    if (cur >= target) { cur = target; clearInterval(t); }
    numEl.textContent = cur;
  }, 22);

  // Animate ring
  var ring = document.getElementById('ringFill');
  if (ring) { setTimeout(function () { ring.style.transition = 'stroke-dashoffset 1.1s ease'; ring.style.strokeDashoffset = ring.dataset.target; }, 120); }

  // Animate bars
  setTimeout(function () {
    document.querySelectorAll('.fill').forEach(function (el) { el.style.width = el.dataset.w + '%'; });
  }, 200);
});
</script>
@endsection
