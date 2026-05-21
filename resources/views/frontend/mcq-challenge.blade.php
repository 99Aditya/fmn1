@extends('frontend.layouts.app')

@section('title', 'CareerElevate | MCQ Mastery - Test Your Skills, Earn Certificates')

@section('content')
<main>
  <!-- 1. Banner Section -->
  <section class="mcq-hero">
    <div class="container text-center" data-aos="fade-up">
      <span class="hero-badge mb-3"
        ><i class="bi bi-patch-check-fill me-1"></i> Skill Certification
        Hub</span
      >
      <h1 class="display-4 fw-bold mt-2">MCQ Challenge Platform</h1>
      <p class="lead mx-auto mcq-hero-copy">
        Test your expertise across 12+ technologies. Choose difficulty, earn
        certificates, and validate your skills.
      </p>
      <div class="mt-4 d-flex flex-wrap gap-3 justify-content-center">
        <span class="badge bg-light text-dark px-3 py-2"
          ><i class="bi bi-database"></i> 2000+ MCQs</span
        >
        <span class="badge bg-light text-dark px-3 py-2"
          ><i class="bi bi-award"></i> Certificates Available</span
        >
        <span class="badge bg-light text-dark px-3 py-2"
          ><i class="bi bi-graph-up"></i> 3 Difficulty Levels</span
        >
      </div>
    </div>
  </section>

  <!-- 2. Different Categories Section (JS, MERN, Full Stack, PHP, Java, Laravel, Python, CSS, UI, DevOps) -->
  <div id="categories" class="container my-5 py-4">
    <div class="text-center mb-5" data-aos="fade-up">
      <span
        class="badge bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-pill"
        ><i class="bi bi-grid-3x3-gap-fill"></i> Choose Your Domain</span
      >
      <h2 class="display-6 fw-semibold mt-2">MCQ Categories</h2>
      <p class="text-secondary-emphasis col-lg-7 mx-auto">
        Click any category to customize your quiz — pick certificate
        preference & difficulty level
      </p>
    </div>
    <div class="row g-4">
      <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="0">
        <div
          class="category-card card p-4 text-center"
          data-category="JavaScript"
        >
          <div class="category-icon mx-auto">
            <i class="bi bi-filetype-js text-warning"></i>
          </div>
          <h4 class="mt-2">JavaScript</h4>
          <p class="small text-muted">ES6, DOM, Async, Closures</p>
          <span class="badge bg-secondary">120+ Questions</span>
        </div>
      </div>
      <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="50">
        <div
          class="category-card card p-4 text-center"
          data-category="MERN"
        >
          <div class="category-icon mx-auto">
            <i class="bi bi-stack text-primary"></i>
          </div>
          <h4 class="mt-2">MERN Stack</h4>
          <p class="small text-muted">MongoDB, Express, React, Node</p>
          <span class="badge bg-secondary">150+ Questions</span>
        </div>
      </div>
      <div
        class="col-md-6 col-lg-3"
        data-aos="zoom-in"
        data-aos-delay="100"
      >
        <div
          class="category-card card p-4 text-center"
          data-category="Full Stack"
        >
          <div class="category-icon mx-auto">
            <i class="bi bi-braces text-success"></i>
          </div>
          <h4 class="mt-2">Full Stack</h4>
          <p class="small text-muted">Frontend + Backend Integration</p>
          <span class="badge bg-secondary">180+ Questions</span>
        </div>
      </div>
      <div
        class="col-md-6 col-lg-3"
        data-aos="zoom-in"
        data-aos-delay="150"
      >
        <div
          class="category-card card p-4 text-center"
          data-category="PHP"
        >
          <div class="category-icon mx-auto">
            <i class="bi bi-filetype-php text-info"></i>
          </div>
          <h4 class="mt-2">PHP</h4>
          <p class="small text-muted">OOP, Frameworks (Laravel basics)</p>
          <span class="badge bg-secondary">100+ Questions</span>
        </div>
      </div>
      <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="0">
        <div
          class="category-card card p-4 text-center"
          data-category="Java"
        >
          <div class="category-icon mx-auto">
            <i class="bi bi-filetype-java text-danger"></i>
          </div>
          <h4 class="mt-2">Java</h4>
          <p class="small text-muted">Core Java, Collections, Multithreading</p>
          <span class="badge bg-secondary">130+ Questions</span>
        </div>
      </div>
      <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="50">
        <div
          class="category-card card p-4 text-center"
          data-category="Laravel"
        >
          <div class="category-icon mx-auto">
            <i class="bi bi-layers-fill text-danger"></i>
          </div>
          <h4 class="mt-2">Laravel</h4>
          <p class="small text-muted">Eloquent, MVC, Routing, Artisan</p>
          <span class="badge bg-secondary">110+ Questions</span>
        </div>
      </div>
      <div
        class="col-md-6 col-lg-3"
        data-aos="zoom-in"
        data-aos-delay="100"
      >
        <div
          class="category-card card p-4 text-center"
          data-category="Python"
        >
          <div class="category-icon mx-auto">
            <i class="bi bi-filetype-py text-primary"></i>
          </div>
          <h4 class="mt-2">Python</h4>
          <p class="small text-muted">Data types, OOP, Libraries, Decorators</p>
          <span class="badge bg-secondary">140+ Questions</span>
        </div>
      </div>
      <div
        class="col-md-6 col-lg-3"
        data-aos="zoom-in"
        data-aos-delay="150"
      >
        <div
          class="category-card card p-4 text-center"
          data-category="CSS"
        >
          <div class="category-icon mx-auto">
            <i class="bi bi-filetype-css text-info"></i>
          </div>
          <h4 class="mt-2">CSS</h4>
          <p class="small text-muted">Flexbox, Grid, Animations, Responsive</p>
          <span class="badge bg-secondary">90+ Questions</span>
        </div>
      </div>
      <div
        class="col-md-6 col-lg-3"
        data-aos="zoom-in"
        data-aos-delay="200"
      >
        <div
          class="category-card card p-4 text-center"
          data-category="UI/UX Design"
        >
          <div class="category-icon mx-auto">
            <i class="bi bi-palette-fill text-purple"></i>
          </div>
          <h4 class="mt-2">UI/UX Design</h4>
          <p class="small text-muted">Wireframing, Figma, Usability Principles</p>
          <span class="badge bg-secondary">85+ Questions</span>
        </div>
      </div>
      <div
        class="col-md-6 col-lg-3"
        data-aos="zoom-in"
        data-aos-delay="250"
      >
        <div
          class="category-card card p-4 text-center"
          data-category="DevOps"
        >
          <div class="category-icon mx-auto">
            <i class="bi bi-cloud-arrow-up-fill text-success"></i>
          </div>
          <h4 class="mt-2">DevOps</h4>
          <p class="small text-muted">CI/CD, Docker, Kubernetes, AWS basics</p>
          <span class="badge bg-secondary">100+ Questions</span>
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
        <i class="bi bi-chat-quote-fill text-primary me-2"></i>What Our
        Users Say
      </h2>
      <p>
        Join 15,000+ developers who've tested their skills & earned
        certificates
      </p>
    </div>
    <div class="row g-4">
      <div class="col-md-4" data-aos="fade-right" data-aos-delay="0">
        <div class="review-card p-4 h-100">
          <div class="rating-stars mb-2">★★★★★</div>
          <p class="fst-italic">
            “The JavaScript MCQs were spot-on! I earned a certificate and it
            helped me showcase my skills on LinkedIn. Got shortlisted for an
            interview.”
          </p>
          <div class="d-flex align-items-center mt-3">
            <img
              src="https://randomuser.me/api/portraits/men/46.jpg"
              width="45"
              height="45"
              class="rounded-circle me-3"
            />
            <div>
              <strong>Rahul Verma</strong><br /><small>Frontend Dev</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="review-card p-4 h-100">
          <div class="rating-stars mb-2">★★★★★</div>
          <p class="fst-italic">
            “Full Stack MCQ gave me confidence before my interview. The
            difficulty levels are well-structured. I also loved the MERN
            category questions.”
          </p>
          <div class="d-flex align-items-center mt-3">
            <img
              src="https://randomuser.me/api/portraits/women/28.jpg"
              width="45"
              height="45"
              class="rounded-circle me-3"
            />
            <div>
              <strong>Neha Sharma</strong><br /><small>Full Stack Developer</small>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4" data-aos="fade-left" data-aos-delay="200">
        <div class="review-card p-4 h-100">
          <div class="rating-stars mb-2">★★★★★</div>
          <p class="fst-italic">
            “DevOps category was extensive. I challenged myself with
            advanced level and earned a certificate. Highly recommended for
            placement prep!”
          </p>
          <div class="d-flex align-items-center mt-3">
            <img
              src="https://randomuser.me/api/portraits/men/91.jpg"
              width="45"
              height="45"
              class="rounded-circle me-3"
            />
            <div>
              <strong>Aditya Joshi</strong><br /><small>Cloud Engineer</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Quiz Setup Modal -->
  <div
    class="modal fade"
    id="quizSetupModal"
    tabindex="-1"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">
            <i class="bi bi-trophy-fill me-2"></i>
            <span id="modalCategoryTitle">Category</span> Setup
          </h5>
          <button
            type="button"
            class="btn-close btn-close-white"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <p class="mb-3">
            Customize your MCQ experience. Earn a shareable certificate on
            completion!
          </p>

          <label class="fw-semibold mb-2"
            ><i class="bi bi-patch-check"></i> Certificate Preference</label
          >
          <div class="row g-3 mb-4">
            <div class="col-6">
              <div class="cert-option text-center" id="certYesOption">
                <i class="bi bi-award-fill fs-2 text-primary"></i>
                <div class="mt-2 fw-bold">With Certificate</div>
                <small class="text-muted">Paid / Premium</small>
              </div>
            </div>
            <div class="col-6">
              <div class="cert-option text-center" id="certNoOption">
                <i class="bi bi-file-text fs-2 text-secondary"></i>
                <div class="mt-2 fw-bold">Without Certificate</div>
                <small class="text-muted">Free Practice</small>
              </div>
            </div>
          </div>

          <label class="fw-semibold mb-2"
            ><i class="bi bi-bar-chart-steps"></i> Difficulty Level</label
          >
          <div class="d-flex gap-3 mb-4 flex-wrap">
            <div class="level-badge flex-grow-1" data-level="beginner">
              🌱 Beginner
            </div>
            <div class="level-badge flex-grow-1" data-level="intermediate">
              ⚡ Intermediate
            </div>
            <div class="level-badge flex-grow-1" data-level="advanced">
              🚀 Advanced
            </div>
          </div>

          <div class="alert alert-info small">
            <i class="bi bi-info-circle"></i>
            <span id="infoText"
              >Certificate includes your name, score, and unique verification
              ID. Perfect for LinkedIn.</span
            >
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
          </button>
          <button class="btn btn-primary" id="confirmQuizBtn">
            Start Quiz →
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- MCQ Quiz Modal -->
  <div class="modal fade" id="mcqQuizModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">
            <i class="bi bi-question-circle"></i>
            <span id="quizHeaderTitle">Quiz</span>
          </h5>
          <button
            type="button"
            class="btn-close btn-close-white"
            data-bs-dismiss="modal"
          ></button>
        </div>
        <div class="modal-body">
          <div id="quizArea">
            <div class="d-flex justify-content-between mb-3">
              <span
                ><i class="bi bi-bar-chart"></i> Difficulty:
                <strong id="difficultyDisplay"></strong
              ></span>
              <span
                ><i class="bi bi-award"></i> Certificate:
                <strong id="certStatusDisplay"></strong
              ></span
              <span id="quizCounter">Q1/10</span>
            </div>
            <div id="quizQuestion" class="fw-bold fs-5 mb-3"></div>
            <div id="quizOptions" class="mb-3"></div>
            <div id="quizFeedback" class="small mb-2"></div>
            <div class="d-flex justify-content-between">
              <button class="btn btn-secondary" id="restartQuizBtn">
                Restart
              </button>
              <button class="btn btn-primary" id="nextQuizBtn">Next →</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection

@section('scripts')
<script>
  let selectedCategory = "JavaScript";
  let selectedCert = "with";
  let selectedLevel = "intermediate";
  let currentQuestions = [];
  let currentQIndex = 0;
  let userScore = 0;
  let quizActive = false;
  let selectedOption = null;

  const setupModal = new bootstrap.Modal(
    document.getElementById("quizSetupModal"),
  );
  const quizModal = new bootstrap.Modal(
    document.getElementById("mcqQuizModal"),
  );
  const modalCategoryTitle = document.getElementById("modalCategoryTitle");
  const confirmBtn = document.getElementById("confirmQuizBtn");
  const quizHeaderTitle = document.getElementById("quizHeaderTitle");
  const difficultyDisplaySpan = document.getElementById("difficultyDisplay");
  const certStatusSpan = document.getElementById("certStatusDisplay");
  const quizQuestionDiv = document.getElementById("quizQuestion");
  const quizOptionsDiv = document.getElementById("quizOptions");
  const quizCounterSpan = document.getElementById("quizCounter");
  const nextQuizBtn = document.getElementById("nextQuizBtn");
  const restartQuizBtn = document.getElementById("restartQuizBtn");
  const quizFeedback = document.getElementById("quizFeedback");

  const certYes = document.getElementById("certYesOption");
  const certNo = document.getElementById("certNoOption");
  const levelDivs = document.querySelectorAll(".level-badge");

  certYes.addEventListener("click", () => {
    certYes.classList.add("selected");
    certNo.classList.remove("selected");
    selectedCert = "with";
    document.getElementById("infoText").innerText =
      "🎓 Certificate will be generated with your name & score. Share it on LinkedIn!";
  });

  certNo.addEventListener("click", () => {
    certNo.classList.add("selected");
    certYes.classList.remove("selected");
    selectedCert = "without";
    document.getElementById("infoText").innerText =
      "📝 Free practice mode — no certificate, but full access to questions.";
  });

  levelDivs.forEach((div) => {
    div.addEventListener("click", () => {
      levelDivs.forEach((l) => l.classList.remove("selected-level"));
      div.classList.add("selected-level");
      selectedLevel = div.getAttribute("data-level");
    });
  });

  certYes.classList.add("selected");
  document.querySelector('[data-level="intermediate"]').classList.add("selected-level");

  const questionBank = {
    JavaScript: [
      {
        text: "Which of the following is used to declare a variable in ES6?",
        options: ["var", "let", "const", "All of the above"],
        correct: 3,
      },
      {
        text: "What does 'closure' mean in JavaScript?",
        options: [
          "Function inside function accessing outer variables",
          "Closing a browser tab",
          "A type of loop",
          "Error handling",
        ],
        correct: 0,
      },
      {
        text: "Which method adds an element to the end of an array?",
        options: ["push()", "pop()", "shift()", "unshift()"],
        correct: 0,
      },
      {
        text: "What will `typeof null` return?",
        options: ["object", "null", "undefined", "number"],
        correct: 0,
      },
      {
        text: "What is the correct way to write a promise?",
        options: [
          "new Promise()",
          "Promise.create()",
          "new Async()",
          "Promise.resolveOnly",
        ],
        correct: 0,
      },
    ],
    MERN: [
      {
        text: "Which database is used in MERN stack?",
        options: ["MySQL", "MongoDB", "PostgreSQL", "SQLite"],
        correct: 1,
      },
      {
        text: "Express.js is a framework for:",
        options: ["Frontend", "Backend", "Database", "Testing"],
        correct: 1,
      },
      {
        text: "Which hook is used for side effects in React?",
        options: ["useState", "useEffect", "useContext", "useReducer"],
        correct: 1,
      },
      {
        text: "Node.js uses which engine?",
        options: ["V8", "SpiderMonkey", "Chakra", "JavaScriptCore"],
        correct: 0,
      },
    ],
    "Full Stack": [
      {
        text: "What does REST stand for?",
        options: [
          "Representational State Transfer",
          "Responsive Transfer",
          "Remote State",
          "Request Transfer",
        ],
        correct: 0,
      },
      {
        text: "Which method is NOT idempotent?",
        options: ["GET", "PUT", "POST", "DELETE"],
        correct: 2,
      },
      {
        text: "What is CORS?",
        options: [
          "Cross-Origin Resource Sharing",
          "CSS Optimization",
          "Code Review System",
          "Cache System",
        ],
        correct: 0,
      },
    ],
    PHP: [
      {
        text: "What does PHP stand for?",
        options: [
          "Hypertext Preprocessor",
          "Preprocessed Home Page",
          "Personal Home Page",
          "Pretty Hard Process",
        ],
        correct: 0,
      },
    ],
    Java: [
      {
        text: "Which keyword is used to inherit a class in Java?",
        options: ["extends", "implements", "inherits", "super"],
        correct: 0,
      },
    ],
    Laravel: [
      {
        text: "Which artisan command creates a controller?",
        options: [
          "php artisan make:controller",
          "php artisan create controller",
          "php artisan new controller",
          "php artisan generate controller",
        ],
        correct: 0,
      },
    ],
    Python: [
      {
        text: "Which of the following is a mutable data type?",
        options: ["tuple", "string", "list", "int"],
        correct: 2,
      },
    ],
    CSS: [
      {
        text: "Which property changes the background color?",
        options: ["color", "bgcolor", "background-color", "background"],
        correct: 2,
      },
    ],
    "UI/UX Design": [
      {
        text: "Which principle refers to the ease of use?",
        options: ["Usability", "Aesthetics", "Scalability", "Performance"],
        correct: 0,
      },
    ],
    DevOps: [
      {
        text: "Which tool is used for containerization?",
        options: ["Docker", "Jenkins", "Ansible", "Kubernetes"],
        correct: 0,
      },
    ],
  };

  for (const cat in questionBank) {
    while (questionBank[cat].length < 5) {
      questionBank[cat].push({
        text: `Sample ${cat} MCQ: Expand your knowledge!`,
        options: ["Option A", "Option B", "Option C", "Option D"],
        correct: 0,
      });
    }
  }

  function loadQuestionsForCategory(category) {
    return questionBank[category] || questionBank.JavaScript;
  }

  document.querySelectorAll(".category-card").forEach((card) => {
    card.addEventListener("click", () => {
      selectedCategory = card.getAttribute("data-category");
      modalCategoryTitle.innerText = selectedCategory;
      setupModal.show();
    });
  });

  confirmBtn.addEventListener("click", () => {
    setupModal.hide();
    startQuiz();
  });

  function startQuiz() {
    currentQuestions = loadQuestionsForCategory(selectedCategory);
    currentQIndex = 0;
    userScore = 0;
    quizActive = true;
    selectedOption = null;
    quizHeaderTitle.innerText = `${selectedCategory} MCQ`;
    difficultyDisplaySpan.innerText =
      selectedLevel.charAt(0).toUpperCase() + selectedLevel.slice(1);
    certStatusSpan.innerText =
      selectedCert === "with" ? "📜 Certificate" : "📘 Practice Mode";
    loadQuestion();
    quizModal.show();
  }

  function loadQuestion() {
    if (currentQIndex >= currentQuestions.length) {
      finishQuiz();
      return;
    }
    const q = currentQuestions[currentQIndex];
    quizQuestionDiv.innerText = q.text;
    quizOptionsDiv.innerHTML = "";
    selectedOption = null;

    q.options.forEach((opt, idx) => {
      const btn = document.createElement("div");
      btn.className =
        "mcq-option p-3 mb-2 rounded-3 border border-secondary";
      btn.innerHTML = `<i class="bi bi-circle me-2"></i> ${opt}`;
      btn.addEventListener("click", () => {
        document
          .querySelectorAll("#quizOptions .mcq-option")
          .forEach((el) =>
            el.classList.remove("selected-option", "border-primary", "bg-primary-subtle"),
          );
        btn.classList.add("selected-option", "border-primary", "bg-primary-subtle");
        selectedOption = idx;
      });
      quizOptionsDiv.appendChild(btn);
    });

    quizCounterSpan.innerText = `Q${currentQIndex + 1}/${currentQuestions.length}`;
    quizFeedback.innerHTML = "";
  }

  function finishQuiz() {
    const percentage = Math.round((userScore / currentQuestions.length) * 100);
    let message = `Quiz completed! Your score: ${userScore}/${currentQuestions.length} (${percentage}%)`;
    if (selectedCert === "with" && percentage >= 50) {
      message +=
        ` 🎉 Congratulations! You earned a certificate in ${selectedCategory} (${selectedLevel} level). A download link will be emailed.`;
    } else if (selectedCert === "with" && percentage < 50) {
      message +=
        " ⚠️ Score below 50%. Certificate requires higher score. Try again!";
    } else {
      message += ` 📖 Keep practicing to master ${selectedCategory}.`;
    }

    quizQuestionDiv.innerText = "🏁 Quiz Finished";
    quizOptionsDiv.innerHTML = `<div class="alert alert-success">${message}</div>`;
    nextQuizBtn.disabled = true;
    quizActive = false;
  }

  nextQuizBtn.addEventListener("click", () => {
    if (!quizActive) return;
    if (selectedOption === null) {
      quizFeedback.innerHTML =
        '<span class="text-danger">Please select an answer!</span>';
      return;
    }

    const currentQ = currentQuestions[currentQIndex];
    const isCorrect = selectedOption === currentQ.correct;
    if (isCorrect) userScore++;
    quizFeedback.innerHTML = isCorrect
      ? '<span class="text-success">✅ Correct!</span>'
      : `<span class="text-danger">❌ Wrong! Correct answer: ${currentQ.options[currentQ.correct]}</span>`;

    currentQIndex++;
    if (currentQIndex < currentQuestions.length) {
      loadQuestion();
    } else {
      finishQuiz();
    }
  });

  restartQuizBtn.addEventListener("click", () => {
    currentQIndex = 0;
    userScore = 0;
    quizActive = true;
    selectedOption = null;
    nextQuizBtn.disabled = false;
    loadQuestion();
    quizFeedback.innerHTML = "";
  });
</script>
@endsection
