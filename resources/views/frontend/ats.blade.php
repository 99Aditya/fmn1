@extends('frontend.layouts.app')

@section('title', 'CareerElevate | ATS Insight Hub - Smart Resume Analysis')

@section('content')
<main>
  <!-- 1. Top Banner Section -->
  <section class="ats-hero">
    <div class="container text-center" data-aos="fade-up">
      <span class="hero-badge mb-3"
        ><i class="bi bi-robot me-1"></i> AI-Powered ATS Intelligence</span
      >
      <h1 class="display-4 fw-bold mt-2">Decode Any ATS System</h1>
      <p class="lead mx-auto" style="max-width: 700px">
        Stop getting ghosted. Our advanced ATS tool analyzes your resume
        like a recruiter & gives actionable insights to beat automated
        filters.
      </p>
      <div class="mt-4 d-flex flex-wrap gap-3 justify-content-center">
        <a href="#upload-ats" class="btn btn-light btn-lg rounded-pill px-4"
          ><i class="bi bi-cloud-upload"></i> Analyze Resume Now</a
        >
        <a
          href="#stats"
          class="btn btn-outline-light btn-lg rounded-pill px-4"
          ><i class="bi bi-graph-up"></i> See Impact</a
        >
      </div>
    </div>
  </section>

  <!-- 2. How our ATS tool is better than others -->
  <div class="container my-5 py-4" id="better-tool">
    <div class="text-center mb-5" data-aos="fade-up">
      <span
        class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-pill"
        ><i class="bi bi-trophy-fill"></i> Why we lead</span
      >
      <h2 class="display-6 fw-semibold mt-2">
        Smarter, Faster, More Accurate
      </h2>
      <p class="text-secondary-emphasis col-lg-7 mx-auto">
        Unlike basic checkers, our AI simulates real applicant tracking
        systems from top companies.
      </p>
    </div>
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="50">
        <div class="comparison-card card h-100 border-0 shadow-sm p-4">
          <i class="bi bi-lightning-charge-fill fs-1 text-primary"></i>
          <h4 class="mt-3">Real-time Keyword Mapping</h4>
          <p>
            Compares your resume against 10k+ job descriptions to recommend
            precise keywords that modern ATS prioritize.
          </p>
          <div class="mt-2">
            <i class="bi bi-check-lg text-success"></i>
            <span class="feature-check">Industry-specific lexicon</span>
          </div>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="comparison-card card h-100 border-0 shadow-sm p-4">
          <i class="bi bi-diagram-3-fill fs-1 text-primary"></i>
          <h4 class="mt-3">Format Resilience Score</h4>
          <p>
            Detects complex tables, graphics, or columns that confuse ATS
            parsers. Gives format compatibility rating.
          </p>
          <div class="mt-2">
            <i class="bi bi-check-lg text-success"></i>
            <span class="feature-check">PDF/DOCX deep scan</span>
          </div>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
        <div class="comparison-card card h-100 border-0 shadow-sm p-4">
          <i class="bi bi-shield-check fs-1 text-primary"></i>
          <h4 class="mt-3">Actionable Improvement Plan</h4>
          <p>
            Instead of just a score, we deliver step-by-step fixes:
            headings, bullet strength, and missing sections.
          </p>
          <div class="mt-2">
            <i class="bi bi-check-lg text-success"></i>
            <span class="feature-check">Tailored suggestions</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. Why ATS Important -->
  <section id="why-ats" class="container my-5 py-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-aos="fade-right">
        <span
          class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2"
          >⚠️ The Reality</span
        >
        <h2 class="display-6 fw-semibold">
          75% of Resumes Are Rejected by ATS Before a Human Sees Them
        </h2>
        <p class="lead mt-3">
          Applicant Tracking Systems filter candidates based on formatting,
          keywords, and relevance. If your resume isn't optimized, you lose
          opportunities.
        </p>
        <div class="mt-4 d-flex flex-column gap-3">
          <div class="d-flex gap-3">
            <i class="bi bi-file-earmark-x-fill text-danger fs-4"></i>
            <span
              ><strong>Over 98%</strong> of Fortune 500 companies rely on
              ATS.</span
            >
          </div>
          <div class="d-flex gap-3">
            <i class="bi bi-hourglass-split text-warning fs-4"></i>
            <span
              >Recruiters spend only <strong>6-8 seconds</strong> on a
              resume that passes ATS.</span
            >
          </div>
          <div class="d-flex gap-3">
            <i class="bi bi-graph-up text-success fs-4"></i>
            <span
              >Optimized resumes get
              <strong>3x more interviews</strong>.</span
            >
          </div>
        </div>
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <div class="row g-3">
          <div class="col-6">
            <div class="importance-icon mx-auto">
              <i class="bi bi-funnel-fill fs-2 text-primary"></i>
            </div>
            <h5 class="text-center">First Filter</h5>
            <p class="small text-center">
              Keyword match & relevancy ranking
            </p>
          </div>
          <div class="col-6">
            <div class="importance-icon mx-auto">
              <i class="bi bi-layout-text-window"></i>
            </div>
            <h5 class="text-center">Parsing Accuracy</h5>
            <p class="small text-center">Tables/columns break parsing</p>
          </div>
          <div class="col-6">
            <div class="importance-icon mx-auto">
              <i class="bi bi-file-check-fill"></i>
            </div>
            <h5 class="text-center">Standardized Scoring</h5>
            <p class="small text-center">Match rate determines shortlist</p>
          </div>
          <div class="col-6">
            <div class="importance-icon mx-auto">
              <i class="bi bi-robot"></i>
            </div>
            <h5 class="text-center">AI-based Ranking</h5>
            <p class="small text-center">Semantic analysis of skills</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 4. How ATS works (step by step) -->
  <section
    id="how-ats-works"
    class="container my-5 py-4 bg-body-tertiary rounded-4 p-4"
  >
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="display-6 fw-semibold">
        <i class="bi bi-gear-fill me-2"></i> How ATS Actually Works
      </h2>
      <p class="text-secondary-emphasis col-md-8 mx-auto">
        Understand the journey of your resume inside an Applicant Tracking
        System
      </p>
    </div>
    <div class="row g-4 justify-content-center">
      <div
        class="col-md-3 text-center"
        data-aos="fade-up"
        data-aos-delay="0"
      >
        <div class="step-circle mx-auto">1</div>
        <h5>Submission & Storage</h5>
        <p class="small">
          Your resume is uploaded into a candidate database, parsed into
          text fields.
        </p>
      </div>
      <div
        class="col-md-3 text-center"
        data-aos="fade-up"
        data-aos-delay="100"
      >
        <div class="step-circle mx-auto">2</div>
        <h5>Keyword Parsing</h5>
        <p class="small">
          ATS extracts skills, education, experience, matches against job
          description.
        </p>
      </div>
      <div
        class="col-md-3 text-center"
        data-aos="fade-up"
        data-aos-delay="200"
      >
        <div class="step-circle mx-auto">3</div>
        <h5>Scoring Algorithm</h5>
        <p class="small">
          Each resume gets a relevance score (0-100%). Higher scores
          advance.
        </p>
      </div>
      <div
        class="col-md-3 text-center"
        data-aos="fade-up"
        data-aos-delay="300"
      >
        <div class="step-circle mx-auto">4</div>
        <h5>Recruiter Review</h5>
        <p class="small">
          Only top 20-30% of scored resumes reach human eyes.
        </p>
      </div>
    </div>
    <div
      class="alert alert-primary mt-5 text-center rounded-4"
      role="alert"
    >
      <i class="bi bi-lightbulb-fill me-2"></i> Our ATS tool
      reverse-engineers these steps to give you a competitive edge.
    </div>
  </section>

  <!-- 5. Upload ATS Resume + Insight Section -->
  <section id="upload-ats" class="container my-5 py-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-6" data-aos="fade-right">
        <span
          class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mb-3"
          ><i class="bi bi-file-earmark-richtext"></i> Instant ATS
          Analysis</span
        >
        <h2 class="display-6 fw-semibold">
          Upload Your Resume & Get Deep ATS Insights
        </h2>
        <p class="lead">
          Our AI-powered engine simulates top ATS platforms (Greenhouse,
          Lever, Workday) and generates a custom improvement roadmap.
        </p>
        <ul class="list-unstyled mt-4">
          <li class="mb-2">
            <i class="bi bi-check-circle-fill text-primary me-2"></i> ATS
            compatibility score (0-100)
          </li>
          <li class="mb-2">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Keyword optimization suggestions
          </li>
          <li class="mb-2">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Formatting + parsing health
          </li>
          <li class="mb-2">
            <i class="bi bi-check-circle-fill text-primary me-2"></i>
            Section-wise recommendations
          </li>
        </ul>
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <form method="POST" action="{{ route('ats.upload') }}" enctype="multipart/form-data">
          @csrf
          <div class="upload-zone text-center" id="uploadZoneAts">
            <i class="bi bi-cloud-upload-fill fs-1 text-primary"></i>
            <h5 class="mt-3">Drag & Drop or Click to Upload</h5>
            <p class="text-muted small">Supports PDF, DOCX, TXT (Max 5MB)</p>
            <input
              type="file"
              id="atsResumeInput"
              name="resume"
              accept=".pdf,.docx,.txt,.doc"
              style="display: none"
            />
            <button
              type="button"
              class="btn btn-primary rounded-pill px-4 mt-2"
              id="uploadBtnAts"
            >
              <i class="bi bi-upload"></i> Select Resume
            </button>
              <button type="submit" id="submitAts" class="d-none">Submit</button>
          </div>
            @if ($errors->any())
              <div class="mt-3 alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            @if (session('message'))
              <div class="mt-3 alert alert-info">{{ session('message') }}</div>
            @endif
        </form>
        <div id="atsInsightResult" class="mt-4 d-none">
          <div class="insight-card p-4 bg-body-tertiary">
            <div class="d-flex align-items-center gap-2 mb-3">
              <i class="bi bi-gem fs-4 text-primary"></i>
              <h5 class="mb-0">🔍 ATS DeepScan Report</h5>
            </div>
            <div id="atsDetailedFeedback"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- 8. Numbers for showing impact (Counters + Resume generated) -->
  <section id="stats" class="container my-5 py-4">
    <div class="text-center mb-5" data-aos="fade-up">
      <span
        class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-pill"
        ><i class="bi bi-bar-chart-steps"></i> Our Impact</span
      >
      <h2 class="display-6 fw-semibold mt-2">
        Trusted by Thousands Globally
      </h2>
      <p class="text-secondary-emphasis">
        Real numbers that reflect how we’re transforming careers
      </p>
    </div>
    <div class="row g-4 justify-content-center">
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="0">
        <div class="stat-box">
          <i class="bi bi-people-fill fs-2 text-primary mb-2 d-block"></i>
          <div class="stat-number">
            <span class="counter" data-target="28750">0</span>+
          </div>
          <p class="fw-semibold mt-2 mb-0">Job Seekers Helped</p>
          <small class="text-muted">Global community</small>
        </div>
      </div>
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="100">
        <div class="stat-box">
          <i
            class="bi bi-file-text-fill fs-2 text-primary mb-2 d-block"
          ></i>
          <div class="stat-number">
            <span class="counter" data-target="15840">0</span>+
          </div>
          <p class="fw-semibold mt-2 mb-0">Resumes Analyzed</p>
          <small class="text-muted">via ATS tool</small>
        </div>
      </div>
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="200">
        <div class="stat-box">
          <i class="bi bi-trophy-fill fs-2 text-primary mb-2 d-block"></i>
          <div class="stat-number">
            <span class="counter" data-target="96">0</span>%
          </div>
          <p class="fw-semibold mt-2 mb-0">Average ATS Boost</p>
          <small class="text-muted">After optimization</small>
        </div>
      </div>
      <div class="col-md-3 col-6" data-aos="zoom-in" data-aos-delay="300">
        <div class="stat-box">
          <i
            class="bi bi-buildings-fill fs-2 text-primary mb-2 d-block"
          ></i>
          <div class="stat-number">
            <span class="counter" data-target="1250">0</span>+
          </div>
          <p class="fw-semibold mt-2 mb-0">Companies Hired From</p>
          <small class="text-muted">Top-tier firms</small>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
 
</main>
<script>
  (function(){
    var btn = document.getElementById('uploadBtnAts');
    var input = document.getElementById('atsResumeInput');
    var submit = document.getElementById('submitAts');
    if (btn && input) {
      btn.addEventListener('click', function(){ input.click(); });
      input.addEventListener('change', function(){ if (input.files && input.files.length) { submit.click(); } });
    }
  })();
</script>
@endsection
