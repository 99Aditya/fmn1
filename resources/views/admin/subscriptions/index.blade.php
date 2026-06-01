@extends('admin.layout.index')
@section('title', 'Subscribers')
@section('content')

<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">

        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8"><h4>Subscribers</h4></div>
            <div class="col-lg-4">
              <ul class="breadcrumb-title">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item active">Subscribers</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="page-body">
          <div class="row">
            <div class="col-md-4">
              <div class="card"><div class="card-block text-center">
                <h3 class="text-primary mb-0">{{ $stats['active'] }}</h3><p class="text-muted mb-0">Active subscriptions</p>
              </div></div>
            </div>
            <div class="col-md-4">
              <div class="card"><div class="card-block text-center">
                <h3 class="mb-0">{{ $stats['total'] }}</h3><p class="text-muted mb-0">Total subscriptions</p>
              </div></div>
            </div>
            <div class="col-md-4">
              <div class="card"><div class="card-block text-center">
                <h3 class="text-success mb-0">₹{{ number_format($stats['revenue']) }}</h3><p class="text-muted mb-0">Total revenue</p>
              </div></div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex justify-content-between align-items-center">
                    <h5>All Subscriptions</h5>
                    <form method="GET" class="d-flex" style="gap:8px">
                      <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                        <option value="">All statuses</option>
                        @foreach(['active' => 'Active', 'expired' => 'Expired', 'cancelled' => 'Cancelled'] as $val => $lbl)
                          <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                        @endforeach
                      </select>
                    </form>
                  </div>
                </div>
                <div class="card-block">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr><th>User</th><th>Plan</th><th>Amount</th><th>Started</th><th>Ends</th><th>Status</th></tr>
                      </thead>
                      <tbody>
                        @forelse($subscriptions as $sub)
                          <tr>
                            <td>
                              <strong>{{ $sub->user->name ?? '—' }}</strong><br>
                              <small class="text-muted">{{ $sub->user->email ?? '' }}</small>
                            </td>
                            <td>{{ $sub->plan->name ?? '—' }}</td>
                            <td>₹{{ (int) $sub->amount }}</td>
                            <td>{{ $sub->starts_at?->format('d M Y') ?? '—' }}</td>
                            <td>{{ $sub->ends_at?->format('d M Y') ?? 'Lifetime' }}</td>
                            <td>
                              @if($sub->isActive())
                                <span class="badge badge-success">Active</span>
                              @else
                                <span class="badge badge-secondary">{{ ucfirst($sub->status) }}</span>
                              @endif
                            </td>
                          </tr>
                        @empty
                          <tr><td colspan="6" class="text-center text-muted py-4">No subscriptions yet.</td></tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                  {{ $subscriptions->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
