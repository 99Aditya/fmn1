@extends('frontend.layouts.app')
@section('title', 'My Profile')

@section('styles')
<style>
.prof-page { background: #f4f7ff; min-height: 100vh; padding-bottom: 60px; }

/* Cover */
.cover-wrap { position: relative; height: 220px; background: linear-gradient(135deg,#0f172a,#1e40af,#3b82f6); overflow: hidden; }
.cover-wrap::after { content:''; position:absolute; inset:0; background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }

/* Avatar area */
.avatar-area { display:flex; align-items:flex-end; gap:20px; flex-wrap:wrap; margin-top:-64px; padding:0 0 16px; }
.avatar-ring { width:128px; height:128px; border-radius:50%; border:4px solid #fff; box-shadow:0 8px 24px rgba(0,0,0,.18); overflow:hidden; flex-shrink:0; background:#e2e8f0; position:relative; }
.avatar-ring img { width:100%; height:100%; object-fit:cover; }
.avatar-edit-overlay { position:absolute; inset:0; background:rgba(0,0,0,.45); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity .2s; border-radius:50%; }
.avatar-ring:hover .avatar-edit-overlay { opacity:1; }

/* Completeness bar */
.completeness-bar { background:#fff; border-radius:12px; padding:14px 18px; border:1.5px solid #e8edf5; margin-bottom:20px; }
.completeness-bar .label { font-size:.78rem; font-weight:700; color:#64748b; margin-bottom:6px; display:flex; justify-content:space-between; }
.completeness-bar .bar { height:6px; background:#f1f5f9; border-radius:99px; overflow:hidden; }
.completeness-bar .fill { height:100%; background:linear-gradient(90deg,#2563eb,#34d399); border-radius:99px; transition:width .6s; }

/* Section cards */
.section-card { background:#fff; border-radius:16px; border:1.5px solid #e8edf5; padding:22px; margin-bottom:16px; box-shadow:0 2px 12px rgba(0,0,0,.05); }
.section-head { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; }
.section-title { font-size:.95rem; font-weight:800; color:#0f172a; display:flex; align-items:center; gap:7px; margin:0; }
.section-title i { color:#2563eb; }
.edit-link { display:inline-flex; align-items:center; gap:5px; font-size:.78rem; font-weight:600; color:#2563eb; text-decoration:none; padding:5px 12px; border:1.5px solid #bfdbfe; border-radius:50px; transition:all .15s; }
.edit-link:hover { background:#eff6ff; }

/* Stats */
.stats-row { display:flex; gap:20px; flex-wrap:wrap; margin:16px 0; padding:16px 0; border-top:1.5px solid #f1f5f9; border-bottom:1.5px solid #f1f5f9; }
.stat-p .num { font-size:1.3rem; font-weight:800; color:#0f172a; }
.stat-p .lbl { font-size:.7rem; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; }

/* Skill chips */
.skill-chips { display:flex; flex-wrap:wrap; gap:8px; }
.skill-chip { display:inline-flex; align-items:center; gap:5px; padding:5px 13px; border-radius:50px; font-size:.78rem; font-weight:600; border:1.5px solid; }
.skill-chip.beginner { background:#f0fdf4; color:#166534; border-color:#86efac; }
.skill-chip.intermediate { background:#eff6ff; color:#1e40af; border-color:#93c5fd; }
.skill-chip.advanced { background:#f5f3ff; color:#5b21b6; border-color:#c4b5fd; }
.skill-chip.expert { background:#fff7ed; color:#9a3412; border-color:#fdba74; }

/* Timeline */
.timeline { position:relative; padding-left:26px; }
.timeline::before { content:''; position:absolute; left:8px; top:4px; bottom:4px; width:2px; background:#e2e8f0; border-radius:2px; }
.tl-item { position:relative; margin-bottom:20px; }
.tl-item:last-child { margin-bottom:0; }
.tl-dot { position:absolute; left:-26px; top:5px; width:16px; height:16px; border-radius:50%; border:3px solid #fff; box-shadow:0 0 0 2px; }
.tl-dot.blue { background:#2563eb; box-shadow:0 0 0 2px #bfdbfe; }
.tl-dot.purple { background:#7c3aed; box-shadow:0 0 0 2px #ddd6fe; }
.tl-company { font-weight:700; color:#0f172a; font-size:.93rem; }
.tl-role { font-size:.83rem; color:#2563eb; font-weight:600; }
.tl-date { font-size:.73rem; color:#94a3b8; margin-top:1px; }
.tl-desc { font-size:.82rem; color:#64748b; margin-top:5px; line-height:1.55; }

/* Cert cards */
.cert-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(195px,1fr)); gap:12px; }
.cert-card { background:linear-gradient(135deg,#1e3a5f,#1e40af); border-radius:12px; padding:16px; color:#fff; position:relative; overflow:hidden; }
.cert-card::before { content:'🏆'; position:absolute; right:-4px; top:-4px; font-size:2.8rem; opacity:.12; pointer-events:none; }
.cert-card .ct { font-size:.82rem; font-weight:700; line-height:1.3; }
.cert-card .cs { font-size:.72rem; opacity:.7; margin-top:3px; }
.cert-card .cv { display:inline-flex; align-items:center; gap:4px; margin-top:10px; background:rgba(255,255,255,.15); border-radius:50px; padding:4px 12px; font-size:.72rem; font-weight:700; text-decoration:none; color:#fff; }
.cert-card .cv:hover { background:rgba(255,255,255,.28); }

/* Share bar */
.share-bar { background:linear-gradient(135deg,#eff6ff,#f0f7ff); border:1.5px solid #bfdbfe; border-radius:14px; padding:16px 20px; display:flex; align-items:center; gap:14px; flex-wrap:wrap; margin-bottom:16px; }
.share-url { font-size:.8rem; font-family:monospace; color:#2563eb; background:#fff; border:1.5px solid #e2e8f0; border-radius:8px; padding:7px 12px; flex:1; min-width:0; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
.copy-btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:8px; border:1.5px solid #bfdbfe; background:#fff; color:#2563eb; font-weight:700; font-size:.8rem; cursor:pointer; white-space:nowrap; transition:all .15s; }
.copy-btn:hover { background:#2563eb; color:#fff; border-color:#2563eb; }

/* Empty state */
.empty-section { text-align:center; padding:24px 16px; color:#94a3b8; font-size:.85rem; }
.empty-section i { font-size:1.8rem; display:block; margin-bottom:6px; color:#cbd5e1; }

/* Action buttons */
.action-btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:50px; font-weight:700; font-size:.85rem; text-decoration:none; transition:all .15s; }
.action-btn.primary { background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff; }
.action-btn.primary:hover { opacity:.9; box-shadow:0 4px 14px rgba(37,99,235,.3); color:#fff; }
.action-btn.outline { border:1.5px solid #e2e8f0; background:#fff; color:#475569; }
.action-btn.outline:hover { border-color:#2563eb; color:#2563eb; background:#eff6ff; }

@media(max-width:576px) {
  .cover-wrap { height:160px; }
  .avatar-ring { width:96px; height:96px; }
  .stats-row { gap:14px; }
  .cert-grid { grid-template-columns:1fr 1fr; }
  .share-bar { flex-direction:column; align-items:stretch; }
}
</style>
@endsection

@section('content')
<div class="prof-page">

  {{-- Cover --}}
  <div class="cover-wrap"></div>

  <div class="container" style="max-width:920px">

    {{-- Avatar + name --}}
    <div class="avatar-area">
      <a href="{{ route('profile.edit') }}?tab=avatar" class="avatar-ring" title="Change photo">
        <img src="{{ $user->profile->avatar_url }}" alt="{{ $user->name }}">
        <div class="avatar-edit-overlay">
          <i class="bi bi-camera-fill text-white fs-4"></i>
        </div>
      </a>
      <div class="flex-grow-1 pb-3">
        <h1 style="font-size:1.6rem;font-weight:800;color:#0f172a;margin:0">{{ $user->name }}</h1>
        @if($user->profile->headline)
          <div style="font-size:.95rem;color:#64748b;margin-top:2px">{{ $user->profile->headline }}</div>
        @else
          <a href="{{ route('profile.edit') }}" style="font-size:.85rem;color:#2563eb">Add a headline</a>
        @endif
        @if($user->profile->location)
          <div style="font-size:.8rem;color:#94a3b8;margin-top:3px"><i class="bi bi-geo-alt me-1"></i>{{ $user->profile->location }}</div>
        @endif
      </div>
      <div class="pb-3 d-flex gap-2 flex-wrap">
        <a href="{{ route('profile.edit') }}" class="action-btn primary"><i class="bi bi-pencil-fill"></i> Edit Profile</a>
        <a href="{{ route('profile.public', $user->profile->username) }}" target="_blank" class="action-btn outline"><i class="bi bi-eye"></i> View Public</a>
        <a href="{{ route('connections.index') }}" class="action-btn outline"><i class="bi bi-people-fill"></i> Connections</a>
      </div>
    </div>

    {{-- Public profile share bar --}}
    <div class="share-bar">
      <i class="bi bi-share-fill text-primary fs-5"></i>
      <div style="flex:1;min-width:0">
        <div style="font-size:.78rem;font-weight:700;color:#1e40af;margin-bottom:4px">Your Public Profile Link</div>
        <div class="share-url">{{ route('profile.public', $user->profile->username) }}</div>
      </div>
      <button class="copy-btn" onclick="copyLink(this)"><i class="bi bi-clipboard"></i> Copy</button>
    </div>

    @php
      $filled = 0;
      if($user->name) $filled++;
      if($user->profile->headline) $filled++;
      if($user->profile->bio) $filled++;
      if($user->profile->avatar) $filled++;
      if($user->profile->location) $filled++;
      if($user->skills->count()) $filled++;
      if($user->experiences->count()) $filled++;
      if($user->educations->count()) $filled++;
      $pct = round($filled / 8 * 100);
    @endphp

    {{-- Profile completeness --}}
    <div class="completeness-bar">
      <div class="label">
        <span>Profile Completeness</span>
        <span style="color:{{ $pct >= 80 ? '#059669' : ($pct >= 50 ? '#d97706' : '#ef4444') }}">{{ $pct }}%</span>
      </div>
      <div class="bar"><div class="fill" style="width:{{ $pct }}%"></div></div>
      @if($pct < 100)
        <div style="font-size:.72rem;color:#94a3b8;margin-top:6px">
          @if(!$user->profile->avatar) <span class="me-3"><i class="bi bi-circle me-1"></i>Add photo</span> @endif
          @if(!$user->profile->headline) <span class="me-3"><i class="bi bi-circle me-1"></i>Add headline</span> @endif
          @if(!$user->profile->bio) <span class="me-3"><i class="bi bi-circle me-1"></i>Add bio</span> @endif
          @if(!$user->skills->count()) <span class="me-3"><i class="bi bi-circle me-1"></i>Add skills</span> @endif
          @if(!$user->experiences->count()) <span class="me-3"><i class="bi bi-circle me-1"></i>Add experience</span> @endif
          @if(!$user->educations->count()) <span><i class="bi bi-circle me-1"></i>Add education</span> @endif
        </div>
      @endif
    </div>

    {{-- Stats --}}
    <div class="stats-row">
      <div class="stat-p"><div class="num">{{ \App\Models\UserConnection::where(fn($q)=>$q->where('requester_id',$user->id)->orWhere('receiver_id',$user->id))->where('status','accepted')->count() }}</div><div class="lbl">Connections</div></div>
      <div class="stat-p"><div class="num">{{ $user->followers()->count() }}</div><div class="lbl">Followers</div></div>
      <div class="stat-p"><div class="num">{{ $user->following()->count() }}</div><div class="lbl">Following</div></div>
      <div class="stat-p"><div class="num">{{ $user->certificates->count() }}</div><div class="lbl">Certificates</div></div>
      <div class="stat-p"><div class="num">{{ $user->testAttempts->count() }}</div><div class="lbl">Tests Taken</div></div>
      <div class="stat-p"><div class="num">{{ $user->testAttempts->where('passed',true)->count() }}</div><div class="lbl">Tests Passed</div></div>
    </div>

    <div class="row g-3">
      <div class="col-lg-8">

        {{-- About --}}
        <div class="section-card">
          <div class="section-head">
            <h5 class="section-title"><i class="bi bi-person-lines-fill"></i> About</h5>
            <a href="{{ route('profile.edit') }}" class="edit-link"><i class="bi bi-pencil"></i> Edit</a>
          </div>
          @if($user->profile->bio)
            <p style="color:#475569;font-size:.93rem;line-height:1.7;margin:0">{{ $user->profile->bio }}</p>
          @else
            <div class="empty-section"><i class="bi bi-chat-left-text"></i>No bio yet — <a href="{{ route('profile.edit') }}">add one</a></div>
          @endif
        </div>

        {{-- Experience --}}
        <div class="section-card">
          <div class="section-head">
            <h5 class="section-title"><i class="bi bi-briefcase-fill"></i> Experience</h5>
            <a href="{{ route('profile.edit') }}?tab=experience" class="edit-link"><i class="bi bi-plus-lg"></i> Add</a>
          </div>
          @if($user->experiences->count())
            <div class="timeline">
              @foreach($user->experiences as $exp)
                <div class="tl-item">
                  <div class="tl-dot blue"></div>
                  <div class="d-flex justify-content-between align-items-start flex-wrap gap-1">
                    <div>
                      <div class="tl-company">{{ $exp->position }}</div>
                      <div class="tl-role">{{ $exp->company }}@if($exp->employment_type) &bull; {{ $exp->employment_type }}@endif</div>
                      <div class="tl-date">{{ $exp->duration }} &bull; {{ $exp->length }}@if($exp->location) &bull; {{ $exp->location }}@endif</div>
                      @if($exp->description)<div class="tl-desc">{{ $exp->description }}</div>@endif
                    </div>
                    @if($exp->is_current)<span style="background:#d1fae5;color:#065f46;padding:2px 9px;border-radius:50px;font-size:.68rem;font-weight:700;flex-shrink:0">Current</span>@endif
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="empty-section"><i class="bi bi-briefcase"></i>No experience added yet — <a href="{{ route('profile.edit') }}?tab=experience">add your work history</a></div>
          @endif
        </div>

        {{-- Education --}}
        <div class="section-card">
          <div class="section-head">
            <h5 class="section-title"><i class="bi bi-mortarboard-fill"></i> Education</h5>
            <a href="{{ route('profile.edit') }}?tab=education" class="edit-link"><i class="bi bi-plus-lg"></i> Add</a>
          </div>
          @if($user->educations->count())
            <div class="timeline">
              @foreach($user->educations as $edu)
                <div class="tl-item">
                  <div class="tl-dot purple"></div>
                  <div class="tl-company">{{ $edu->institution }}</div>
                  @if($edu->degree || $edu->field_of_study)
                    <div class="tl-role">{{ $edu->degree }}{{ $edu->degree && $edu->field_of_study ? ' — ' : '' }}{{ $edu->field_of_study }}</div>
                  @endif
                  <div class="tl-date">{{ $edu->duration }}</div>
                  @if($edu->description)<div class="tl-desc">{{ $edu->description }}</div>@endif
                </div>
              @endforeach
            </div>
          @else
            <div class="empty-section"><i class="bi bi-mortarboard"></i>No education added yet — <a href="{{ route('profile.edit') }}?tab=education">add your qualifications</a></div>
          @endif
        </div>

        {{-- Certificates --}}
        <div class="section-card">
          <div class="section-head">
            <h5 class="section-title"><i class="bi bi-award-fill"></i> Certificates</h5>
            <a href="{{ route('tests.index') }}" class="edit-link"><i class="bi bi-plus-lg"></i> Earn more</a>
          </div>
          @if($user->certificates->count())
            <div class="cert-grid">
              @foreach($user->certificates as $cert)
                <div class="cert-card">
                  <div class="ct">{{ $cert->test->title }}</div>
                  <div class="cs">{{ $cert->attempt->percentage }}% &bull; {{ $cert->issued_at->format('d M Y') }}</div>
                  <a href="{{ route('certificates.show', $cert->certificate_no) }}" target="_blank" class="cv">
                    <i class="bi bi-eye"></i> View
                  </a>
                </div>
              @endforeach
            </div>
          @else
            <div class="empty-section"><i class="bi bi-award"></i>No certificates yet — <a href="{{ route('tests.index') }}">take a test</a> to earn one</div>
          @endif
        </div>

      </div>

      {{-- Sidebar --}}
      <div class="col-lg-4">

        {{-- Skills --}}
        <div class="section-card">
          <div class="section-head">
            <h5 class="section-title"><i class="bi bi-stars"></i> Skills</h5>
            <a href="{{ route('profile.edit') }}?tab=skills" class="edit-link"><i class="bi bi-plus-lg"></i> Add</a>
          </div>
          @if($user->skills->count())
            <div class="skill-chips">
              @foreach($user->skills as $skill)
                <span class="skill-chip {{ $skill->proficiency }}">{{ $skill->skill_name }}</span>
              @endforeach
            </div>
          @else
            <div class="empty-section"><i class="bi bi-tag"></i>No skills added — <a href="{{ route('profile.edit') }}?tab=skills">add skills</a></div>
          @endif
        </div>

        {{-- Contact / Links --}}
        <div class="section-card">
          <div class="section-head">
            <h5 class="section-title"><i class="bi bi-link-45deg"></i> Links</h5>
            <a href="{{ route('profile.edit') }}" class="edit-link"><i class="bi bi-pencil"></i> Edit</a>
          </div>
          @php $hasLinks = $user->profile->linkedin_url || $user->profile->github_url || $user->profile->twitter_url || $user->profile->website; @endphp
          @if($hasLinks)
            <div class="d-flex flex-column gap-2">
              @if($user->profile->linkedin_url)
                <a href="{{ $user->profile->linkedin_url }}" target="_blank" style="display:flex;align-items:center;gap:8px;font-size:.85rem;color:#1e40af;text-decoration:none">
                  <span style="width:28px;height:28px;background:#eff6ff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem"><i class="bi bi-linkedin"></i></span> LinkedIn
                </a>
              @endif
              @if($user->profile->github_url)
                <a href="{{ $user->profile->github_url }}" target="_blank" style="display:flex;align-items:center;gap:8px;font-size:.85rem;color:#0f172a;text-decoration:none">
                  <span style="width:28px;height:28px;background:#f8faff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem"><i class="bi bi-github"></i></span> GitHub
                </a>
              @endif
              @if($user->profile->twitter_url)
                <a href="{{ $user->profile->twitter_url }}" target="_blank" style="display:flex;align-items:center;gap:8px;font-size:.85rem;color:#0369a1;text-decoration:none">
                  <span style="width:28px;height:28px;background:#e0f2fe;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem"><i class="bi bi-twitter-x"></i></span> Twitter / X
                </a>
              @endif
              @if($user->profile->website)
                <a href="{{ $user->profile->website }}" target="_blank" style="display:flex;align-items:center;gap:8px;font-size:.85rem;color:#166534;text-decoration:none">
                  <span style="width:28px;height:28px;background:#f0fdf4;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem"><i class="bi bi-globe2"></i></span> Website
                </a>
              @endif
            </div>
          @else
            <div class="empty-section" style="padding:12px 0"><i class="bi bi-link"></i>No links added — <a href="{{ route('profile.edit') }}">add them</a></div>
          @endif
        </div>

        {{-- Privacy status --}}
        <div class="section-card" style="background:{{ $user->profile->is_public ? '#f0fdf4' : '#fef2f2' }};border-color:{{ $user->profile->is_public ? '#86efac' : '#fca5a5' }}">
          <div style="display:flex;align-items:center;gap:10px">
            <i class="bi bi-{{ $user->profile->is_public ? 'globe2 text-success' : 'lock-fill text-danger' }} fs-5"></i>
            <div>
              <div style="font-weight:700;font-size:.88rem;color:#0f172a">Profile is {{ $user->profile->is_public ? 'Public' : 'Private' }}</div>
              <div style="font-size:.75rem;color:#64748b">{{ $user->profile->is_public ? 'Anyone with the link can view it' : 'Only you can see your profile' }}</div>
            </div>
          </div>
          <a href="{{ route('profile.edit') }}" style="display:block;margin-top:10px;font-size:.75rem;color:#2563eb;font-weight:600;text-decoration:none">Change visibility →</a>
        </div>

        {{-- Quick test stats --}}
        @if($user->testAttempts->count())
          <div class="section-card">
            <h5 class="section-title mb-3"><i class="bi bi-graph-up-arrow"></i> Test Stats</h5>
            <div class="row g-2 text-center">
              <div class="col-6">
                <div style="background:#f8faff;border-radius:10px;padding:12px">
                  <div style="font-size:1.4rem;font-weight:800;color:#2563eb">{{ $user->testAttempts->count() }}</div>
                  <div style="font-size:.7rem;color:#94a3b8;text-transform:uppercase">Taken</div>
                </div>
              </div>
              <div class="col-6">
                <div style="background:#f0fdf4;border-radius:10px;padding:12px">
                  <div style="font-size:1.4rem;font-weight:800;color:#059669">{{ $user->testAttempts->where('passed',true)->count() }}</div>
                  <div style="font-size:.7rem;color:#94a3b8;text-transform:uppercase">Passed</div>
                </div>
              </div>
              <div class="col-12">
                <div style="background:#fffbeb;border-radius:10px;padding:12px">
                  <div style="font-size:1.3rem;font-weight:800;color:#d97706">{{ number_format($user->testAttempts->avg('percentage'),1) }}%</div>
                  <div style="font-size:.7rem;color:#94a3b8;text-transform:uppercase">Avg Score</div>
                </div>
              </div>
            </div>
            <a href="{{ route('dashboard') }}" style="display:block;margin-top:12px;text-align:center;font-size:.8rem;color:#2563eb;font-weight:600;text-decoration:none">View full history →</a>
          </div>
        @endif

      </div>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
function copyLink(btn) {
  navigator.clipboard.writeText('{{ route("profile.public", $user->profile->username) }}').then(() => {
    const t = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check-lg"></i> Copied!';
    btn.style.background = '#2563eb';
    btn.style.color = '#fff';
    setTimeout(() => { btn.innerHTML = t; btn.style.background = ''; btn.style.color = ''; }, 2200);
  });
}
</script>
@endsection
