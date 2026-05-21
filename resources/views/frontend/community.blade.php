@extends('frontend.layouts.app')

@section('title', 'CareerElevate | Community Hub')


@section('content')
<main>
  <!-- Community Hero Section -->
  <section class="community-hero">
    <div class="container text-center" data-aos="fade-up">
      <i class="bi bi-people-fill fs-1 mb-3 d-inline-block"></i>
      <h1 class="display-5 fw-bold">Join Our Thriving Community</h1>
      <p class="lead px-md-5 mx-md-5">
        Connect with professionals, get instant mentorship, job referrals,
        and daily insights on WhatsApp. Choose your niche & grow together.
      </p>
      <div class="d-flex flex-wrap gap-3 justify-content-center mt-4">
        <span class="badge bg-light text-dark px-3 py-2 rounded-pill"
          ><i class="bi bi-chat-dots-fill me-1 text-primary"></i> 12k+
          active members</span
        >
        <span class="badge bg-light text-dark px-3 py-2 rounded-pill"
          ><i class="bi bi-globe me-1 text-primary"></i> 40+ countries</span
        >
        <span class="badge bg-light text-dark px-3 py-2 rounded-pill"
          ><i class="bi bi-whatsapp me-1 text-success"></i> WhatsApp
          groups</span
        >
      </div>
    </div>
  </section>

  <!-- Categories Section with WhatsApp groups -->
  <div class="container my-5" id="categories">
    <div class="text-center mb-5" data-aos="fade-up">
      <span class="feature-badge d-inline-block mb-3"
        ><i class="bi bi-grid-3x3-gap-fill me-1"></i> Explore
        Categories</span
      >
      <h2 class="display-6 fw-semibold">Find Your Tribe</h2>
      <p class="text-secondary-emphasis col-lg-7 mx-auto">
        Join specialized WhatsApp groups tailored to your career stage,
        domain, and goals. Engage daily, ask doubts, and stay updated.
      </p>
    </div>

    <div class="row g-4" id="categoryContainer">
      <!-- Category 1: Tech & Engineering -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="50">
        <div class="category-card">
          <div class="card-header-icon">
            <i class="bi bi-code-square category-icon"></i>
            <h4 class="mt-2 mb-0">Tech & Engineering</h4>
          </div>
          <div class="card-body">
            <p class="card-text">
              Discuss software dev, data science, system design & coding
              challenges. Weekly DSA sessions & referral sharing.
            </p>
            <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
              <span class="member-count"
                ><i class="bi bi-people"></i> 3,240+ members</span
              >
              <span class="text-success"
                ><i class="bi bi-whatsapp"></i> Active daily</span
              >
            </div>
            <div class="d-grid gap-2 mt-4">
              <button
                class="btn btn-whatsapp join-wa-group"
                data-group-name="Tech & Engineering"
                data-wa-link="https://chat.whatsapp.com/yourtechgroupinvite"
              >
                <i class="bi bi-whatsapp me-2"></i> Join WhatsApp Group
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Category 2: Marketing & Growth -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="category-card">
          <div class="card-header-icon">
            <i class="bi bi-megaphone-fill category-icon"></i>
            <h4 class="mt-2 mb-0">Marketing & Growth</h4>
          </div>
          <div class="card-body">
            <p class="card-text">
              SEO, content strategy, performance marketing, branding, and
              growth hacks. Share case studies & job leads.
            </p>
            <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
              <span class="member-count"
                ><i class="bi bi-people"></i> 1,980+ members</span
              >
              <span class="text-success"
                ><i class="bi bi-whatsapp"></i> Global chats</span
              >
            </div>
            <div class="d-grid gap-2 mt-4">
              <button
                class="btn btn-whatsapp join-wa-group"
                data-group-name="Marketing & Growth"
                data-wa-link="https://chat.whatsapp.com/yourmarketinggroupinvite"
              >
                <i class="bi bi-whatsapp me-2"></i> Join WhatsApp Group
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Category 3: Product & Design -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="150">
        <div class="category-card">
          <div class="card-header-icon">
            <i class="bi bi-brush-fill category-icon"></i>
            <h4 class="mt-2 mb-0">Product & Design</h4>
          </div>
          <div class="card-body">
            <p class="card-text">
              UX/UI, product management, design thinking, portfolio reviews
              & product strategy discussions.
            </p>
            <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
              <span class="member-count"
                ><i class="bi bi-people"></i> 1,560+ members</span
              >
              <span class="text-success"
                ><i class="bi bi-whatsapp"></i> Design critiques</span
              >
            </div>
            <div class="d-grid gap-2 mt-4">
              <button
                class="btn btn-whatsapp join-wa-group"
                data-group-name="Product & Design"
                data-wa-link="https://chat.whatsapp.com/yourproductgroupinvite"
              >
                <i class="bi bi-whatsapp me-2"></i> Join WhatsApp Group
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Category 4: Finance & Consulting -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="50">
        <div class="category-card">
          <div class="card-header-icon">
            <i class="bi bi-graph-up category-icon"></i>
            <h4 class="mt-2 mb-0">Finance & Consulting</h4>
          </div>
          <div class="card-body">
            <p class="card-text">
              Investment banking, financial modeling, FP&A, strategy
              consulting, CFA prep & career progression.
            </p>
            <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
              <span class="member-count"
                ><i class="bi bi-people"></i> 1,280+ members</span
              >
              <span class="text-success"
                ><i class="bi bi-whatsapp"></i> Case prep</span
              >
            </div>
            <div class="d-grid gap-2 mt-4">
              <button
                class="btn btn-whatsapp join-wa-group"
                data-group-name="Finance & Consulting"
                data-wa-link="https://chat.whatsapp.com/yourfinancegroupinvite"
              >
                <i class="bi bi-whatsapp me-2"></i> Join WhatsApp Group
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Category 5: HR & Career Development -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="category-card">
          <div class="card-header-icon">
            <i class="bi bi-person-badge category-icon"></i>
            <h4 class="mt-2 mb-0">HR & Career Dev</h4>
          </div>
          <div class="card-body">
            <p class="card-text">
              HR professionals, talent acquisition, resume reviews,
              interview hacks & career coaching meetups.
            </p>
            <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
              <span class="member-count"
                ><i class="bi bi-people"></i> 2,100+ members</span
              >
              <span class="text-success"
                ><i class="bi bi-whatsapp"></i> Daily tips</span
              >
            </div>
            <div class="d-grid gap-2 mt-4">
              <button
                class="btn btn-whatsapp join-wa-group"
                data-group-name="HR & Career Dev"
                data-wa-link="https://chat.whatsapp.com/yourhrgroupinvite"
              >
                <i class="bi bi-whatsapp me-2"></i> Join WhatsApp Group
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Category 6: AI & Future Skills -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="150">
        <div class="category-card">
          <div class="card-header-icon">
            <i class="bi bi-robot category-icon"></i>
            <h4 class="mt-2 mb-0">AI & Future Skills</h4>
          </div>
          <div class="card-body">
            <p class="card-text">
              Prompt engineering, AI tools, ChatGPT, automation trends,
              no-code, and future-of-work discussions.
            </p>
            <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
              <span class="member-count"
                ><i class="bi bi-people"></i> 1,850+ members</span
              >
              <span class="text-success"
                ><i class="bi bi-whatsapp"></i> AI weekly news</span
              >
            </div>
            <div class="d-grid gap-2 mt-4">
              <button
                class="btn btn-whatsapp join-wa-group"
                data-group-name="AI & Future Skills"
                data-wa-link="https://chat.whatsapp.com/yourfutureaiinvite"
              >
                <i class="bi bi-whatsapp me-2"></i> Join WhatsApp Group
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- How it works + additional benefits -->
  <section id="how-it-works" class="container my-5 py-4">
    <div class="row align-items-center g-5" data-aos="fade-up">
      <div class="col-lg-6">
        <span class="feature-badge"
          ><i class="bi bi-info-circle"></i> Why join us</span
        >
        <h2 class="display-6 fw-semibold mt-2">Connect, Learn, & Grow</h2>
        <p class="lead text-secondary">
          Our WhatsApp communities are moderated, spam-free, and
          career-focused. Get direct access to industry peers, job postings,
          and exclusive resources.
        </p>
        <div class="mt-4 d-flex flex-column gap-3">
          <div class="d-flex gap-3 align-items-center">
            <i class="bi bi-check-circle-fill text-success fs-3"></i>
            <div>
              <strong>Curated Networking</strong><br />Connect with
              like-minded professionals in your exact domain.
            </div>
          </div>
          <div class="d-flex gap-3 align-items-center">
            <i class="bi bi-chat-quote-fill text-primary fs-3"></i>
            <div>
              <strong>Daily Doubt Solving</strong><br />Ask questions, get
              answers from experienced mentors.
            </div>
          </div>
          <div class="d-flex gap-3 align-items-center">
            <i class="bi bi-megaphone-fill text-warning fs-3"></i>
            <div>
              <strong>Exclusive Job Alerts</strong><br />Referrals & hidden
              job market opportunities.
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="bg-body-tertiary p-4 rounded-4 shadow-sm">
          <h4 class="mb-3">
            <i class="bi bi-whatsapp text-success me-2"></i> Upcoming
            community events
          </h4>
          <ul class="list-unstyled">
            <li class="mb-3 discussion-item p-2 rounded">
              <i class="bi bi-calendar-event me-2 text-primary"></i>
              <strong>Mar 30:</strong> "ATS Resume Workshop" on WhatsApp
              live
            </li>
            <li class="mb-3 discussion-item p-2 rounded">
              <i class="bi bi-calendar-event me-2 text-primary"></i>
              <strong>Apr 5:</strong> "Tech Career AMA with Senior Engineer"
            </li>
            <li class="mb-3 discussion-item p-2 rounded">
              <i class="bi bi-calendar-event me-2 text-primary"></i>
              <strong>Apr 12:</strong> "Marketing Trends 2026" group
              discussion
            </li>
          </ul>
          <div class="alert alert-primary mt-3 rounded-3">
            <i class="bi bi-star-fill me-1"></i> First 100 new members this
            week get a free "Resume Masterclass" PDF.
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to action: personalized group suggestion -->
  <div class="container mb-5" data-aos="fade-up">
    <div
      class="bg-gradient rounded-4 p-4 p-md-5 text-center"
      style="background: linear-gradient(120deg, #0d6efd10, #0a58ca10); border: 1px solid rgba(13, 110, 253, 0.2);"
    >
      <h3 class="fw-bold">
        Don't see your category? <i class="bi bi-emoji-sunglasses"></i>
      </h3>
      <p class="mb-3">
        We're launching more WhatsApp groups each week. Request a new
        community and we'll invite you!
      </p>
      <button class="btn btn-outline-primary rounded-pill px-4" id="requestGroupBtn">
        <i class="bi bi-envelope-paper"></i> Request New Group
      </button>
    </div>
  </div>
</main>
@endsection


