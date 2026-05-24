@extends('frontend.layouts.app')

@section('content')
<main>
  <section id="about" class="hero-about pt-5 pb-5">
    <div class="container py-4">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <span class="badge-ai mb-3 d-inline-block"><i class="bi bi-flag-fill me-1"></i> Our story</span>
          <h1 class="display-4 fw-bold mb-4">Democratizing education through<span class="text-primary"> intelligent quizzes</span></h1>
          <p class="lead fs-5 text-secondary">TestsUpp was born from a simple idea: learning should be adaptive, engaging, and accessible to everyone. We combine artificial intelligence with intuitive design to help educators, students, and companies unlock their full potential — completely free.</p>
          <div class="d-flex flex-wrap gap-3 mt-4">
            <a href="#" class="btn btn-primary-custom"><i class="bi bi-journal-bookmark-fill me-2"></i>Our Mission</a>
            <a href="#" class="btn btn-outline-custom"><i class="bi bi-chat-dots"></i> Meet the team</a>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="bg-white rounded-4 shadow p-4 text-center border">
            <i class="bi bi-quote fs-1 text-primary opacity-50"></i>
            <p class="mt-2 fst-italic">“We believe that technology breaks barriers — our platform already empowers over 200k active students worldwide.”</p>
            <hr>
            <div class="d-flex justify-content-between">
              <div><strong>2021</strong><br><small>Founded</small></div>
              <div><strong>100%</strong><br><small>Free forever</small></div>
              <div><strong>50K+</strong><br><small>Quizzes</small></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container">
      <div class="row g-5">
        <div class="col-md-6">
          <div class="bg-white p-4 rounded-4 shadow-sm h-100 border-0 border-start border-5 border-primary">
            <i class="bi bi-rocket-takeoff fs-1 text-primary mb-3 d-block"></i>
            <h3 class="fw-bold">Our Mission</h3>
            <p class="text-secondary mt-2">To empower every learner and teacher with AI-driven assessment tools that are intuitive, insightful, and inclusive. We strive to remove financial barriers and make quiz creation effortless for everyone.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="bg-white p-4 rounded-4 shadow-sm h-100 border-0 border-start border-5 border-info">
            <i class="bi bi-eye fs-1 text-info mb-3 d-block"></i>
            <h3 class="fw-bold">Our Vision</h3>
            <p class="text-secondary mt-2">A world where knowledge testing is no longer a chore but an exciting journey. We envision an ecosystem where adaptive AI adapts to each student’s pace, fostering real understanding and measurable growth.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-light py-5">
    <div class="container py-4">
      <div class="text-center mb-5">
        <h2 class="fw-bold">TestsUpp by the numbers</h2>
        <p class="text-secondary col-lg-6 mx-auto">Driving real impact in the education and corporate training space.</p>
      </div>
      <div class="row g-4 text-center">
        <div class="col-md-3 col-6">
          <div class="stat-bubble bg-white p-3 rounded-4 shadow-sm">
            <h2 class="display-5 fw-bold text-primary">50K+</h2>
            <p class="text-secondary mb-0">Quizzes created</p>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="stat-bubble bg-white p-3 rounded-4 shadow-sm">
            <h2 class="display-5 fw-bold text-primary">200K+</h2>
            <p class="text-secondary mb-0">Active students</p>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="stat-bubble bg-white p-3 rounded-4 shadow-sm">
            <h2 class="display-5 fw-bold text-primary">95%</h2>
            <p class="text-secondary mb-0">recommendation rate</p>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="stat-bubble bg-white p-3 rounded-4 shadow-sm">
            <h2 class="display-5 fw-bold text-primary">1M+</h2>
            <p class="text-secondary mb-0">Questions / month</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">The values that guide us</h2>
        <p class="text-secondary">Every line of code, every feature reflects our core principles.</p>
      </div>
      <div class="row g-4">
        <div class="col-md-4 text-center">
          <div class="value-icon mx-auto"><i class="bi bi-laptop"></i></div>
          <h5 class="fw-bold">Accessibility First</h5>
          <p class="text-secondary">Fully free, no paywalls, and designed for diverse learning environments.</p>
        </div>
        <div class="col-md-4 text-center">
          <div class="value-icon mx-auto"><i class="bi bi-cpu"></i></div>
          <h5 class="fw-bold">AI for Good</h5>
          <p class="text-secondary">Ethical AI that enhances learning without replacing human creativity.</p>
        </div>
        <div class="col-md-4 text-center">
          <div class="value-icon mx-auto"><i class="bi bi-people"></i></div>
          <h5 class="fw-bold">Community Driven</h5>
          <p class="text-secondary">Co-created with educators, students and feedback from thousands of users.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-light py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Meet the minds behind TestsUpp</h2>
        <p class="text-secondary col-lg-7 mx-auto">A passionate team of engineers, educators, and designers committed to transforming online assessment.</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-4 col-md-6">
          <div class="team-card bg-white p-4 text-center">
            <div class="mb-3">
              <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle shadow-sm" width="110" height="110" alt="CEO portrait">
            </div>
            <h5 class="fw-bold mb-1">Dr. Elena Martineau</h5>
            <p class="text-primary small fw-semibold">CEO & Co-founder</p>
            <p class="text-secondary small">Former learning scientist with PhD in EdTech. Passionate about AI-driven personalization.</p>
            <div class="mt-2"><i class="bi bi-linkedin me-2"></i><i class="bi bi-twitter-x"></i></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="team-card bg-white p-4 text-center">
            <div class="mb-3">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" class="rounded-circle shadow-sm" width="110" height="110" alt="CTO portrait">
            </div>
            <h5 class="fw-bold mb-1">Marcus Chen</h5>
            <p class="text-primary small fw-semibold">CTO & AI Lead</p>
            <p class="text-secondary small">Engineer specialized in adaptive learning algorithms. Previously built AI tools for Khan Academy.</p>
            <div class="mt-2"><i class="bi bi-linkedin me-2"></i><i class="bi bi-github"></i></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mx-auto">
          <div class="team-card bg-white p-4 text-center">
            <div class="mb-3">
              <img src="https://randomuser.me/api/portraits/women/89.jpg" class="rounded-circle shadow-sm" width="110" height="110" alt="Head of product">
            </div>
            <h5 class="fw-bold mb-1">Sophia Rivera</h5>
            <p class="text-primary small fw-semibold">Head of Learning Experience</p>
            <p class="text-secondary small">Curriculum designer & former teacher. She ensures TestsUpp is intuitive for educators worldwide.</p>
            <div class="mt-2"><i class="bi bi-linkedin me-2"></i><i class="bi bi-envelope"></i></div>
          </div>
        </div>
      </div>
      <div class="text-center mt-5">
        <p class="text-secondary">And 10+ passionate collaborators across 4 continents 🌍</p>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Our journey</h2>
        <p class="text-secondary">From an ambitious idea to a global platform.</p>
      </div>
      <div class="row g-0 position-relative">
        <div class="col-md-4 text-center p-3">
          <div class="bg-white rounded-3 p-3 shadow-sm h-100">
            <div class="badge-ai d-inline-block mb-2">2021</div>
            <h5 class="fw-bold">✨ The beginning</h5>
            <p class="small text-secondary">Launched MVP with 500 beta testers. Built the first AI question generator.</p>
          </div>
        </div>
        <div class="col-md-4 text-center p-3">
          <div class="bg-white rounded-3 p-3 shadow-sm h-100">
            <div class="badge-ai d-inline-block mb-2">2023</div>
            <h5 class="fw-bold">🚀 Global expansion</h5>
            <p class="small text-secondary">Reached 100K+ users and introduced collaboration features for teams.</p>
          </div>
        </div>
        <div class="col-md-4 text-center p-3">
          <div class="bg-white rounded-3 p-3 shadow-sm h-100">
            <div class="badge-ai d-inline-block mb-2">2025</div>
            <h5 class="fw-bold">🏆 AI 2.0 & beyond</h5>
            <p class="small text-secondary">New adaptive learning engine, mobile apps, and 1M+ monthly responses.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5 bg-primary bg-gradient text-white">
    <div class="container text-center py-4">
      <h2 class="fw-bold mb-3">Be part of our story</h2>
      <p class="lead mb-4 opacity-90">Whether you're an educator, student, or lifelong learner — TestsUpp is your home for smarter quizzing. Free forever, built with love.</p>
      <div class="d-flex flex-wrap gap-3 justify-content-center">
        <button class="btn btn-light rounded-pill px-4 fw-semibold text-primary"><i class="bi bi-pencil-square me-2"></i>Start creating free</button>
        <button class="btn btn-outline-light rounded-pill px-4"><i class="bi bi-chat-heart"></i> Contact us</button>
      </div>
      <p class="mt-4 small opacity-75"><i class="bi bi-shield-check"></i> No credit card • No subscription • Join 200k+ active students</p>
    </div>
  </section>
</main>
@endsection
