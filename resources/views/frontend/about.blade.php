<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>About Us | TestsUpp - AI Quiz Platform Mission & Team</title>
  <!-- Bootstrap 5 + Icons + Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,600;14..32,700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: #ffffff;
      color: #1a202c;
      scroll-behavior: smooth;
    }

    h1, h2, h3, h4, .navbar-brand, .btn, .display-heading {
      font-family: 'Poppins', sans-serif;
    }

    /* reusable components from main style */
    .badge-ai {
      background: #e0e7ff;
      color: #1e40af;
      font-weight: 500;
      border-radius: 40px;
      padding: 0.2rem 0.9rem;
      font-size: 0.75rem;
    }
    .btn-primary-custom {
      background-color: #2563eb;
      border: none;
      padding: 0.6rem 1.8rem;
      border-radius: 60px;
      font-weight: 600;
      transition: all 0.2s;
    }
    .btn-primary-custom:hover {
      background-color: #1d4ed8;
      transform: scale(1.02);
      box-shadow: 0 12px 20px -12px #2563eb;
    }
    .btn-outline-custom {
      border: 2px solid #2563eb;
      color: #2563eb;
      border-radius: 60px;
      padding: 0.55rem 1.5rem;
      font-weight: 600;
      background: transparent;
      transition: 0.2s;
    }
    .btn-outline-custom:hover {
      background-color: #2563eb;
      color: white;
    }
    .hero-about {
      background: linear-gradient(120deg, #f8fafc 0%, #eef2ff 100%);
      border-bottom-left-radius: 2rem;
      border-bottom-right-radius: 2rem;
    }
    .stat-bubble {
      transition: transform 0.2s;
    }
    .stat-bubble:hover {
      transform: translateY(-6px);
    }
    .team-card {
      transition: all 0.25s ease;
      border-radius: 1.5rem;
      overflow: hidden;
      border: 1px solid #eef2ff;
    }
    .team-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.08);
      border-color: #cbd5e1;
    }
    .value-icon {
      background-color: #eef2ff;
      width: 64px;
      height: 64px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 28px;
      font-size: 2rem;
      color: #2563eb;
      margin-bottom: 1rem;
    }
    .footer-link {
      text-decoration: none;
      color: #cbd5e1;
      transition: color 0.2s;
    }
    .footer-link:hover {
      color: white;
    }
  </style>
</head>
<body>

<!-- Navigation (consistent with homepage) -->
<nav class="navbar navbar-expand-lg py-3">
  <div class="container">
    <a class="navbar-brand fw-bold fs-3" href="#" style="color:#0f172a;">
      <i class="bi bi-stars me-2" style="color:#2563eb;"></i>TestsUpp
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAbout" aria-controls="navbarAbout" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarAbout">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Testimonials</a></li>
      </ul>
      <div class="d-flex gap-2">
        <button class="btn btn-outline-custom">Log in</button>
        <button class="btn btn-primary-custom">Sign Up Free</button>
      </div>
    </div>
  </div>
</nav>

<!-- Hero Section - About Us -->
<section class="hero-about pt-5 pb-5">
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

<!-- Mission & Vision (split) -->
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

<!-- Numbers / Impact Section -->
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

<!-- Core Values (flex) -->
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

<!-- Meet our leadership / team (modern cards) -->
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

<!-- Timeline / milestones -->
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

<!-- CTA: Join us (believers) -->
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

<!-- Footer (similar to main) -->
<footer class="bg-dark text-white pt-5 pb-4">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-5">
        <a class="navbar-brand fs-3 fw-bold text-white" href="#"><i class="bi bi-stars me-2"></i>TestsUpp</a>
        <p class="text-white-50 mt-2 small">Create and practice quizzes with advanced AI. Free for educators, students and companies.</p>
        <div class="mt-3">
          <i class="bi bi-twitter-x me-3 fs-5"></i>
          <i class="bi bi-linkedin me-3 fs-5"></i>
          <i class="bi bi-github fs-5"></i>
        </div>
      </div>
      <div class="col-md-2">
        <h6 class="fw-semibold">Company</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="footer-link">About Us</a></li>
          <li><a href="#" class="footer-link">Blog</a></li>
          <li><a href="#" class="footer-link">Careers</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <h6 class="fw-semibold">Resources</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="footer-link">Help Center</a></li>
          <li><a href="#" class="footer-link">API docs</a></li>
          <li><a href="#" class="footer-link">Community</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h6 class="fw-semibold">Legal</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="footer-link">Cookie Policy</a></li>
          <li><a href="#" class="footer-link">Privacy</a></li>
          <li><a href="#" class="footer-link">Terms of use</a></li>
        </ul>
      </div>
    </div>
    <hr class="mt-4 opacity-25">
    <div class="text-center text-white-50 small">
      &copy; 2025 TestsUpp — Empowering education with AI.
    </div>
  </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>