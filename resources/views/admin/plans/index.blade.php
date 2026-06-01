@extends('admin.layout.index')
@section('title', 'Subscription Plans')
@section('content')

<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">

        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8"><h4>Subscription Plans</h4></div>
            <div class="col-lg-4">
              <ul class="breadcrumb-title">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="feather icon-home"></i></a></li>
                <li class="breadcrumb-item active">Plans</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="page-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex justify-content-between align-items-center">
                    <h5>All Plans</h5>
                    <a href="{{ route('admin.plans.create') }}" class="btn btn-success">Add Plan</a>
                  </div>
                </div>
                <div class="card-block">
                  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                  @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th><th>Price</th><th>Interval</th><th>Features</th>
                          <th>Active Subs</th><th>Status</th><th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($plans as $plan)
                          <tr>
                            <td>
                              <strong>{{ $plan->name }}</strong>
                              @if($plan->is_free)<span class="badge badge-secondary ml-1">Free</span>@endif
                            </td>
                            <td>{{ $plan->is_free ? '—' : '₹' . (int) $plan->price }}</td>
                            <td>{{ ucfirst($plan->billing_interval) }}</td>
                            <td>
                              @foreach($plan->features ?? [] as $f)
                                <span class="badge badge-info">{{ $f }}</span>
                              @endforeach
                            </td>
                            <td>{{ $plan->subscriptions_count }}</td>
                            <td>
                              @if($plan->is_active)
                                <span class="badge badge-success">Active</span>
                              @else
                                <span class="badge badge-secondary">Inactive</span>
                              @endif
                            </td>
                            <td>
                              <a href="{{ route('admin.plans.edit', $plan) }}" class="btn btn-sm btn-primary">Edit</a>
                              <form action="{{ route('admin.plans.destroy', $plan) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this plan?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                              </form>
                            </td>
                          </tr>
                        @empty
                          <tr><td colspan="7" class="text-center text-muted py-4">No plans yet. <a href="{{ route('admin.plans.create') }}">Add one</a>.</td></tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
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
