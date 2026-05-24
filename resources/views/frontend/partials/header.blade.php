<!-- Navigation (starts transparent) -->
<nav id="mainNavbar" class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="{{ url('/') }}">
      <img src="{{ asset('logo/logo1.png') }}" alt="" height="40" class="me-2" />
    </a>
    <button
      class="navbar-toggler border-0 bg-white bg-opacity-25"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarMain"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarMain">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-2">
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold" href="{{ url('/') }}">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ url('/about') }}">About</a>
        </li>
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle text-white"
            href="#"
            id="serviceDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            Service
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="serviceDropdown">
            <li>
              <a class="dropdown-item" href="{{ url('/community') }}">Community</a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ url('/ats') }}">ATS Insight</a>
            </li>
            <li>
              <a class="dropdown-item" href="{{ url('/mock') }}">Mock</a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="{{ url('/contact') }}">Contact</a>
        </li>
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
