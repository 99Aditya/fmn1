<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, viewport-fit=cover"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- SEO --}}
    <title>@yield('title', 'Find My Naukri — Free Mock Tests, MCQ Practice & ATS Resume Checker')</title>
    <meta name="description" content="@yield('meta_description', 'Practice free online mock tests and MCQ quizzes, check your resume against ATS systems, and land your dream job with Find My Naukri.')" />
    <meta name="robots" content="@yield('robots', 'index, follow')" />
    <link rel="canonical" href="@yield('canonical', url()->current())" />

    {{-- Open Graph / social --}}
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:site_name" content="Find My Naukri" />
    <meta property="og:title" content="@yield('og_title', View::yieldContent('title', 'Find My Naukri'))" />
    <meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', 'Free mock tests, MCQ practice and ATS resume checking.'))" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="@yield('og_image', asset('logo/logo.png'))" />
    <meta name="twitter:card" content="summary_large_image" />
    <!-- Bootstrap 5 + Icons + Theme -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Bootstrap Icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <!-- Swiper Slider -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    />
    <!-- Animate.css -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/aos@2.3.1/dist/aos.css"
    />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    @yield('styles')
    @yield('head')
  </head>
  <body class="@yield('body_class')">
    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('js/style.js') }}"></script>
    @yield('scripts')
  </body>
</html>
