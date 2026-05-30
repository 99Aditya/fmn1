@extends('frontend.layouts.app')
@section('title', $user->name . ' — Profile')

@section('styles')
<style>
.pub-page { background: #f4f7ff; min-height: 100vh; padding-bottom: 60px; }

/* ── Cover + Avatar ── */
.cover-wrap { position: relative; height: 220px; background: linear-gradient(135deg,#0f172a,#1e40af,#3b82f6); }
.cover-wrap img.cover-img { width:100%; height:100%; object-fit:cover; }
.cover-overlay { position:absolute;inset:0;background:linear-gradient(135deg,rgba(15,23,42,.6),rgba(30,64,175,.4)); }
.avatar-area { position:relative; margin-top:-64px; display:flex; align-items:flex-end; gap:20px; flex-wrap:wrap; }
.avatar-ring {
  width:128px; height:128px;
  border-radius:50%;
  border:4px solid #fff;
  box-shadow:0 8px 24px rgba(0,0,0,.18);
  overflow:hidden;
  flex-shrink:0;
  background:#e2e8f0;
}
.avatar-ring img { width:100%; height:100%; object-fit:cover; }
.profile-name { font-size:1.5rem; font-weight:800; color:#0f172a; margin:0; }
.profile-headline { font-size:.95rem; color:#64748b; margin:2px 0 0; }
.profile-location { font-size:.82rem; color:#94a3b8; margin-top:4px; }

/* ── Action buttons ── */
.profile-actions { display:flex; gap:8px; flex-wrap:wrap; margin-top:12px; }
.btn-connect { display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:50px;font-weight:700;font-size:.88rem;cursor:pointer;border:2px solid transparent;transition:all .18s; }
.btn-connect.primary { background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff; }
.btn-connect.primary:hover { opacity:.88;box-shadow:0 4px 16px rgba(37,99,235,.3);color:#fff; }
.btn-connect.outline { border-color:#e2e8f0;background:#fff;color:#475569; }
.btn-connect.outline:hover { border-color:#2563eb;color:#2563eb;background:#eff6ff; }
.btn-connect.success { background:#d1fae5;color:#065f46;border-color:#86efac; }
.btn-connect.warning { background:#fef3c7;color:#92400e;border-color:#fde68a; }

/* ── Stats row ── */
.stats-row { display:flex; gap:24px; flex-wrap:wrap; padding:16px 0; border-top:1.5px solid #f1f5f9; border-bottom:1.5px solid #f1f5f9; margin:16px 0; }
.stat-item-p .num { font-size:1.3rem;font-weight:800;color:#0f172a; }
.stat-item-p .lbl { font-size:.72rem;color:#94a3b8;text-transform:uppercase;letter-spacing:.4px; }

/* ── Share chip ── */
.share-chip { display:inline-flex;align-items:center;gap:6px;background:#f8faff;border:1.5px solid #e2e8f0;border-radius:50px;padding:5px 14px;font-size:.75rem;font-weight:600;color:#64748b;cursor:pointer;transition:all .15s; }
.share-chip:hover { border-color:#2563eb;color:#2563eb;background:#eff6ff; }

/* ── Section cards ── */
.section-card { background:#fff;border-radius:16px;border:1.5px solid #e8edf5;padding:24px;margin-bottom:18px;box-shadow:0 2px 12px rgba(0,0,0,.05); }
.section-title { font-size:1rem;font-weight:800;color:#0f172a;margin-bottom:18px;display:flex;align-items:center;gap:8px; }
.section-title i { color:#2563eb; }

/* ── Skill chips ── */
.skill-chips { display:flex;flex-wrap:wrap;gap:8px; }
.skill-chip { display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:50px;font-size:.8rem;font-weight:600;border:1.5px solid; }
.skill-chip.beginner { background:#f0fdf4;color:#166534;border-color:#86efac; }
.skill-chip.intermediate { background:#eff6ff;color:#1e40af;border-color:#93c5fd; }
.skill-chip.advanced { background:#f5f3ff;color:#5b21b6;border-color:#c4b5fd; }
.skill-chip.expert { background:#fff7ed;color:#9a3412;border-color:#fdba74; }

/* ── Timeline (exp / edu) ── */
.timeline { position:relative; padding-left:28px; }
.timeline::before { content:'';position:absolute;left:9px;top:0;bottom:0;width:2px;background:#e2e8f0;border-radius:2px; }
.timeline-item { position:relative;margin-bottom:24px; }
.timeline-item:last-child { margin-bottom:0; }
.timeline-dot { position:absolute;left:-28px;top:4px;width:18px;height:18px;border-radius:50%;background:#2563eb;border:3px solid #fff;box-shadow:0 0 0 2px #bfdbfe; }
.timeline-title { font-weight:700;color:#0f172a;font-size:.95rem; }
.timeline-sub { font-size:.85rem;color:#2563eb;font-weight:600; }
.timeline-date { font-size:.75rem;color:#94a3b8;margin-top:2px; }
.timeline-desc { font-size:.83rem;color:#64748b;margin-top:6px;line-height:1.55; }

/* ── Cert cards (mini) ── */
.cert-mini-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px; }
.cert-mini-card { background:linear-gradient(135deg,#1e3a5f,#1e40af);border-radius:12px;padding:16px;color:#fff;position:relative;overflow:hidden; }
.cert-mini-card::before { content:'🏆';position:absolute;right:-4px;top:-4px;font-size:3rem;opacity:.15; }
.cert-mini-card .c-title { font-size:.82rem;font-weight:700;line-height:1.3; }
.cert-mini-card .c-score { font-size:.72rem;opacity:.7;margin-top:4px; }
.cert-mini-card .c-date { font-size:.68rem;opacity:.55;margin-top:2px; }
.cert-mini-card .c-view { display:inline-flex;align-items:center;gap:4px;margin-top:10px;background:rgba(255,255,255,.15);border-radius:50px;padding:4px 12px;font-size:.72rem;font-weight:700;text-decoration:none;color:#fff;transition:background .15s; }
.cert-mini-card .c-view:hover { background:rgba(255,255,255,.28); }

/* ── Social links ── */
.social-links { display:flex;flex-wrap:wrap;gap:8px; }
.social-link { display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;font-size:.8rem;font-weight:600;text-decoration:none;transition:all .15s; }
.social-link.li { background:#eff6ff;color:#1e40af; }
.social-link.gh { background:#f8faff;color:#0f172a; }
.social-link.tw { background:#e0f2fe;color:#0369a1; }
.social-link.web { background:#f0fdf4;color:#166534; }
.social-link:hover { transform:translateY(-2px);box-shadow:0 4px 12px rgba(0,0,0,.1); }

/* ── Test stats ── */
.test-stat-row { display:flex;gap:16px;flex-wrap:wrap; }
.test-stat-box { flex:1;min-width:80px;background:#f8faff;border-radius:12px;padding:12px;text-align:center; }
.test-stat-box .n { font-size:1.4rem;font-weight:800;color:#0f172a; }
.test-stat-box .l { font-size:.68rem;color:#94a3b8;text-transform:uppercase;letter-spacing:.3px;margin-top:2px; }

@media(max-width:576px) {
  .cover-wrap { height:160px; }
  .avatar-ring { width:96px;height:96px; }
  .stats-row { gap:16px; }
  .cert-mini-grid { grid-template-columns:1fr; }
}
</style>
@endsection

@section('content')
<div class="pub-page">

  {{-- Cover --}}
  <div class="cover-wrap">
    @if($profile->cover_photo)
      <img src="{{ asset('storage/'.$profile->cover_photo) }}" class="cover-img" alt="">
    @endif
    <div class="cover-overlay"></div>
  </div>

  <div class="container" style="max-width:900px">

    {{-- Avatar + name + actions --}}
    <div class="avatar-area">
      <div class="avatar-ring">
        <img src="{{ $profile->avatar_url }}" alt="{{ $user->name }}">
      </div>
      <div class="flex-grow-1 pb-2">
        <h1 class="profile-name">{{ $user->name }}</h1>
        @if($profile->headline)
          <div class="profile-headline">{{ $profile->headline }}</div>
        @endif
        @if($profile->location)
          <div class="profile-location"><i class="bi bi-geo-alt me-1"></i>{{ $profile->location }}</div>
        @endif
      </div>
    </div>

    <div class="profile-actions mt-3">
      @if(! $isOwner && auth()->check())
        @if(! $connection)
          <form action="{{ route('connections.connect', $user) }}" method="POST" class="d-inline">
            @csrf
            <button class="btn-connect primary"><i class="bi bi-person-plus-fill"></i> Connect</button>
          </form>
        @elseif($connection->status === 'pending' && $connection->requester_id === auth()->id())
          <button class="btn-connect warning" disabled><i class="bi bi-clock"></i> Request Sent</button>
        @elseif($connection->status === 'pending' && $connection->receiver_id === auth()->id())
          <form action="{{ route('connections.accept', $connection) }}" method="POST" class="d-inline">@csrf
            <button class="btn-connect success"><i class="bi bi-check-lg"></i> Accept</button>
          </form>
          <form action="{{ route('connections.reject', $connection) }}" method="POST" class="d-inline">@csrf
            <button class="btn-connect outline">Decline</button>
          </form>
        @elseif($connection->status === 'accepted')
          <button class="btn-connect success" disabled><i class="bi bi-people-fill"></i> Connected</button>
          <form action="{{ route('connections.remove', $user) }}" method="POST" class="d-inline">@csrf @method('DELETE')
            <button class="btn-connect outline" onclick="return confirm('Remove connection?')">Remove</button>
          </form>
        @endif

        @if($isFollowing)
          <form action="{{ route('unfollow', $user) }}" method="POST" class="d-inline">@csrf @method('DELETE')
            <button class="btn-connect outline"><i class="bi bi-person-check-fill"></i> Following</button>
          </form>
        @else
          <form action="{{ route('follow', $user) }}" method="POST" class="d-inline">@csrf
            <button class="btn-connect outline"><i class="bi bi-person-plus"></i> Follow</button>
          </form>
        @endif
      @elseif($isOwner)
        <a href="{{ route('profile.edit') }}" class="btn-connect outline"><i class="bi bi-pencil-fill"></i> Edit Profile</a>
      @endif

      <button class="share-chip" onclick="copyProfileLink()" id="shareBtn">
        <i class="bi bi-share"></i> Share Profile
      </button>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
      <div class="stat-item-p"><div class="num">{{ $connectionCount }}</div><div class="lbl">Connections</div></div>
      <div class="stat-item-p"><div class="num">{{ $followerCount }}</div><div class="lbl">Followers</div></div>
      <div class="stat-item-p"><div class="num">{{ $followingCount }}</div><div class="lbl">Following</div></div>
      <div class="stat-item-p"><div class="num">{{ $user->certificates->count() }}</div><div class="lbl">Certificates</div></div>
      <div class="stat-item-p"><div class="num">{{ $user->testAttempts->count() }}</div><div class="lbl">Tests Taken</div></div>
    </div>

    <div class="row g-3">
      <div class="col-lg-8">

        {{-- About --}}
        @if($profile->bio)
          <div class="section-card">
            <div class="section-title"><i class="bi bi-person-lines-fill"></i> About</div>
            <p style="color:#475569;font-size:.95rem;line-height:1.7;margin:0">{{ $profile->bio }}</p>
          </div>
        @endif

        {{-- Experience --}}
        @if($user->experiences->count())
          <div class="section-card">
            <div class="section-title"><i class="bi bi-briefcase-fill"></i> Experience</div>
            <div class="timeline">
              @foreach($user->experiences as $exp)
                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
                    <div>
                      <div class="timeline-title">{{ $exp->position }}</div>
                      <div class="timeline-sub">{{ $exp->company }}</div>
                      <div class="timeline-date">
                        {{ $exp->duration }} &bull; {{ $exp->length }}
                        @if($exp->employment_type) &bull; {{ $exp->employment_type }} @endif
                        @if($exp->location) &bull; {{ $exp->location }} @endif
                      </div>
                      @if($exp->description)<div class="timeline-desc">{{ $exp->description }}</div>@endif
                    </div>
                    @if($exp->is_current)
                      <span style="background:#d1fae5;color:#065f46;padding:3px 10px;border-radius:50px;font-size:.7rem;font-weight:700;flex-shrink:0">Current</span>
                    @endif
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Education --}}
        @if($user->educations->count())
          <div class="section-card">
            <div class="section-title"><i class="bi bi-mortarboard-fill"></i> Education</div>
            <div class="timeline">
              @foreach($user->educations as $edu)
                <div class="timeline-item">
                  <div class="timeline-dot" style="background:#7c3aed;box-shadow:0 0 0 2px #ddd6fe"></div>
                  <div class="timeline-title">{{ $edu->institution }}</div>
                  @if($edu->degree || $edu->field_of_study)
                    <div class="timeline-sub">{{ $edu->degree }}{{ $edu->degree && $edu->field_of_study ? ' — ' : '' }}{{ $edu->field_of_study }}</div>
                  @endif
                  <div class="timeline-date">{{ $edu->duration }}</div>
                  @if($edu->description)<div class="timeline-desc">{{ $edu->description }}</div>@endif
                </div>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Certificates --}}
        @if($user->certificates->count())
          <div class="section-card">
            <div class="section-title"><i class="bi bi-award-fill"></i> Certificates Earned</div>
            <div class="cert-mini-grid">
              @foreach($user->certificates as $cert)
                <div class="cert-mini-card">
                  <div class="c-title">{{ $cert->test->title }}</div>
                  <div class="c-score">Score: {{ $cert->attempt->percentage }}%</div>
                  <div class="c-date">{{ $cert->issued_at->format('d M Y') }}</div>
                  <a href="{{ route('certificates.show', $cert->certificate_no) }}" target="_blank" class="c-view">
                    <i class="bi bi-eye"></i> View
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Test Performance --}}
        @if($user->testAttempts->count())
          <div class="section-card">
            <div class="section-title"><i class="bi bi-graph-up-arrow"></i> Test Performance</div>
            <div class="test-stat-row">
              <div class="test-stat-box">
                <div class="n">{{ $user->testAttempts->count() }}</div>
                <div class="l">Taken</div>
              </div>
              <div class="test-stat-box">
                <div class="n">{{ $user->testAttempts->where('passed', true)->count() }}</div>
                <div class="l">Passed</div>
              </div>
              <div class="test-stat-box">
                <div class="n">{{ $user->testAttempts->count() > 0 ? round($user->testAttempts->avg('percentage'), 1) : 0 }}%</div>
                <div class="l">Avg Score</div>
              </div>
              <div class="test-stat-box">
                <div class="n">{{ $user->certificates->count() }}</div>
                <div class="l">Certs</div>
              </div>
            </div>
          </div>
        @endif

      </div>

      {{-- Sidebar --}}
      <div class="col-lg-4">

        {{-- Skills --}}
        @if($user->skills->count())
          <div class="section-card">
            <div class="section-title"><i class="bi bi-stars"></i> Skills</div>
            <div class="skill-chips">
              @foreach($user->skills as $skill)
                <span class="skill-chip {{ $skill->proficiency }}">
                  {{ $skill->skill_name }}
                </span>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Social links --}}
        @if($profile->linkedin_url || $profile->github_url || $profile->twitter_url || $profile->website)
          <div class="section-card">
            <div class="section-title"><i class="bi bi-link-45deg"></i> Links</div>
            <div class="social-links">
              @if($profile->linkedin_url)
                <a href="{{ $profile->linkedin_url }}" target="_blank" class="social-link li"><i class="bi bi-linkedin"></i> LinkedIn</a>
              @endif
              @if($profile->github_url)
                <a href="{{ $profile->github_url }}" target="_blank" class="social-link gh"><i class="bi bi-github"></i> GitHub</a>
              @endif
              @if($profile->twitter_url)
                <a href="{{ $profile->twitter_url }}" target="_blank" class="social-link tw"><i class="bi bi-twitter-x"></i> Twitter</a>
              @endif
              @if($profile->website)
                <a href="{{ $profile->website }}" target="_blank" class="social-link web"><i class="bi bi-globe2"></i> Website</a>
              @endif
            </div>
          </div>
        @endif

        {{-- Profile URL card --}}
        <div class="section-card" style="background:linear-gradient(135deg,#eff6ff,#f8faff)">
          <div class="section-title"><i class="bi bi-share-fill"></i> Public Profile</div>
          <div style="background:#fff;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:.78rem;font-family:monospace;color:#2563eb;word-break:break-all;margin-bottom:12px">
            {{ route('profile.public', $profile->username) }}
          </div>
          <button class="btn-connect outline w-100 justify-content-center" onclick="copyProfileLink()" id="shareBtnSide">
            <i class="bi bi-clipboard"></i> Copy Link
          </button>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function copyProfileLink() {
  navigator.clipboard.writeText('{{ route("profile.public", $profile->username) }}').then(() => {
    ['shareBtn','shareBtnSide'].forEach(id => {
      const el = document.getElementById(id);
      if(el){ const t=el.innerHTML; el.innerHTML='<i class="bi bi-check-lg"></i> Copied!'; setTimeout(()=>el.innerHTML=t,2000); }
    });
  });
}
</script>
@endsection
