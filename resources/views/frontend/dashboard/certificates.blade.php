@extends('frontend.layouts.app')
@section('title', 'My Certificates')

@section('styles')
<style>
.dash-page { background: #f4f7ff; min-height: 100vh; }
.dash-hero {
  background: linear-gradient(135deg, #0f172a 0%, #1e40af 60%, #3b82f6 100%);
  padding: 110px 0 60px;
  position: relative;
  overflow: hidden;
}
.dash-hero::before { content:''; position:absolute; inset:0; background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }

.cert-card {
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  border: 1.5px solid #e8edf5;
  box-shadow: 0 4px 20px rgba(0,0,0,.06);
  transition: transform .2s, box-shadow .2s;
  height: 100%;
}
.cert-card:hover { transform: translateY(-5px); box-shadow: 0 16px 40px rgba(251,191,36,.14); border-color: #fde68a; }
.cert-card-header {
  background: linear-gradient(135deg, #1e3a5f, #1e40af);
  padding: 28px 24px;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.cert-card-header::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M20 20v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.cert-card-trophy { font-size: 2.8rem; margin-bottom: 8px; position: relative; }
.cert-card-test { font-size: .95rem; font-weight: 700; color: #fff; line-height: 1.35; position: relative; }
.cert-card-cat { font-size: .75rem; color: rgba(255,255,255,.55); margin-top: 4px; position: relative; }
.cert-card-body { padding: 20px 22px; }
.cert-info-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: .83rem; }
.cert-info-row:last-child { border-bottom: none; }
.cert-info-lbl { color: #94a3b8; font-weight: 600; text-transform: uppercase; font-size: .7rem; letter-spacing: .3px; }
.cert-info-val { font-weight: 700; color: #0f172a; }
.cert-no-code { font-family: monospace; font-size: .78rem; background: #f8faff; padding: 3px 8px; border-radius: 6px; border: 1px solid #e2e8f0; color: #2563eb; }
.cert-view-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: 100%;
  padding: 11px;
  border-radius: 10px;
  background: linear-gradient(135deg, #f59e0b, #fbbf24);
  color: #fff;
  font-weight: 700;
  font-size: .9rem;
  text-decoration: none;
  margin-top: 16px;
  transition: opacity .2s, transform .15s;
}
.cert-view-btn:hover { opacity: .9; transform: translateY(-1px); color: #fff; }

.score-pill { padding: 3px 10px; border-radius: 50px; font-size: .75rem; font-weight: 700; }
.score-pill.high { background: #d1fae5; color: #065f46; }
.score-pill.mid { background: #fef3c7; color: #92400e; }
.score-pill.low { background: #fee2e2; color: #991b1b; }

.empty-state { text-align: center; padding: 80px 20px; }
.empty-icon { font-size: 4rem; color: #cbd5e1; margin-bottom: 20px; }

@media (max-width: 576px) { .dash-hero { padding: 90px 0 50px; } }
</style>
@endsection

@section('content')
<div class="dash-page">

<section class="dash-hero text-white">
  <div class="container position-relative">
    <nav aria-label="breadcrumb" class="mb-2">
      <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider-color:rgba(255,255,255,.3)">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color:rgba(255,255,255,.65);text-decoration:none">Dashboard</a></li>
        <li class="breadcrumb-item active text-white">Certificates</li>
      </ol>
    </nav>
    <h1 style="font-weight:800;font-size:clamp(1.6rem,3.5vw,2.4rem);margin-bottom:6px">
      <i class="bi bi-award-fill text-warning me-2"></i>My Certificates
    </h1>
    <p style="opacity:.7;font-size:.95rem;margin:0">
      {{ $certificates->count() }} certificate{{ $certificates->count() != 1 ? 's' : '' }} earned
    </p>
  </div>
</section>

<section class="py-4 py-md-5">
  <div class="container">
    @if($certificates->isEmpty())
      <div class="empty-state">
        <div class="empty-icon">🏆</div>
        <h5 style="font-weight:700;color:#475569">No certificates yet</h5>
        <p style="color:#94a3b8;max-width:360px;margin:8px auto">
          Pass a test with the required score to earn your first certificate. They're shareable and verifiable!
        </p>
        <a href="{{ route('tests.index') }}" style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;padding:11px 24px;border-radius:10px;font-weight:600;text-decoration:none;margin-top:12px">
          <i class="bi bi-lightning-charge-fill"></i> Start a Test
        </a>
      </div>
    @else
      <div class="row g-4">
        @foreach($certificates as $cert)
          @php $pct = $cert->attempt->percentage; @endphp
          <div class="col-sm-6 col-lg-4">
            <div class="cert-card">
              <div class="cert-card-header">
                <div class="cert-card-trophy">🏆</div>
                <div class="cert-card-test">{{ $cert->test->title }}</div>
                <div class="cert-card-cat">{{ $cert->test->category->name ?? '' }}</div>
              </div>
              <div class="cert-card-body">
                <div class="cert-info-row">
                  <span class="cert-info-lbl">Score</span>
                  <span class="score-pill {{ $pct >= 80 ? 'high' : ($pct >= 60 ? 'mid' : 'low') }}">{{ $pct }}%</span>
                </div>
                <div class="cert-info-row">
                  <span class="cert-info-lbl">Issued</span>
                  <span class="cert-info-val">{{ $cert->issued_at->format('d M Y') }}</span>
                </div>
                <div class="cert-info-row">
                  <span class="cert-info-lbl">Certificate No</span>
                  <span class="cert-no-code">{{ $cert->certificate_no }}</span>
                </div>
                <a href="{{ route('certificates.show', $cert->certificate_no) }}" target="_blank" class="cert-view-btn">
                  <i class="bi bi-eye-fill"></i> View Certificate
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>

</div>
@endsection
