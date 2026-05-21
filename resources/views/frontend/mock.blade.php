@extends('frontend.layouts.app')

@section('title', 'CareerElevate | Mock Interview & MCQ Prep')

@section('content')
<main>
  <!-- 1. Banner Section -->
  <section class="mock-hero">
    <div class="container text-center" data-aos="fade-up">
      <span class="hero-badge mb-3"
        ><i class="bi bi-mic me-1"></i> AI-Powered Interview Simulator</span
      >
      <h1 class="display-4 fw-bold mt-2">Mock Interviews & MCQ Mastery</h1>
      <p class="lead mx-auto mock-hero-copy">
        Practice with real-world questions, get instant feedback, and build
        unshakable confidence before your big day.
      </p>
      <div class="mt-4 d-flex flex-wrap gap-3 justify-content-center">
        <a href="{{ url('/mcq-test') }}"
          class="btn btn-light btn-lg rounded-pill px-4"
          id="startMockJourneyBtn"
        >
          <i class="bi bi-person-video3"></i> Start Mock Interview
        </a>
        <a href="{{ url('/mcq-challenge') }}"
          class="btn btn-outline-light btn-lg rounded-pill px-4"
          id="startMcqBtn"
        >
          <i class="bi bi-pencil-square"></i> Take MCQ Challenge
        </a>
      </div>
    </div>
  </section>

  <!-- 2. How Mock / MCQ will help you -->
  <div id="benefits" class="container my-5 py-4">
    <div class="text-center mb-5" data-aos="fade-up">
      <span
        class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-pill"
        ><i class="bi bi-stars"></i> Why It Works</span
      >
      <h2 class="display-6 fw-semibold mt-2">
        Supercharge Your Interview Readiness
      </h2>
      <p class="text-secondary-emphasis col-lg-7 mx-auto">
        From behavioral rounds to technical MCQs — everything you need to
        crack any hiring process.
      </p>
    </div>
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="50">
        <div class="benefit-card card h-100 border-0 shadow-sm p-4 text-center">
          <div class="benefit-icon mx-auto">
            <i class="bi bi-chat-dots-fill text-primary"></i>
          </div>
          <h4>Realistic Mock Interviews</h4>
          <p>
            Simulate live interviews with industry-specific questions. Learn
            to articulate answers under pressure.
          </p>
          <div class="mt-2">
            <i class="bi bi-check-circle-fill text-success"></i> 200+
            role-specific sets
          </div>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="benefit-card card h-100 border-0 shadow-sm p-4 text-center">
          <div class="benefit-icon mx-auto">
            <i class="bi bi-question-circle-fill text-primary"></i>
          </div>
          <h4>MCQ Challenge Bank</h4>
          <p>
            Aptitude, coding logic, HR scenarios, domain knowledge — test
            your concepts with timed quizzes.
          </p>
          <div class="mt-2">
            <i class="bi bi-check-circle-fill text-success"></i> 1000+
            unique MCQs
          </div>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
        <div class="benefit-card card h-100 border-0 shadow-sm p-4 text-center">
          <div class="benefit-icon mx-auto">
            <i class="bi bi-graph-up-arrow text-primary"></i>
          </div>
          <h4>Instant Performance Insights</h4>
          <p>
            Get detailed scoring, suggested answers, and areas to improve
            after every mock & quiz attempt.
          </p>
          <div class="mt-2">
            <i class="bi bi-check-circle-fill text-success"></i> Track
            progress over time
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. User Review Section -->
  <section
    id="reviews"
    class="container my-5 py-4 bg-body-tertiary rounded-4 p-4"
  >
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="display-6 fw-semibold">
        <i class="bi bi-chat-heart-fill text-primary me-2"></i>Success
        Stories
      </h2>
      <p>
        What job seekers & students say about our mock interview platform
      </p>
    </div>
    <div class="row g-4">
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="0">
        <div class="review-card p-4 h-100">
          <div class="rating-stars mb-2">★★★★★</div>
          <p class="fst-italic">
            “The mock interview module helped me overcome nervousness. I got
            actual questions similar to my real FAANG interview. Landed the
            offer!”
          </p>
          <div class="d-flex align-items-center mt-3">
            <img
              src="https://randomuser.me/api/portraits/women/33.jpg"
              width="45"
              height="45"
              class="rounded-circle me-3"
            />
            <div>
              <strong>Anjali Sharma</strong><br /><small
                >Software Engineer @ Amazon</small
              >
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="review-card p-4 h-100">
          <div class="rating-stars mb-2">★★★★★</div>
          <p class="fst-italic">
            “MCQ section for aptitude and reasoning sharpened my speed.
            Practiced 20 tests and saw massive improvement in placement
            exams.”
          </p>
          <div class="d-flex align-items-center mt-3">
            <img
              src="https://randomuser.me/api/portraits/men/41.jpg"
              width="45"
              height="45"
              class="rounded-circle me-3"
            />
            <div>
              <strong>Rahul Mehta</strong><br /><small
                >MBA Grad · Placed at Deloitte</small
              >
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="review-card p-4 h-100">
          <div class="rating-stars mb-2">★★★★★</div>
          <p class="fst-italic">
            “Unique behavioral mock interviews with instant AI feedback
            transformed my storytelling. Got promoted after showcasing
            leadership answers!”
          </p>
          <div class="d-flex align-items-center mt-3">
            <img
              src="https://randomuser.me/api/portraits/men/75.jpg"
              width="45"
              height="45"
              class="rounded-circle me-3"
            />
            <div>
              <strong>Carlos Mendez</strong><br /><small>Product Manager</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. Start Mock & MCQ Journey (Launch Cards) -->
  <section id="journey" class="container my-5 py-4">
    <div class="text-center mb-5" data-aos="fade-up">
      <span class="badge bg-primary bg-opacity-10 px-4 py-2 rounded-pill"
        ><i class="bi bi-rocket-takeoff"></i> Launch Your Practice</span
      >
      <h2 class="display-6 fw-semibold mt-2">Choose Your Path</h2>
      <p>
        Interactive sessions designed to simulate real pressure and boost
        your confidence
      </p>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-md-5" data-aos="fade-right">
        <div
          class="journey-card card p-4 text-center h-100"
          id="mockJourneyCard"
        >
          <i class="bi bi-camera-reels-fill journey-icon text-primary"></i>
          <h3 class="mt-3">🎤 Live Mock Interview</h3>
          <p>
            Experience a realistic interview with curated questions and
            AI-powered feedback. Perfect for behavioral & technical rounds.
          </p>
          <div class="mt-2 d-flex justify-content-center gap-3">
            <span class="badge bg-light text-dark">30+ categories</span>
            <span class="badge bg-light text-dark">Voice enabled</span>
          </div>
          <a href="{{ url('/mcq-test') }}"
            class="btn btn-primary rounded-pill mt-4 w-75 mx-auto start-mock-btn"
          >
            Start Mock Interview →
          </a>
        </div>
      </div>
      <div class="col-md-5" data-aos="fade-left">
        <div
          class="journey-card card p-4 text-center h-100"
          id="mcqJourneyCard"
        >
          <i class="bi bi-pencil-square journey-icon text-success"></i>
          <h3 class="mt-3">📝 MCQ Challenge Hub</h3>
          <p>
            Test your knowledge with adaptive MCQs: Aptitude, Coding, HR,
            Domain-specific. Get instant scores & explanations.
          </p>
          <div class="mt-2 d-flex justify-content-center gap-3">
            <span class="badge bg-light text-dark">1000+ questions</span>
            <span class="badge bg-light text-dark">Timed mode</span>
          </div>
          <a href="{{ url('/mcq-challenge') }}"
            class="btn btn-success rounded-pill mt-4 w-75 mx-auto start-mcq-challenge"
          >
            Start MCQ Challenge →
          </a>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
