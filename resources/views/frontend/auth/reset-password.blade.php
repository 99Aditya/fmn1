@extends('frontend.layouts.app')

@section('title', 'Reset Password')

@section('content')
<main class="container my-5 py-4">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-5">
          <h2 class="fw-bold mb-3">Reset Password</h2>
          <p class="text-muted mb-4">Set a new secure password for your account.</p>

          @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
          @endif

          <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" id="email" name="email" value="{{ old('email', $email) }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">New password</label>
              <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-4">
              <label for="password_confirmation" class="form-label">Confirm password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Reset Password</button>
          </form>

          <div class="text-center mt-4">
            <a href="{{ route('login') }}">Return to login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
