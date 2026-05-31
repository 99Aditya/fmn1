@extends('frontend.layouts.app')

@section('title', 'Login')

@section('content')
<main class="container my-5 py-4">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-5">
          <h2 class="fw-bold mb-3">Sign In</h2>
          <p class="text-muted mb-4">Enter your email and password to access your account.</p>

          @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
          @endif

          <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autofocus>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <label for="password" class="form-label">Password</label>
                <a href="{{ route('password.request') }}" class="small">Forgot password?</a>
              </div>
              <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-4 form-check">
              <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
          </form>

          <div class="text-center mt-4">
            <span class="text-muted">Don’t have an account?</span>
            <a href="{{ route('register') }}">Sign Up</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
