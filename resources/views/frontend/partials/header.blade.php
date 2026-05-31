<!-- Navigation (starts transparent) -->
<nav id="mainNavbar" class="navbar navbar-menu-right fixed-top">
  <div class="container navbar-menu-container">
    <a class="navbar-brand d-flex align-items-center fw-bold text-white flex-shrink-0" href="{{ url('/') }}">
      <img src="{{ asset('logo/logo1.png') }}" alt="" height="36" class="me-1" />
    </a>
    <div class="navbar-menu-panel" id="navbarMain">
      <ul class="navbar-nav navbar-menu-list ms-auto mb-0 align-items-center">
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->is('/') ? 'fw-semibold' : '' }}" href="{{ url('/') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->is('about') ? 'fw-semibold' : '' }}" href="{{ url('/about') }}">About</a>
        </li>
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle text-white {{ request()->is('community') || request()->is('ats') || request()->is('ats/*') || request()->is('mock') ? 'fw-semibold' : '' }}"
            href="#"
            id="serviceDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            Service
          </a>
          <ul class="dropdown-menu dropdown-menu-end navbar-dropdown-menu" aria-labelledby="serviceDropdown">
            <li>
              <a class="dropdown-item {{ request()->is('community') ? 'fw-semibold' : '' }}" href="{{ url('/community') }}">Community</a>
            </li>
            <li>
              <a class="dropdown-item {{ request()->is('ats') || request()->is('ats/*') ? 'fw-semibold' : '' }}" href="{{ url('/ats') }}">ATS Insight</a>
            </li>
            <li>
              <a class="dropdown-item {{ request()->is('mock') ? 'fw-semibold' : '' }}" href="{{ url('/mock') }}">Mock</a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->is('tests*') ? 'fw-semibold' : '' }}" href="{{ route('tests.index') }}">MCQ Tests</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->is('contact') ? 'fw-semibold' : '' }}" href="{{ url('/contact') }}">Contact</a>
        </li>
    
        @if(auth()->check())
          <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('dashboard*') ? 'fw-semibold' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white" href="#" data-bs-toggle="dropdown">
              <img src="{{ auth()->user()->avatar_url }}" alt="" style="width:30px;height:30px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,.4)">
              <span class="d-none d-lg-inline">{{ Str::limit(auth()->user()->name, 14) }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-user-dropdown">
              <li>
                <a class="dropdown-item" href="{{ route('profile.show') }}">
                  <i class="bi bi-person-fill me-2 text-primary"></i>My Profile
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                  <i class="bi bi-pencil-fill me-2 text-primary"></i>Edit Profile
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('connections.index') }}">
                  <i class="bi bi-people-fill me-2 text-primary"></i>Connections
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('dashboard') }}">
                  <i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard
                </a>
              </li>
              <li><hr class="dropdown-divider my-1"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-light btn-sm rounded-pill px-3 py-1" href="{{ route('register') }}">Sign Up</a>
          </li>
        @endif
        <li class="nav-item">
          <button
            id="darkModeToggle"
            class="btn btn-outline-light btn-outline-theme theme-toggle"
          >
            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
            <span id="themeText">Dark</span>
          </button>
        </li> 
      </ul>
    </div>
  </div>
</nav>
