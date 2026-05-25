@extends('frontend.layouts.app')

@section('title', 'Register')

@section('content')
<main class="container my-5 py-4">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-5">
          <h2 class="fw-bold mb-3">Create Account</h2>
          <p class="text-muted mb-4">Sign up with your name, email, and a secure password.</p>

          <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="mb-3">
              <label for="name" class="form-label">Full name</label>
              <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required autofocus>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirm password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Sign Up</button>
          </form>

          <div class="text-center mt-4">
            <span class="text-muted">Already have an account?</span>
            <a href="{{ route('login') }}">Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
