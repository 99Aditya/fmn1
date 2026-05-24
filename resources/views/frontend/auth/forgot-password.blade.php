@extends('frontend.layouts.app')

@section('title', 'Forgot Password')

@section('content')
<main class="container my-5 py-4">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-5">
          <h2 class="fw-bold mb-3">Forgot Password</h2>
          <p class="text-muted mb-4">Enter your email and we’ll send you a link to reset your password.</p>

          @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
          @endif

          <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required autofocus>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Send Reset Link</button>
          </form>

          <div class="text-center mt-4">
            <span class="text-muted">Remembered your password?</span>
            <a href="{{ route('login') }}">Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
