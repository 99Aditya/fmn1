@extends('frontend.layouts.app')
@section('title', 'My Dashboard')

@section('styles')
<style>
.dash-page { background: #f4f7ff; min-height: 100vh; }
.dash-hero {
  background: linear-gradient(135deg, #0f172a 0%, #1e40af 60%, #3b82f6 100%);
  padding: 110px 0 60px;
  position: relative;
  overflow: hidden;
}
.dash-hero::before {
  content:'';
  position:absolute;
  inset:0;
  background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

/* Stats row */
.stat-cards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
.stat-card {
  background: #fff;
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 4px 20px rgba(0,0,0,.06);
  border: 1.5px solid #e8edf5;
  display: flex;
  align-items: center;
  gap: 16px;
  transition: transform .2s, box-shadow .2s;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,.1); }
.stat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
.stat-num { font-size: 1.7rem; font-weight: 800; color: #0f172a; line-height: 1; }
.stat-lbl { font-size: .75rem; color: #94a3b8; margin-top: 2px; text-transform: uppercase; letter-spacing: .3px; }

/* Cert cards */
.cert-mini-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 14px; }
.cert-mini {
  background: #fff;
  border: 1.5px solid #e8edf5;
  border-radius: 14px;
  padding: 16px 18px;
  display: flex;
  align-items: center;
  gap: 14px;
  transition: all .2s;
}
.cert-mini:hover { border-color: #fde68a; box-shadow: 0 8px 20px rgba(251,191,36,.1); transform: translateY(-2px); }
.cert-mini-icon { width: 42px; height: 42px; background: #fffbeb; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
.cert-mini-title { font-size: .88rem; font-weight: 700; color: #0f172a; line-height: 1.3; }
.cert-mini-meta { font-size: .72rem; color: #94a3b8; margin-top: 2px; }
.cert-mini-code { font-size: .7rem; font-family: monospace; color: #2563eb; }
.cert-mini-btn { margin-left: auto; flex-shrink: 0; width: 32px; height: 32px; background: #eff6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #2563eb; transition: all .15s; }
.cert-mini-btn:hover { background: #2563eb; color: #fff; }

/* Section card */
.section-card {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(0,0,0,.06);
  border: 1.5px solid #e8edf5;
  overflow: hidden;
  margin-bottom: 24px;
}
.section-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 24px;
  border-bottom: 1.5px solid #f1f5f9;
  background: #fafbfc;
}
.section-card-header h5 { font-weight: 800; color: #0f172a; margin: 0; font-size: 1rem; }
.section-card-body { padding: 0; }

/* Attempts table */
.dash-table { width: 100%; border-collapse: collapse; }
.dash-table thead th {
  padding: 12px 20px;
  font-size: .72rem;
  text-transform: uppercase;
  letter-spacing: .5px;
  color: #94a3b8;
  font-weight: 700;
  background: #f8faff;
  border-bottom: 1.5px solid #e8edf5;
  white-space: nowrap;
}
.dash-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background .12s; }
.dash-table tbody tr:last-child { border-bottom: none; }
.dash-table tbody tr:hover { background: #f8faff; }
.dash-table tbody td { padding: 14px 20px; font-size: .88rem; vertical-align: middle; }
.test-name-cell { font-weight: 600; color: #0f172a; }
.cat-chip { background: #f1f5f9; color: #475569; padding: 3px 10px; border-radius: 50px; font-size: .72rem; font-weight: 600; }
.score-bar-wrap { display: flex; align-items: center; gap: 8px; }
.score-bar { width: 60px; height: 5px; background: #f1f5f9; border-radius: 99px; overflow: hidden; flex-shrink: 0; }
.score-bar-fill { height: 100%; border-radius: 99px; }
.pass-chip { padding: 3px 10px; border-radius: 50px; font-size: .72rem; font-weight: 700; }
.pass-chip.pass { background: #d1fae5; color: #065f46; }
.pass-chip.fail { background: #fee2e2; color: #991b1b; }
.review-link { font-size: .8rem; font-weight: 600; color: #2563eb; text-decoration: none; }
.review-link:hover { text-decoration: underline; }

.empty-state { text-align: center; padding: 60px 20px; }
.empty-state .icon { font-size: 3rem; color: #cbd5e1; margin-bottom: 14px; }
.empty-state h6 { color: #475569; font-weight: 700; margin-bottom: 6px; }
.empty-state p { color: #94a3b8; font-size: .88rem; }

.view-all-link {
  font-size: .82rem;
  font-weight: 600;
  color: #2563eb;
  text-decoration: none;
  padding: 5px 12px;
  border-radius: 8px;
  border: 1.5px solid #bfdbfe;
  transition: all .15s;
}
.view-all-link:hover { background: #eff6ff; }

@media (max-width: 768px) {
  .stat-cards { grid-template-columns: repeat(2, 1fr); }
  .dash-hero { padding: 90px 0 50px; }
}
@media (max-width: 480px) {
  .stat-cards { grid-template-columns: 1fr 1fr; gap: 10px; }
  .stat-card { padding: 14px; gap: 10px; }
  .dash-table thead { display: none; }
  .dash-table tbody tr { display: block; padding: 12px 16px; border-bottom: 1.5px solid #f1f5f9; }
  .dash-table tbody td { display: flex; justify-content: space-between; padding: 4px 0; font-size: .82rem; }
  .dash-table tbody td::before { content: attr(data-label); font-weight: 600; color: #94a3b8; font-size: .72rem; text-transform: uppercase; }
}
</style>
@endsection

@section('content')
<div class="dash-page">

{{-- Hero --}}
<section class="dash-hero text-white">
  <div class="container position-relative">
    <div style="font-size:.8rem;opacity:.55;text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px">
      <i class="bi bi-speedometer2 me-1"></i> Dashboard
    </div>
    <h1 style="font-weight:800;font-size:clamp(1.6rem,3.5vw,2.4rem);margin-bottom:6px">
      Welcome back, {{ auth()->user()->name }}!
    </h1>
    <p style="opacity:.7;font-size:.95rem;margin:0">Track your progress, review your tests, and download certificates.</p>
  </div>
</section>

{{-- Body --}}
<section class="py-4 py-md-5">
  <div class="container">

    {{-- Stats row --}}
    <div class="stat-cards">
      <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff"><i class="bi bi-clipboard-check-fill" style="color:#2563eb"></i></div>
        <div>
          <div class="stat-num">{{ $attempts->count() }}</div>
          <div class="stat-lbl">Tests Taken</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:#d1fae5"><i class="bi bi-trophy-fill" style="color:#059669"></i></div>
        <div>
          <div class="stat-num">{{ $attempts->where('passed', true)->count() }}</div>
          <div class="stat-lbl">Passed</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:#fffbeb"><i class="bi bi-award-fill" style="color:#d97706"></i></div>
        <div>
          <div class="stat-num">{{ $certificates->count() }}</div>
          <div class="stat-lbl">Certificates</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon" style="background:#f3e8ff"><i class="bi bi-graph-up-arrow" style="color:#7c3aed"></i></div>
        <div>
          <div class="stat-num">{{ $attempts->count() > 0 ? number_format($attempts->avg('percentage'), 1) : 0 }}%</div>
          <div class="stat-lbl">Avg Score</div>
        </div>
      </div>
    </div>

    {{-- Certificates --}}
    @if($certificates->count())
      <div class="section-card">
        <div class="section-card-header">
          <h5><i class="bi bi-award-fill text-warning me-2"></i>My Certificates</h5>
          @if($certificates->count() > 3)
            <a href="{{ route('dashboard.certificates') }}" class="view-all-link">View all {{ $certificates->count() }}</a>
          @endif
        </div>
        <div class="section-card-body" style="padding:20px 24px">
          <div class="cert-mini-grid">
            @foreach($certificates->take(4) as $cert)
              <div class="cert-mini">
                <div class="cert-mini-icon">🏆</div>
                <div class="flex-grow-1 min-w-0">
                  <div class="cert-mini-title">{{ Str::limit($cert->test->title, 32) }}</div>
                  <div class="cert-mini-meta">{{ $cert->issued_at->format('d M Y') }} &bull; {{ $cert->attempt->percentage }}%</div>
                  <div class="cert-mini-code">{{ $cert->certificate_no }}</div>
                </div>
                <a href="{{ route('certificates.show', $cert->certificate_no) }}" target="_blank" class="cert-mini-btn" title="View certificate">
                  <i class="bi bi-arrow-up-right"></i>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif

    {{-- Test history --}}
    <div class="section-card">
      <div class="section-card-header">
        <h5><i class="bi bi-clock-history me-2 text-primary"></i>Test History</h5>
        @if($attempts->count())
          <span style="font-size:.8rem;color:#94a3b8">{{ $attempts->count() }} attempt{{ $attempts->count() != 1 ? 's' : '' }}</span>
        @endif
      </div>
      <div class="section-card-body">
        @if($attempts->isEmpty())
          <div class="empty-state">
            <div class="icon"><i class="bi bi-clipboard2"></i></div>
            <h6>No tests taken yet</h6>
            <p>Attempt your first MCQ test and see results here.</p>
            <a href="{{ route('tests.index') }}" style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;padding:10px 22px;border-radius:10px;font-weight:600;text-decoration:none;margin-top:8px">
              <i class="bi bi-lightning-charge-fill"></i> Browse Tests
            </a>
          </div>
        @else
          <div class="table-responsive">
            <table class="dash-table">
              <thead>
                <tr>
                  <th>Test</th>
                  <th>Category</th>
                  <th>Score</th>
                  <th>Result</th>
                  <th>Date</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($attempts as $att)
                  <tr>
                    <td data-label="Test">
                      <span class="test-name-cell">{{ $att->test->title }}</span>
                      @if($att->certificate_earned)
                        <i class="bi bi-award-fill text-warning ms-1" title="Certificate earned" style="font-size:.85rem"></i>
                      @endif
                    </td>
                    <td data-label="Category">
                      <span class="cat-chip">{{ $att->test->category->name ?? '—' }}</span>
                    </td>
                    <td data-label="Score">
                      <div class="score-bar-wrap">
                        <div class="score-bar">
                          <div class="score-bar-fill" style="width:{{ $att->percentage }}%;background:{{ $att->passed ? '#10b981' : '#ef4444' }}"></div>
                        </div>
                        <span style="font-weight:600;color:#0f172a;font-size:.85rem">{{ $att->percentage }}%</span>
                        <span style="color:#94a3b8;font-size:.75rem">({{ $att->score }}/{{ $att->test->total_marks }})</span>
                      </div>
                    </td>
                    <td data-label="Result">
                      <span class="pass-chip {{ $att->passed ? 'pass' : 'fail' }}">{{ $att->passed ? 'Passed' : 'Failed' }}</span>
                    </td>
                    <td data-label="Date" style="color:#64748b;font-size:.82rem">
                      {{ $att->completed_at->format('d M Y') }}
                    </td>
                    <td data-label="">
                      <a href="{{ route('tests.attempt.result', [$att->test, $att]) }}" class="review-link">Review →</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    </div>

  </div>
</section>

</div>
@endsection
