@extends('frontend.layouts.app')
@section('title', 'My Subscription — Find My Naukri')

@section('styles')
<style>
.bl { font-family:'Inter',-apple-system,Segoe UI,Roboto,sans-serif; background:#eef2fb; min-height:100vh; padding:90px 0 60px; }
.bl-wrap { max-width:760px; margin:0 auto; padding:0 18px; }
.card { background:#fff; border-radius:18px; border:1px solid #e6ebf5; box-shadow:0 10px 32px rgba(15,23,42,.08); padding:26px; margin-bottom:20px; }
.card h5 { font-size:1.05rem; font-weight:800; color:#0f172a; margin:0 0 16px; display:flex; align-items:center; gap:8px; }
.plan-banner { display:flex; align-items:center; gap:18px; flex-wrap:wrap; }
.plan-badge { font-size:1.4rem; font-weight:900; padding:10px 22px; border-radius:14px; }
.badge-pro { background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff; }
.badge-free { background:#f1f5f9; color:#475569; }
.plan-meta { color:#64748b; font-size:.9rem; }
.plan-meta strong { color:#0f172a; }
.btn-a { display:inline-flex; align-items:center; gap:7px; padding:11px 22px; border-radius:11px; font-weight:800; text-decoration:none; transition:.18s; border:none; cursor:pointer; }
.btn-primary2 { background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff; }
.btn-primary2:hover { box-shadow:0 10px 26px rgba(37,99,235,.3); color:#fff; }
.tbl { width:100%; border-collapse:collapse; }
.tbl th { text-align:left; font-size:.72rem; text-transform:uppercase; letter-spacing:.4px; color:#94a3b8; font-weight:700; padding:10px 12px; border-bottom:2px solid #eef1f7; }
.tbl td { padding:11px 12px; font-size:.88rem; color:#334155; border-bottom:1px solid #f1f5f9; }
.pill { padding:3px 10px; border-radius:50px; font-size:.72rem; font-weight:700; }
.pill-active { background:#dcfce7; color:#166534; }
.pill-expired { background:#fee2e2; color:#991b1b; }
.status-msg { background:#dcfce7; border:1px solid #bbf7d0; color:#166534; border-radius:10px; padding:11px 14px; font-size:.9rem; margin-bottom:18px; }
.empty { text-align:center; color:#94a3b8; padding:20px; }
</style>
@endsection

@section('content')
<div class="bl">
  <div class="bl-wrap">

    @if(session('status'))
      <div class="status-msg"><i class="bi bi-check-circle-fill"></i> {{ session('status') }}</div>
    @endif

    <div class="card">
      <h5><i class="bi bi-gem"></i> My Subscription</h5>
      <div class="plan-banner">
        <span class="plan-badge {{ $isPro ? 'badge-pro' : 'badge-free' }}">{{ $current?->plan->name ?? 'Free' }}</span>
        <div class="plan-meta">
          @if($isPro && $current)
            You’re on <strong>{{ $current->plan->name }}</strong>.
            @if($current->ends_at)
              Renews/expires on <strong>{{ $current->ends_at->format('d M Y') }}</strong>
              ({{ $current->ends_at->diffForHumans() }}).
            @else
              <strong>Lifetime access.</strong>
            @endif
          @else
            You’re on the <strong>Free</strong> plan. Upgrade to unlock adaptive tests, the full ATS report and unlimited practice.
          @endif
        </div>
      </div>
      <div style="margin-top:18px">
        <a href="{{ route('pricing') }}" class="btn-a btn-primary2">
          <i class="bi bi-stars"></i> {{ $isPro ? 'Renew or change plan' : 'Upgrade to Pro' }}
        </a>
      </div>
    </div>

    <div class="card">
      <h5><i class="bi bi-receipt"></i> Payment History</h5>
      @if($history->isEmpty())
        <div class="empty">No payments yet.</div>
      @else
        <div style="overflow-x:auto">
          <table class="tbl">
            <thead><tr><th>Plan</th><th>Amount</th><th>Started</th><th>Ends</th><th>Status</th></tr></thead>
            <tbody>
              @foreach($history as $sub)
                <tr>
                  <td>{{ $sub->plan->name ?? '—' }}</td>
                  <td>₹{{ (int) $sub->amount }}</td>
                  <td>{{ $sub->starts_at?->format('d M Y') ?? '—' }}</td>
                  <td>{{ $sub->ends_at?->format('d M Y') ?? 'Lifetime' }}</td>
                  <td>
                    @if($sub->isActive())
                      <span class="pill pill-active">Active</span>
                    @else
                      <span class="pill pill-expired">{{ ucfirst($sub->status) }}</span>
                    @endif
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
@endsection
