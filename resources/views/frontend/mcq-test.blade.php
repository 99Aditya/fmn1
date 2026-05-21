@extends('frontend.layouts.app')

@section('title', 'CareerElevate | Professional MCQ Test Platform')

@section('content')
<main>
  <!-- Banner -->
  <section class="mcq-hero">
    <div class="container text-center">
      <h1 class="display-5 fw-bold">Professional MCQ Tests</h1>
      <p class="lead">
        Choose a test, challenge yourself with timed questions, and get
        detailed results
      </p>
    </div>
  </section>

  <!-- Test Selection Section -->
  <div id="testSelectionSection" class="container my-5">
    <div class="text-center mb-4">
      <h2 class="display-6 fw-semibold">Available Assessments</h2>
      <p>Click any test to start your assessment</p>
    </div>
    <div class="row g-4" id="testCardsContainer"></div>
  </div>

  <!-- Quiz Interface Section (hidden initially) -->
  <div id="quizSection" class="container my-5" style="display: none">
    <div class="quiz-container p-4 p-md-5">
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
          <h3 id="testNameDisplay" class="fw-bold mb-1">Test Name</h3>
          <span class="text-muted">
            <i class="bi bi-question-circle"></i>
            <span id="totalQuestionsSpan">0</span> Questions
          </span>
        </div>
        <div class="timer-box">
          <i class="bi bi-hourglass-split me-2"></i>
          <span id="timerDisplay">00:00</span>
        </div>
      </div>

      <!-- Question Navigation Buttons (professional quick nav) -->
      <div class="mb-4 p-3 bg-body-tertiary rounded-3">
        <div class="d-flex flex-wrap gap-2" id="questionNavButtons"></div>
      </div>

      <!-- Current Question Card -->
      <div id="currentQuestionCard" class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <span class="question-number">
            <i class="bi bi-patch-question-fill"></i> Question
            <span id="currentQNumber">1</span>
          </span>
        </div>
        <h4 id="questionText" class="mb-4">Loading question...</h4>
        <div id="optionsContainer" class="mb-4"></div>
      </div>

      <!-- Navigation Buttons -->
      <div class="d-flex justify-content-between gap-3">
        <button class="btn btn-outline-secondary nav-btn" id="prevBtn" disabled>
          <i class="bi bi-arrow-left"></i> Previous
        </button>
        <button class="btn btn-primary nav-btn" id="nextBtn">
          Next <i class="bi bi-arrow-right"></i>
        </button>
        <button class="btn btn-success nav-btn" id="submitBtn" style="display: none">
          Submit Test <i class="bi bi-check-lg"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Result Section (hidden initially) -->
  <div id="resultSection" class="container my-5" style="display: none">
    <div class="result-card p-4 p-md-5 text-center">
      <i class="bi bi-trophy-fill display-1 text-warning mb-3"></i>
      <h2 class="display-6 fw-bold">Test Results</h2>
      <p id="resultTestName" class="lead">Test Name</p>

      <div class="score-circle mx-auto my-4">
        <div>
          <div class="score-number" id="finalScore">0</div>
          <div class="text-white">Score</div>
        </div>
      </div>

      <div class="row justify-content-center mt-4">
        <div class="col-md-6">
          <div class="d-flex justify-content-between mb-2">
            <span>Correct Answers:</span>
            <strong id="correctCount">0</strong>
          </div>
          <div class="d-flex justify-content-between mb-2">
            <span>Incorrect Answers:</span>
            <strong id="incorrectCount">0</strong>
          </div>
          <div class="d-flex justify-content-between mb-3">
            <span>Time Taken:</span>
            <strong id="timeTaken">00:00</strong>
          </div>
          <div class="progress mb-3" style="height: 10px">
            <div id="scoreProgress" class="progress-bar bg-success" style="width: 0%"></div>
          </div>
        </div>
      </div>

      <h4 class="mt-4">Question-wise Analysis</h4>
      <div id="answersReviewContainer" class="mt-3 text-start"></div>

      <div class="mt-5 d-flex gap-3 justify-content-center">
        <button class="btn btn-primary" id="restartBtn">
          <i class="bi bi-arrow-repeat"></i> Take Another Test
        </button>
        <button class="btn btn-outline-secondary" id="homeBtn">
          <i class="bi bi-house"></i> Back to Tests
        </button>
      </div>
    </div>
  </div>
</main>
@endsection

@section('scripts')
<script>
  const testsData = [
    {
      id: 1,
      name: "JavaScript Mastery Test",
      duration: 300,
      questions: [
        {
          text: "What is the correct way to declare a variable in ES6?",
          options: ["var", "let", "const", "All of the above"],
          correct: 3,
        },
        {
          text: "Which method adds an element to the end of an array?",
          options: ["push()", "pop()", "shift()", "unshift()"],
          correct: 0,
        },
        {
          text: "What does `typeof null` return?",
          options: ["object", "null", "undefined", "number"],
          correct: 0,
        },
        {
          text: "What is a closure in JavaScript?",
          options: [
            "Function with access to outer scope",
            "A loop",
            "A data type",
            "An error handler",
          ],
          correct: 0,
        },
        {
          text: "Which keyword is used to create a class in ES6?",
          options: ["class", "Class", "createClass", "newClass"],
          correct: 0,
        },
      ],
    },
    {
      id: 2,
      name: "Python Programming Test",
      duration: 300,
      questions: [
        {
          text: "Which of the following is a mutable data type in Python?",
          options: ["tuple", "string", "list", "int"],
          correct: 2,
        },
        {
          text: "What is the output of print(2**3)?",
          options: ["6", "8", "9", "5"],
          correct: 1,
        },
        {
          text: "Which keyword is used to define a function?",
          options: ["def", "func", "define", "lambda"],
          correct: 0,
        },
        {
          text: "What does PEP 8 refer to?",
          options: ["Style Guide", "Python Version", "Library", "Framework"],
          correct: 0,
        },
        {
          text: "Which library is used for data analysis?",
          options: ["NumPy", "Django", "Flask", "Tkinter"],
          correct: 0,
        },
      ],
    },
    {
      id: 3,
      name: "React.js Assessment",
      duration: 300,
      questions: [
        {
          text: "Which hook is used for side effects?",
          options: ["useState", "useEffect", "useContext", "useReducer"],
          correct: 1,
        },
        {
          text: "What is JSX?",
          options: [
            "JavaScript XML",
            "Java Syntax Extension",
            "JSON XHR",
            "JavaScript Extension",
          ],
          correct: 0,
        },
        {
          text: "Which method is used to update state in class components?",
          options: ["setState()", "updateState()", "changeState()", "modifyState()"],
          correct: 0,
        },
        {
          text: "What is the virtual DOM?",
          options: [
            "Lightweight copy of real DOM",
            "New HTML element",
            "React Component",
            "Browser API",
          ],
          correct: 0,
        },
        {
          text: "Which company developed React?",
          options: ["Google", "Facebook", "Twitter", "Microsoft"],
          correct: 1,
        },
      ],
    },
    {
      id: 4,
      name: "Full Stack Development",
      duration: 360,
      questions: [
        {
          text: "What does REST stand for?",
          options: [
            "Representational State Transfer",
            "Remote State Transfer",
            "Request Transfer",
            "Responsive Transfer",
          ],
          correct: 0,
        },
        {
          text: "Which database is NoSQL?",
          options: ["MongoDB", "MySQL", "PostgreSQL", "Oracle"],
          correct: 0,
        },
        {
          text: "What is CORS?",
          options: [
            "Cross-Origin Resource Sharing",
            "Code Optimization",
            "Cache System",
            "Compression Tool",
          ],
          correct: 0,
        },
        {
          text: "Which of the following is a backend framework for Node.js?",
          options: ["Express", "React", "Angular", "Vue"],
          correct: 0,
        },
        {
          text: "What is the purpose of JWT?",
          options: ["Authentication", "Styling", "Database Query", "Logging"],
          correct: 0,
        },
      ],
    },
  ];

  let currentTest = null;
  let userAnswers = [];
  let currentQuestionIndex = 0;
  let timerInterval = null;
  let timeRemaining = 0;
  let testStarted = false;

  const testSelectionDiv = document.getElementById("testSelectionSection");
  const quizSection = document.getElementById("quizSection");
  const resultSection = document.getElementById("resultSection");
  const testCardsContainer = document.getElementById("testCardsContainer");
  const testNameDisplay = document.getElementById("testNameDisplay");
  const totalQuestionsSpan = document.getElementById("totalQuestionsSpan");
  const timerDisplay = document.getElementById("timerDisplay");
  const questionNavButtons = document.getElementById("questionNavButtons");
  const currentQNumberSpan = document.getElementById("currentQNumber");
  const questionText = document.getElementById("questionText");
  const optionsContainer = document.getElementById("optionsContainer");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");
  const submitBtn = document.getElementById("submitBtn");

  function renderTestCards() {
    testCardsContainer.innerHTML = "";
    testsData.forEach((test) => {
      const col = document.createElement("div");
      col.className = "col-md-6 col-lg-3";
      col.innerHTML = `
        <div class="test-card card p-4 text-center" data-test-id="${test.id}">
          <i class="bi bi-file-text-fill fs-1 text-primary"></i>
          <h4 class="mt-3">${test.name}</h4>
          <p class="text-muted small">${test.questions.length} Questions - ${Math.floor(test.duration / 60)} min</p>
          <button class="btn btn-primary rounded-pill mt-2 start-test-btn">Start Test →</button>
        </div>
      `;
      col.querySelector(".start-test-btn").addEventListener("click", (e) => {
        e.stopPropagation();
        startTest(test.id);
      });
      testCardsContainer.appendChild(col);
    });
  }

  function startTest(testId) {
    if (timerInterval) clearInterval(timerInterval);
    currentTest = testsData.find((t) => t.id === testId);
    if (!currentTest) return;

    userAnswers = new Array(currentTest.questions.length).fill(-1);
    currentQuestionIndex = 0;
    timeRemaining = currentTest.duration;
    updateTimerDisplay();

    testSelectionDiv.style.display = "none";
    quizSection.style.display = "block";
    resultSection.style.display = "none";

    testNameDisplay.innerText = currentTest.name;
    totalQuestionsSpan.innerText = currentTest.questions.length;

    startTimer();
    renderQuestionNavButtons();
    loadQuestion();
    testStarted = true;
  }

  function startTimer() {
    if (timerInterval) clearInterval(timerInterval);
    timerInterval = setInterval(() => {
      if (timeRemaining <= 0) {
        clearInterval(timerInterval);
        alert("Time's up! Submitting your test...");
        submitTest();
      } else {
        timeRemaining--;
        updateTimerDisplay();
      }
    }, 1000);
  }

  function updateTimerDisplay() {
    const minutes = Math.floor(timeRemaining / 60);
    const seconds = timeRemaining % 60;
    timerDisplay.innerText = `${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
    timerDisplay.style.color = timeRemaining < 60 ? "#ffc107" : "white";
  }

  function renderQuestionNavButtons() {
    questionNavButtons.innerHTML = "";
    for (let i = 0; i < currentTest.questions.length; i++) {
      const btn = document.createElement("button");
      btn.className = "btn btn-sm btn-outline-primary rounded-circle";
      btn.style.width = "40px";
      btn.style.height = "40px";
      btn.innerText = i + 1;
      if (userAnswers[i] !== -1) {
        btn.classList.remove("btn-outline-primary");
        btn.classList.add("btn-success");
      }
      btn.addEventListener("click", () => {
        currentQuestionIndex = i;
        loadQuestion();
      });
      questionNavButtons.appendChild(btn);
    }
  }

  function updateNavButtonsStatus() {
    for (let i = 0; i < questionNavButtons.children.length; i++) {
      const btn = questionNavButtons.children[i];
      if (userAnswers[i] !== -1) {
        btn.classList.remove("btn-outline-primary");
        btn.classList.add("btn-success");
      } else {
        btn.classList.add("btn-outline-primary");
        btn.classList.remove("btn-success");
      }
    }
  }

  function loadQuestion() {
    const q = currentTest.questions[currentQuestionIndex];
    currentQNumberSpan.innerText = currentQuestionIndex + 1;
    questionText.innerText = q.text;

    optionsContainer.innerHTML = "";
    q.options.forEach((opt, idx) => {
      const optionDiv = document.createElement("div");
      optionDiv.className = "option-item";
      optionDiv.innerHTML = `<i class="bi bi-circle me-2"></i> ${opt}`;
      if (userAnswers[currentQuestionIndex] === idx) {
        optionDiv.classList.add("selected");
      }
      optionDiv.addEventListener("click", () => {
        document.querySelectorAll(".option-item").forEach((el) => el.classList.remove("selected"));
        optionDiv.classList.add("selected");
        userAnswers[currentQuestionIndex] = idx;
        updateNavButtonsStatus();
        renderQuestionNavButtons();
        updateNavButtonsStatus();
      });
      optionsContainer.appendChild(optionDiv);
    });

    prevBtn.disabled = currentQuestionIndex === 0;
    if (currentQuestionIndex === currentTest.questions.length - 1) {
      nextBtn.style.display = "none";
      submitBtn.style.display = "inline-flex";
    } else {
      nextBtn.style.display = "inline-flex";
      submitBtn.style.display = "none";
    }
  }

  prevBtn.addEventListener("click", () => {
    if (currentQuestionIndex > 0) {
      currentQuestionIndex--;
      loadQuestion();
    }
  });

  nextBtn.addEventListener("click", () => {
    if (currentQuestionIndex < currentTest.questions.length - 1) {
      currentQuestionIndex++;
      loadQuestion();
    }
  });

  submitBtn.addEventListener("click", () => {
    if (confirm("Are you sure you want to submit the test?")) {
      submitTest();
    }
  });

  function submitTest() {
    if (timerInterval) clearInterval(timerInterval);

    let correct = 0;
    const answersReview = [];
    for (let i = 0; i < currentTest.questions.length; i++) {
      const q = currentTest.questions[i];
      const userAns = userAnswers[i];
      const isCorrect = userAns === q.correct;
      if (isCorrect) correct++;
      answersReview.push({
        question: q.text,
        userAnswer: userAns !== -1 ? q.options[userAns] : "Not Answered",
        correctAnswer: q.options[q.correct],
        isCorrect,
      });
    }

    const total = currentTest.questions.length;
    const scorePercent = Math.round((correct / total) * 100);
    const timeTakenSec = currentTest.duration - timeRemaining;
    const minutesTaken = Math.floor(timeTakenSec / 60);
    const secondsTaken = timeTakenSec % 60;
    const timeFormatted = `${minutesTaken.toString().padStart(2, "0")} : ${secondsTaken.toString().padStart(2, "0")}`;

    quizSection.style.display = "none";
    resultSection.style.display = "block";

    document.getElementById("resultTestName").innerText = currentTest.name;
    document.getElementById("finalScore").innerText = `${correct}/${total}`;
    document.getElementById("correctCount").innerText = correct;
    document.getElementById("incorrectCount").innerText = total - correct;
    document.getElementById("timeTaken").innerText = timeFormatted;
    document.getElementById("scoreProgress").style.width = `${scorePercent}%`;

    const reviewContainer = document.getElementById("answersReviewContainer");
    reviewContainer.innerHTML = "";
    answersReview.forEach((item, idx) => {
      const statusIcon = item.isCorrect
        ? '<i class="bi bi-check-circle-fill text-success"></i>'
        : '<i class="bi bi-x-circle-fill text-danger"></i>';
      const card = document.createElement("div");
      card.className = "mb-3 p-3 border rounded-3";
      card.innerHTML = `
        <div class="d-flex justify-content-between align-items-start">
          <div><strong>Q${idx + 1}.</strong> ${item.question}</div>
          <div>${statusIcon}</div>
        </div>
        <div class="small mt-2">
          <div><span class="text-muted">Your answer:</span> ${item.userAnswer}</div>
          <div><span class="text-success">Correct answer:</span> ${item.correctAnswer}</div>
        </div>
      `;
      reviewContainer.appendChild(card);
    });
  }

  document.getElementById("restartBtn").addEventListener("click", () => {
    resultSection.style.display = "none";
    testSelectionDiv.style.display = "block";
    quizSection.style.display = "none";
    if (timerInterval) clearInterval(timerInterval);
  });

  document.getElementById("homeBtn").addEventListener("click", () => {
    resultSection.style.display = "none";
    testSelectionDiv.style.display = "block";
    quizSection.style.display = "none";
    if (timerInterval) clearInterval(timerInterval);
  });

  renderTestCards();
</script>
@endsection
