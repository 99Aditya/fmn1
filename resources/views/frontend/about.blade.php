@extends('frontend.layouts.app')

@section('title', 'About Us')

@section('content')
<main class="contact-page">
  {{-- Hero --}}
  <section id="about" class="hero-contact pt-5 pb-5">
    <div class="container py-4">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <span class="badge-ai mb-3 d-inline-block"><i class="bi bi-briefcase-fill me-1"></i> Find My Naukri</span>
          <h1 class="display-4 fw-bold mb-4">Connecting talent with opportunity — <span class="text-primary">smarter, safer, and transparent</span></h1>
          <p class="lead fs-5 text-secondary">We are building a trusted platform where companies find the right candidates and individuals find the right jobs — without the noise, fraud, or confusion. From verified job listings to AI-powered resume insights, we simplify hiring for everyone.</p>
          <div class="d-flex flex-wrap gap-3 mt-4">
            <a href="{{ route('register') }}" class="btn btn-primary-custom"><i class="bi bi-rocket-takeoff me-2"></i>Get Started</a>
            <a href="{{ url('/#resume-ats') }}" class="btn btn-outline-custom"><i class="bi bi-stars"></i> Explore Features</a>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="contact-surface rounded-4 shadow-sm p-4 text-center border">
            <i class="bi bi-shield-check fs-1 text-primary opacity-75"></i>
            <p class="mt-2 fw-semibold">Built to fix what's broken in hiring</p>
            <hr>
            <div class="d-flex justify-content-between">
              <div><strong>50K+</strong><br><small>Verified jobs</small></div>
              <div><strong>95%</strong><br><small>Trusted listings</small></div>
              <div><strong>200K+</strong><br><small>Active users</small></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Mission & Vision --}}
  <section class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <span class="badge-ai mb-3 d-inline-block"><i class="bi bi-compass-fill me-1"></i> What drives us</span>
        <h2 class="fw-bold">Our mission &amp; vision</h2>
        <p class="text-secondary col-lg-7 mx-auto">Everything we build is aimed at making hiring fairer for candidates and faster for companies.</p>
      </div>
      <div class="row g-5">
        <div class="col-md-6">
          <div class="contact-surface p-4 rounded-4 shadow-sm h-100 border-0 border-start border-5 border-primary">
            <i class="bi bi-rocket-takeoff fs-1 text-primary mb-3 d-block"></i>
            <h3 class="fw-bold">Our Mission</h3>
            <p class="text-secondary mt-2 mb-0">To make job searching and hiring trustworthy, transparent, and efficient for everyone. We connect verified companies with the right talent through subscription-based listings, AI-powered resume insights, and tools that cut through fake postings, unclear processes, and hiring noise — so both sides can move forward with confidence.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="contact-surface p-4 rounded-4 shadow-sm h-100 border-0 border-start border-5 border-info">
            <i class="bi bi-eye fs-1 text-info mb-3 d-block"></i>
            <h3 class="fw-bold">Our Vision</h3>
            <p class="text-secondary mt-2 mb-0">A smarter hiring future where every candidate discovers genuine opportunities and every company finds quality talent without friction. We envision an ecosystem built on verified jobs, adaptive assessments, mock interviews, and AI-driven career guidance — helping people grow their skills while companies hire with trust and clarity.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Our Story --}}
  <section class="py-5">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-5">
          <span class="badge-ai mb-3 d-inline-block"><i class="bi bi-flag-fill me-1"></i> Our Story</span>
          <h2 class="fw-bold mb-3">Built to fix what's broken in hiring</h2>
          <p class="text-secondary">We started with a simple idea — job searching and hiring should be trustworthy, transparent, and efficient.</p>
        </div>
        <div class="col-lg-7">
          <div class="contact-surface p-4 rounded-4 shadow-sm border">
            <p class="text-secondary mb-3">Today, many candidates struggle with fake job postings, unclear hiring processes, and lack of guidance. At the same time, companies face challenges in finding the right talent quickly.</p>
            <p class="text-secondary mb-0">Our platform bridges this gap by combining verified job listings, AI-powered tools, and a community-driven approach to create a better hiring ecosystem.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- By The Numbers --}}
  <section class="py-5 contact-muted-section">
    <div class="container py-4">
      <div class="text-center mb-5">
        <h2 class="fw-bold">By the numbers</h2>
        <p class="text-secondary col-lg-6 mx-auto">Real impact across hiring, assessments, and career growth.</p>
      </div>
      <div class="row g-4 text-center">
        <div class="col-md-3 col-6">
          <div class="contact-surface p-3 rounded-4 shadow-sm">
            <h2 class="display-5 fw-bold text-primary">50K+</h2>
            <p class="text-secondary mb-0">Verified Opportunities</p>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="contact-surface p-3 rounded-4 shadow-sm">
            <h2 class="display-5 fw-bold text-primary">200K+</h2>
            <p class="text-secondary mb-0">Active Users</p>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="contact-surface p-3 rounded-4 shadow-sm">
            <h2 class="display-5 fw-bold text-primary">95%</h2>
            <p class="text-secondary mb-0">Trusted Listings</p>
          </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="contact-surface p-3 rounded-4 shadow-sm">
            <h2 class="display-5 fw-bold text-primary">1M+</h2>
            <p class="text-secondary mb-0">Assessments Completed</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- What Makes Us Different --}}
  <section class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">What makes us different</h2>
        <p class="text-secondary col-lg-8 mx-auto">Tools and trust built for both companies and candidates — not just another job board.</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="contact-surface p-4 rounded-4 shadow-sm h-100 border-0 border-start border-5 border-primary">
            <div class="contact-icon mb-3"><i class="bi bi-patch-check-fill"></i></div>
            <h5 class="fw-bold">Subscription-Based Job Posting</h5>
            <p class="text-secondary mb-0">We eliminate fake jobs by allowing only verified companies and HRs to post jobs through subscription plans. This ensures quality over quantity and builds trust for candidates.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-surface p-4 rounded-4 shadow-sm h-100 border-0 border-start border-5 border-info">
            <div class="contact-icon mb-3"><i class="bi bi-robot"></i></div>
            <h5 class="fw-bold">Built-in ATS &amp; Resume Scoring</h5>
            <p class="text-secondary mb-2">Our platform includes an AI-powered ATS system that:</p>
            <ul class="text-secondary small mb-2 ps-3">
              <li>Scores your resume</li>
              <li>Suggests improvements</li>
              <li>Helps you match job requirements</li>
            </ul>
            <p class="text-secondary small mb-0">Free users get basic insights, while premium users can optimize resumes multiple times every month.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-surface p-4 rounded-4 shadow-sm h-100 border-0 border-start border-5 border-success">
            <div class="contact-icon mb-3"><i class="bi bi-mortarboard-fill"></i></div>
            <h5 class="fw-bold">Smart Learning &amp; Assessment</h5>
            <p class="text-secondary mb-2">We provide:</p>
            <ul class="text-secondary small mb-2 ps-3">
              <li>Mock interviews</li>
              <li>Technical &amp; aptitude MCQs</li>
              <li>Level-based progression (1–100)</li>
            </ul>
            <p class="text-secondary small mb-0">As users improve, they automatically unlock higher difficulty questions, helping them grow step by step.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-surface p-4 rounded-4 shadow-sm h-100 border-0 border-start border-5 border-warning">
            <div class="contact-icon mb-3"><i class="bi bi-pencil-square"></i></div>
            <h5 class="fw-bold">Open Blog Community</h5>
            <p class="text-secondary mb-2">Anyone — candidates or HRs — can:</p>
            <ul class="text-secondary small mb-2 ps-3">
              <li>Share experiences</li>
              <li>Post insights about the job market</li>
              <li>Help others navigate career challenges</li>
            </ul>
            <p class="text-secondary small mb-0">It's a community-driven knowledge hub, completely free.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Our Plans --}}
  <section class="py-5 contact-muted-section">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Our plans</h2>
        <p class="text-secondary">Flexible options for companies and candidates at every stage.</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-6">
          <div class="contact-card p-4 h-100">
            <h4 class="fw-bold mb-4"><i class="bi bi-building text-primary me-2"></i>For Companies</h4>
            <ul class="list-unstyled mb-0">
              <li class="d-flex justify-content-between align-items-start py-3 border-bottom">
                <div>
                  <strong>Standard</strong>
                  <span class="badge bg-success bg-opacity-10 text-success ms-2">Free</span>
                  <p class="text-secondary small mb-0 mt-1">Basic access</p>
                </div>
              </li>
              <li class="d-flex justify-content-between align-items-start py-3 border-bottom">
                <div>
                  <strong>Premium</strong>
                  <span class="text-primary fw-semibold ms-2">₹50/month</span>
                  <p class="text-secondary small mb-0 mt-1">Enhanced hiring tools</p>
                </div>
              </li>
              <li class="d-flex justify-content-between align-items-start py-3">
                <div>
                  <strong>Enterprise</strong>
                  <span class="text-primary fw-semibold ms-2">₹100/month</span>
                  <p class="text-secondary small mb-0 mt-1">Advanced hiring &amp; filtering</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-card p-4 h-100">
            <h4 class="fw-bold mb-4"><i class="bi bi-person-badge text-primary me-2"></i>For Candidates</h4>
            <ul class="list-unstyled mb-0">
              <li class="d-flex justify-content-between align-items-start py-3 border-bottom">
                <div>
                  <strong>Basic</strong>
                  <span class="badge bg-success bg-opacity-10 text-success ms-2">Free</span>
                  <p class="text-secondary small mb-0 mt-1">Core features</p>
                </div>
              </li>
              <li class="d-flex justify-content-between align-items-start py-3 border-bottom">
                <div>
                  <strong>Pro</strong>
                  <span class="text-primary fw-semibold ms-2">₹20/month</span>
                  <p class="text-secondary small mb-0 mt-1">Better resume insights</p>
                </div>
              </li>
              <li class="d-flex justify-content-between align-items-start py-3">
                <div>
                  <strong>Legend</strong>
                  <span class="text-primary fw-semibold ms-2">₹50/month</span>
                  <p class="text-secondary small mb-0 mt-1">Full ATS access &amp; advanced tools</p>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Our Values --}}
  <section class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Our values</h2>
        <p class="text-secondary">The principles behind every feature we build.</p>
      </div>
      <div class="row g-4">
        <div class="col-md-4 text-center">
          <div class="contact-icon mx-auto"><i class="bi bi-shield-lock-fill"></i></div>
          <h5 class="fw-bold">Trust First</h5>
          <p class="text-secondary">We focus on reducing fake jobs and building a reliable platform.</p>
        </div>
        <div class="col-md-4 text-center">
          <div class="contact-icon mx-auto"><i class="bi bi-eye-fill"></i></div>
          <h5 class="fw-bold">Transparency</h5>
          <p class="text-secondary">Clear processes for both candidates and companies.</p>
        </div>
        <div class="col-md-4 text-center">
          <div class="contact-icon mx-auto"><i class="bi bi-graph-up-arrow"></i></div>
          <h5 class="fw-bold">Growth Focused</h5>
          <p class="text-secondary">Helping users improve skills, resumes, and career direction.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- Our Journey --}}
  <section class="py-5 contact-muted-section">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Our journey</h2>
        <p class="text-secondary">From a mission to fix hiring — to a full career platform.</p>
      </div>
      <div class="row g-0 position-relative">
        <div class="col-md-4 text-center p-3">
          <div class="contact-surface rounded-3 p-3 shadow-sm h-100">
            <div class="badge-ai d-inline-block mb-2">2024</div>
            <h5 class="fw-bold">The Beginning</h5>
            <p class="small text-secondary mb-0">Launched with a mission to reduce fake job listings.</p>
          </div>
        </div>
        <div class="col-md-4 text-center p-3">
          <div class="contact-surface rounded-3 p-3 shadow-sm h-100">
            <div class="badge-ai d-inline-block mb-2">2025</div>
            <h5 class="fw-bold">Platform Growth</h5>
            <p class="small text-secondary mb-0">Introduced ATS, mock interviews, and assessments.</p>
          </div>
        </div>
        <div class="col-md-4 text-center p-3">
          <div class="contact-surface rounded-3 p-3 shadow-sm h-100">
            <div class="badge-ai d-inline-block mb-2">Future</div>
            <h5 class="fw-bold">Smarter Hiring</h5>
            <p class="small text-secondary mb-0">Building AI-driven hiring and career guidance tools.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Team --}}
  <section class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <span class="badge-ai mb-3 d-inline-block"><i class="bi bi-people-fill me-1"></i> Meet the team</span>
        <h2 class="fw-bold">Our team</h2>
        <p class="text-secondary col-lg-7 mx-auto">The people behind Find My Naukri — building trust, tools, and opportunity for candidates and companies alike.</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-3 col-md-6">
          <div class="team-card contact-surface p-4 text-center h-100 shadow-sm">
            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 1.75rem; font-weight: 700;">RM</div>
            <h5 class="fw-bold mb-1">Rahul Mehta</h5>
            <p class="text-primary small fw-semibold mb-2">Founder &amp; CEO</p>
            <p class="text-secondary small mb-0">Leads vision and strategy to make hiring transparent and trustworthy for everyone.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="team-card contact-surface p-4 text-center h-100 shadow-sm">
            <div class="rounded-circle bg-info bg-opacity-10 text-info d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 1.75rem; font-weight: 700;">PS</div>
            <h5 class="fw-bold mb-1">Priya Sharma</h5>
            <p class="text-primary small fw-semibold mb-2">Chief Technology Officer</p>
            <p class="text-secondary small mb-0">Architects the platform — from ATS scoring to assessments and AI-driven career tools.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="team-card contact-surface p-4 text-center h-100 shadow-sm">
            <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 1.75rem; font-weight: 700;">AD</div>
            <h5 class="fw-bold mb-1">Arjun Desai</h5>
            <p class="text-primary small fw-semibold mb-2">Head of Product</p>
            <p class="text-secondary small mb-0">Shapes user experiences that help candidates grow and companies hire with confidence.</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="team-card contact-surface p-4 text-center h-100 shadow-sm">
            <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 1.75rem; font-weight: 700;">KN</div>
            <h5 class="fw-bold mb-1">Kavitha Nair</h5>
            <p class="text-primary small fw-semibold mb-2">Head of Operations</p>
            <p class="text-secondary small mb-0">Keeps verified listings, subscriptions, and support running smoothly at scale.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Final CTA --}}
  <section class="py-5 contact-community-section">
    <div class="container text-center py-4">
      <h2 class="fw-bold mb-3">Be part of a smarter hiring future</h2>
      <p class="lead mb-4 text-secondary">Whether you're hiring or job hunting, our platform gives you the tools, insights, and trust you need to succeed.</p>
      <div class="d-flex flex-wrap gap-3 justify-content-center">
        <a href="{{ route('register') }}" class="btn btn-primary-custom rounded-pill px-4">
          <i class="bi bi-rocket-takeoff me-2"></i>Start for Free
        </a>
        <a href="{{ url('/contact') }}" class="btn btn-outline-custom rounded-pill px-4">
          <i class="bi bi-chat-heart"></i> Contact Us
        </a>
      </div>
      <p class="mt-4 small text-secondary">
        <i class="bi bi-shield-check"></i> No hidden charges • Verified opportunities • Built for real growth
      </p>
    </div>
  </section>
</main>
@endsection
