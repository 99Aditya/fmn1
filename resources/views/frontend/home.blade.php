@extends('frontend.layouts.app')

@section('content')
<main>
  <!-- 1. FULL PAGE SLIDER SECTION ON TOP (Hero) -->
  <div id="home" class="fullpage-slider">
    <div class="swiper fullpage-swiper">
      <div class="swiper-wrapper">
        <!-- Slide 1 - AI Theme -->
        <div
          class="swiper-slide"
          style="
            background-image: url(&quot;https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1600&h=900&fit=crop&quot;);
          "
        >
          <div class="slide-overlay"></div>
          <div
            class="slide-content d-flex flex-column justify-content-center align-items-center h-100"
          >
            <h1>AI-Powered Career Evolution</h1>
            <p>
              Unlock hidden opportunities with smart resume analytics that
              beat any ATS system.
            </p>
            <a href="#resume-ats" class="btn btn-primary btn-lg"
              >Get Started →</a
            >
          </div>
        </div>
        <!-- Slide 2 - Success / Dream Job -->
        <div
          class="swiper-slide"
          style="
            background-image: url(&quot;https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1600&h=900&fit=crop&quot;);
          "
        >
          <div class="slide-overlay"></div>
          <div
            class="slide-content d-flex flex-column justify-content-center align-items-center h-100"
          >
            <h1>Land Your Dream Job</h1>
            <p>
              Join 12k+ professionals who transformed their resumes and
              doubled interview calls.
            </p>
            <a href="#success-stories" class="btn btn-outline-light btn-lg"
              >Success Stories</a
            >
          </div>
        </div>
        <!-- Slide 3 - Data Insights -->
        <div
          class="swiper-slide"
          style="
            background-image: url(&quot;https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1600&h=900&fit=crop&quot;);
          "
        >
          <div class="slide-overlay"></div>
          <div
            class="slide-content d-flex flex-column justify-content-center align-items-center h-100"
          >
            <h1>Instant Resume Intelligence</h1>
            <p>
              Receive actionable feedback, keyword suggestions & ATS score
              within seconds.
            </p>
            <a href="#resume-ats" class="btn btn-primary btn-lg"
              >Analyze Resume</a
            >
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>

  <section class="container my-4 my-md-5 pt-2">
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        <!-- Slide 1 -->
        <div class="swiper-slide text-center">
          <div class="slider-icon"><i class="bi bi-robot"></i></div>
          <h3 class="fw-bold">AI-Powered Career Insights</h3>
          <p class="lead">
            Your resume, analyzed by next-gen ATS algorithms.
          </p>
          <span
            class="badge bg-primary bg-opacity-25 text-primary px-3 py-2 rounded-pill"
            >✨ 96% match accuracy</span
          >
        </div>
        <!-- Slide 2 -->
        <div class="swiper-slide text-center">
          <div class="slider-icon"><i class="bi bi-graph-up"></i></div>
          <h3 class="fw-bold">Get noticed by top employers</h3>
          <p class="lead">Smart keyword optimization & format scoring.</p>
          <span
            class="badge bg-primary bg-opacity-25 text-primary px-3 py-2 rounded-pill"
            >📈 3x more interviews</span
          >
        </div>
        <!-- Slide 3 -->
        <div class="swiper-slide text-center">
          <div class="slider-icon">
            <i class="bi bi-file-text-fill"></i>
          </div>
          <h3 class="fw-bold">Instant Resume Feedback</h3>
          <p class="lead">
            Upload your resume and unlock personalized suggestions.
          </p>
          <span
            class="badge bg-primary bg-opacity-25 text-primary px-3 py-2 rounded-pill"
            >⚡ Real-time analysis</span
          >
        </div>
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </section>

  <!-- 2. Rating Section with Success Stories -->
  <section id="success-stories" class="container my-5 py-5">
    <div class="text-center mb-5">
      <span
        class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-pill mb-2"
        >❤️ Real transformations</span
      >
      <h2 class="display-6 fw-semibold">Success Stories that inspire</h2>
      <p class="text-secondary-emphasis">
        Join thousands who landed their dream job
      </p>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="rating-card card h-100 border-0 shadow-sm p-4">
          <div class="d-flex align-items-center mb-3">
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4"></i>
          </div>
          <p class="fst-italic fs-5">
            “After uploading my resume, I got instant ATS fixes. Within 2
            weeks I received 4 interview calls!”
          </p>
          <div class="mt-auto d-flex align-items-center">
            <img
              src="https://randomuser.me/api/portraits/women/68.jpg"
              alt="avatar"
              class="rounded-circle me-3"
              width="48"
              height="48"
              style="object-fit: cover"
            />
            <div>
              <strong>Sophia Chen</strong><br /><small class="text-muted"
                >Product Manager @ TechUni</small
              >
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="rating-card card h-100 border-0 shadow-sm p-4">
          <div class="d-flex align-items-center mb-3">
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-half text-warning fs-4"></i>
          </div>
          <p class="fst-italic fs-5">
            “The insights dashboard showed missing keywords, I rewrote my
            resume and got hired at Google!”
          </p>
          <div class="mt-auto d-flex align-items-center">
            <img
              src="https://randomuser.me/api/portraits/men/32.jpg"
              alt="avatar"
              class="rounded-circle me-3"
              width="48"
              height="48"
            />
            <div>
              <strong>Michael O.</strong><br /><small class="text-muted"
                >Software Engineer</small
              >
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="rating-card card h-100 border-0 shadow-sm p-4">
          <div class="d-flex align-items-center mb-3">
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4 me-1"></i>
            <i class="bi bi-star-fill text-warning fs-4"></i>
          </div>
          <p class="fst-italic fs-5">
            “From ghosted to 3 offers in a month! Their resume scoring
            engine is pure magic.”
          </p>
          <div class="mt-auto d-flex align-items-center">
            <img
              src="https://randomuser.me/api/portraits/women/45.jpg"
              alt="avatar"
              class="rounded-circle me-3"
              width="48"
              height="48"
            />
            <div>
              <strong>Priya Kapoor</strong><br /><small class="text-muted"
                >Marketing Lead</small
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. Section with Number Counters (Moving counters) -->
  <section id="counters" class="container my-5 py-4">
    <div class="row g-4 text-center">
      <div class="col-md-3 col-6">
        <div class="counter-box">
          <i
            class="bi bi-briefcase-fill fs-1 text-primary mb-2 d-block"
          ></i>
          <div class="counter-number">
            <span class="counter" data-target="12500">0</span>+
          </div>
          <p class="mt-2 fw-semibold">Resumes Optimized</p>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="counter-box">
          <i class="bi bi-people-fill fs-1 text-primary mb-2 d-block"></i>
          <div class="counter-number">
            <span class="counter" data-target="8400">0</span>+
          </div>
          <p class="mt-2 fw-semibold">Happy Job Seekers</p>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="counter-box">
          <i class="bi bi-building fs-1 text-primary mb-2 d-block"></i>
          <div class="counter-number">
            <span class="counter" data-target="320">0</span>+
          </div>
          <p class="mt-2 fw-semibold">Partner Companies</p>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="counter-box">
          <i class="bi bi-trophy-fill fs-1 text-primary mb-2 d-block"></i>
          <div class="counter-number">
            <span class="counter" data-target="98">0</span>%
          </div>
          <p class="mt-2 fw-semibold">ATS Score Boost</p>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. Upload Section for Resume to get ATS based resume insight -->
  <section id="resume-ats" class="container my-5 py-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span
          class="badge bg-primary bg-opacity-15 text-primary px-3 py-2 rounded-pill mb-3"
          ><i class="bi bi-file-earmark-richtext"></i> ATS Analyzer</span
        >
        <h2 class="display-6 fw-semibold">
          Unlock Your Resume’s True Potential
        </h2>
        <p class="lead text-secondary-emphasis mt-3">
          Get instant, detailed insights about keyword density, formatting,
          readability, and ATS compatibility. Our AI simulates how
          recruiters see your profile.
        </p>
        <ul class="list-unstyled mt-4">
          <li class="mb-2">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>ATS
            score & improvement tips
          </li>
          <li class="mb-2">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>Missing
            keyword suggestions
          </li>
          <li class="mb-2">
            <i class="bi bi-check-circle-fill text-primary me-2"></i
            >Section-wise optimization guide
          </li>
        </ul>
      </div>
      <div class="col-lg-6">
        <div class="upload-zone text-center" id="uploadZone">
          <i class="bi bi-cloud-upload-fill fs-1 text-primary"></i>
          <h5 class="mt-3">Drag & drop or click to upload</h5>
          <p class="text-muted small">
            Supports PDF, DOCX, or TXT (max 5MB)
          </p>
          <input
            type="file"
            id="resumeInput"
            accept=".pdf,.docx,.txt,.doc"
            style="display: none"
          />
          <button
            class="btn btn-primary rounded-pill px-4 mt-2"
            id="uploadBtn"
          >
            <i class="bi bi-upload"></i> Choose Resume
          </button>
        </div>
        <div id="insightResult" class="mt-4 d-none">
          <div class="insight-card p-4 bg-body-tertiary">
            <div class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-gem fs-4 text-primary"></i>
              <h5 class="mb-0">ATS Insight Report</h5>
            </div>
            <div id="atsFeedback"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
