@extends('frontend.layouts.app')
@section('title', 'Connections')

@section('styles')
<style>
.conn-page { background:#f4f7ff; min-height:100vh; }
.conn-hero { background:linear-gradient(135deg,#0f172a,#1e40af,#3b82f6); padding:110px 0 55px; position:relative; overflow:hidden; }
.conn-hero::before { content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }

.section-card { background:#fff; border-radius:16px; border:1.5px solid #e8edf5; box-shadow:0 2px 12px rgba(0,0,0,.05); margin-bottom:20px; overflow:hidden; }
.section-card-header { padding:16px 22px; background:#fafbfc; border-bottom:1.5px solid #f1f5f9; font-weight:800; font-size:.95rem; color:#0f172a; display:flex; align-items:center; gap:8px; }
.section-card-header i { color:#2563eb; }

.people-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(230px,1fr)); gap:14px; padding:20px; }
.person-card { background:#f8faff; border:1.5px solid #e8edf5; border-radius:14px; padding:18px; text-align:center; transition:all .2s; }
.person-card:hover { border-color:#bfdbfe; box-shadow:0 6px 18px rgba(37,99,235,.1); transform:translateY(-2px); }
.person-avatar { width:68px; height:68px; border-radius:50%; object-fit:cover; border:3px solid #e2e8f0; margin:0 auto 10px; display:block; }
.person-name { font-weight:700; color:#0f172a; font-size:.9rem; margin-bottom:2px; }
.person-headline { font-size:.75rem; color:#64748b; margin-bottom:12px; min-height:18px; }
.btn-sm-action { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; border-radius:50px; font-size:.78rem; font-weight:700; cursor:pointer; border:1.5px solid transparent; transition:all .15s; text-decoration:none; }
.btn-sm-action.accept { background:#d1fae5; color:#065f46; border-color:#86efac; }
.btn-sm-action.accept:hover { background:#059669; color:#fff; border-color:#059669; }
.btn-sm-action.decline { background:#fee2e2; color:#991b1b; border-color:#fca5a5; }
.btn-sm-action.decline:hover { background:#ef4444; color:#fff; border-color:#ef4444; }
.btn-sm-action.view { background:#eff6ff; color:#1e40af; border-color:#93c5fd; }
.btn-sm-action.view:hover { background:#2563eb; color:#fff; }
.btn-sm-action.remove { background:#f1f5f9; color:#64748b; border-color:#e2e8f0; }
.btn-sm-action.remove:hover { background:#ef4444; color:#fff; border-color:#ef4444; }

.empty-box { text-align:center; padding:48px 24px; }
.empty-box .icon { font-size:2.8rem; color:#cbd5e1; margin-bottom:12px; }
.empty-box p { color:#94a3b8; font-size:.88rem; }

@media(max-width:480px) { .people-grid { grid-template-columns:1fr 1fr; } }
</style>
@endsection

@section('content')
<div class="conn-page">

<section class="conn-hero text-white">
  <div class="container position-relative">
    <h1 style="font-weight:800;font-size:clamp(1.6rem,3.5vw,2.2rem);margin-bottom:4px">Connections & Network</h1>
    <p style="opacity:.7;margin:0">Manage your professional connections and requests.</p>
  </div>
</section>

<section class="py-4 py-md-5">
<div class="container" style="max-width:900px">

  @if(session('success'))
    <div style="background:#d1fae5;border:1.5px solid #86efac;border-radius:10px;padding:12px 18px;margin-bottom:16px;font-weight:600;font-size:.88rem;color:#065f46">
      <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    </div>
  @endif

  {{-- Pending requests --}}
  @if($pending->count())
    <div class="section-card">
      <div class="section-card-header">
        <i class="bi bi-bell-fill text-warning"></i>
        Pending Requests
        <span style="background:#fef3c7;color:#92400e;padding:2px 10px;border-radius:50px;font-size:.72rem;margin-left:4px">{{ $pending->count() }}</span>
      </div>
      <div class="people-grid">
        @foreach($pending as $req)
          @php $person = $req->requester; @endphp
          <div class="person-card">
            <img src="{{ $person->avatar_url }}" class="person-avatar" alt="{{ $person->name }}">
            <div class="person-name">{{ $person->name }}</div>
            <div class="person-headline">{{ $person->profile?->headline ?? '' }}</div>
            <div class="d-flex gap-2 justify-content-center flex-wrap">
              <form action="{{ route('connections.accept', $req) }}" method="POST">
                @csrf <button class="btn-sm-action accept"><i class="bi bi-check-lg"></i> Accept</button>
              </form>
              <form action="{{ route('connections.reject', $req) }}" method="POST">
                @csrf <button class="btn-sm-action decline"><i class="bi bi-x-lg"></i> Decline</button>
              </form>
            </div>
            @if($person->profile?->username)
              <a href="{{ route('profile.public', $person->profile->username) }}" class="btn-sm-action view mt-2">View Profile</a>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  @endif

  {{-- Connections --}}
  <div class="section-card">
    <div class="section-card-header">
      <i class="bi bi-people-fill"></i>
      My Connections
      <span style="background:#eff6ff;color:#1e40af;padding:2px 10px;border-radius:50px;font-size:.72rem;margin-left:4px">{{ $connections->count() }}</span>
    </div>
    @if($connections->isEmpty())
      <div class="empty-box">
        <div class="icon"><i class="bi bi-people"></i></div>
        <p>No connections yet. Visit someone's profile and send a connection request.</p>
        <a href="{{ route('tests.index') }}" style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;padding:10px 20px;border-radius:10px;font-weight:600;text-decoration:none;font-size:.88rem;margin-top:4px">
          <i class="bi bi-lightning-charge-fill"></i> Explore Tests & People
        </a>
      </div>
    @else
      <div class="people-grid">
        @foreach($connections as $conn)
          @php $person = $conn->requester_id === auth()->id() ? $conn->receiver : $conn->requester; @endphp
          <div class="person-card">
            <img src="{{ $person->avatar_url }}" class="person-avatar" alt="{{ $person->name }}">
            <div class="person-name">{{ $person->name }}</div>
            <div class="person-headline">{{ $person->profile?->headline ?? '' }}</div>
            <div class="d-flex gap-2 justify-content-center flex-wrap mt-1">
              @if($person->profile?->username)
                <a href="{{ route('profile.public', $person->profile->username) }}" class="btn-sm-action view"><i class="bi bi-person"></i> Profile</a>
              @endif
              <form action="{{ route('connections.remove', $person) }}" method="POST" onsubmit="return confirm('Remove connection?')">
                @csrf @method('DELETE')
                <button class="btn-sm-action remove"><i class="bi bi-person-x-fill"></i> Remove</button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

</div>
</section>
</div>
@endsection
