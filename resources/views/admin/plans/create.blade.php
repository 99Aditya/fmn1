@extends('admin.layout.index')
@section('title', 'Add Plan')
@section('content')

<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">

        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8"><h4>Add Plan</h4></div>
            <div class="col-lg-4">
              <ul class="breadcrumb-title">
                <li class="breadcrumb-item"><a href="{{ route('admin.plans.index') }}">Plans</a></li>
                <li class="breadcrumb-item active">Add</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="page-body">
          <div class="row">
            <div class="col-md-10">
              <div class="card">
                <div class="card-block">
                  @if($errors->any())
                    <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
                  @endif
                  <form action="{{ route('admin.plans.store') }}" method="POST">
                    @csrf
                    @include('admin.plans._form', ['plan' => null, 'features' => $features])
                    <button type="submit" class="btn btn-success">Save Plan</button>
                    <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">Cancel</a>
                  </form>
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
