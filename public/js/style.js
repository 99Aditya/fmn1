// Swiper initializations
const swiperElement = document.querySelector(".mySwiper");
if (swiperElement) {
  new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    effect: "slide",
    speed: 800,
    breakpoints: { 640: { slidesPerView: 1 } },
  });
}

const fullSwiperElement = document.querySelector(".fullpage-swiper");
if (fullSwiperElement) {
  new Swiper(".fullpage-swiper", {
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    effect: "fade",
    fadeEffect: { crossFade: true },
    speed: 1000,
  });
}

// Navbar scroll effect
const navbar = document.getElementById("mainNavbar");
if (navbar) {
  window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
      navbar.classList.add("navbar-scrolled");
      navbar.classList.remove("bg-transparent");
    } else {
      navbar.classList.remove("navbar-scrolled");
    }
  });
}

// Counter animation
const counters = document.querySelectorAll(".counter");
let started = false;
const counterSection = document.getElementById("counters");

const animateCounter = (el) => {
  const target = parseInt(el.getAttribute("data-target"), 10);
  let current = 0;
  const increment = target / 70;
  const updateCounter = () => {
    current += increment;
    if (current < target) {
      el.innerText = Math.floor(current);
      requestAnimationFrame(updateCounter);
    } else {
      el.innerText = target;
    }
  };
  updateCounter();
};

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting && !started) {
        started = true;
        counters.forEach((counter) => animateCounter(counter));
        observer.unobserve(entry.target);
      }
    });
  },
  { threshold: 0.3 }
);
if (counterSection) observer.observe(counterSection);

// Dark/Light Mode Toggle
const themeToggleBtn = document.getElementById("darkModeToggle");
const themeIconSpan = document.getElementById("themeIcon");
const themeTextSpan = document.getElementById("themeText");

function setTheme(theme) {
  document.documentElement.setAttribute("data-bs-theme", theme);
  localStorage.setItem("theme", theme);
  if (theme === "dark") {
    if (themeIconSpan) themeIconSpan.className = "bi bi-sun-fill";
    if (themeTextSpan) themeTextSpan.innerText = "Light";
    const brand = document.querySelector(".navbar-brand");
    if (brand) brand.style.color = "#fff";
  } else {
    if (themeIconSpan) themeIconSpan.className = "bi bi-moon-stars-fill";
    if (themeTextSpan) themeTextSpan.innerText = "Dark";
  }
  if (window.scrollY > 50 && navbar) navbar.classList.add("navbar-scrolled");
}

const savedTheme = localStorage.getItem("theme") || "light";
setTheme(savedTheme);

if (themeToggleBtn) {
  themeToggleBtn.addEventListener("click", () => {
    const current = document.documentElement.getAttribute("data-bs-theme");
    const newTheme = current === "dark" ? "light" : "dark";
    setTheme(newTheme);
  });
}

const setupCommunityActions = () => {
  if (typeof AOS !== "undefined") {
    AOS.init({ duration: 800, once: true, offset: 50 });
  }

  const joinButtons = document.querySelectorAll(".join-wa-group");
  const toastEl = document.getElementById("liveToast");
  const toastMessageSpan = document.getElementById("toastMessage");
  let bsToast;

  if (toastEl) {
    bsToast = new bootstrap.Toast(toastEl, { autohide: true, delay: 3000 });
  }

  const showToastMessage = (msg) => {
    if (!toastEl || !toastMessageSpan || !bsToast) return;
    toastMessageSpan.innerText = msg;
    toastEl.style.display = "flex";
    bsToast.show();
    setTimeout(() => {
      toastEl.style.display = "none";
    }, 3200);
  };

  const groupLinks = {
    "Tech & Engineering": "https://chat.whatsapp.com/K9xYzLmNpQrS",
    "Marketing & Growth": "https://chat.whatsapp.com/BaXcDeFgHiJk",
    "Product & Design": "https://chat.whatsapp.com/LmNoPqRsTuVw",
    "Finance & Consulting": "https://chat.whatsapp.com/XyZaBcDeFgHi",
    "HR & Career Dev": "https://chat.whatsapp.com/JkLmNoPqRsTu",
    "AI & Future Skills": "https://chat.whatsapp.com/VwXyZaBcDeFg",
  };

  joinButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const groupName = btn.getAttribute("data-group-name");
      const waLink = groupLinks[groupName] || "https://chat.whatsapp.com/invite_sample";
      showToastMessage(`✨ Joining ${groupName} group! Redirecting to WhatsApp...`);
      setTimeout(() => {
        window.open(waLink, "_blank");
      }, 800);
    });
  });

  const requestBtn = document.getElementById("requestGroupBtn");
  if (requestBtn) {
    requestBtn.addEventListener("click", () => {
      const userEmail = prompt(
        "Enter your email to get notified when your requested community launches:",
        "you@example.com",
      );
      if (userEmail && userEmail.includes("@")) {
        showToastMessage(`📢 Thanks! We'll notify ${userEmail} about new groups.`);
      } else if (userEmail) {
        alert("Please enter a valid email address.");
      }
    });
  }
};

window.addEventListener("DOMContentLoaded", () => {
  setupCommunityActions();
  setupAtsInsight();
});

function setupAtsInsight() {
  const uploadZoneAts = document.getElementById("uploadZoneAts");
  const fileInputAts = document.getElementById("atsResumeInput");
  const uploadBtnAts = document.getElementById("uploadBtnAts");
  const insightDiv = document.getElementById("atsInsightResult");
  const feedbackDiv = document.getElementById("atsDetailedFeedback");
  const statsSectionAts = document.getElementById("stats");

  if (!uploadZoneAts || !fileInputAts || !uploadBtnAts || !insightDiv || !feedbackDiv) {
    return;
  }

  const generateATSDetailedInsight = (fileName, fileType) => {
    const atsScore = Math.floor(Math.random() * (98 - 58 + 1) + 58);
    const kwMiss = [
      "Agile",
      "Data Analysis",
      "Project Coordination",
      "Stakeholder Management",
      "KPIs",
      "ROI",
    ];
    const missingSample = kwMiss
      .slice(0, Math.floor(Math.random() * 3) + 2)
      .join(", ");
    const formatAdvice = fileType.includes("pdf")
      ? "PDF detected — great for formatting retention. Ensure text is selectable."
      : fileType.includes("docx")
      ? "DOCX is ATS-friendly. Avoid text boxes and images."
      : "TXT file has no formatting issues but lacks visual hierarchy.";
    const level = atsScore > 85 ? "Excellent" : atsScore > 65 ? "Moderate" : "Needs Improvement";
    const suggestion = atsScore > 85
      ? "Fine-tune with job-specific skills."
      : atsScore > 65
      ? "Add quantifiable results and more keywords."
      : "Completely restructure headings and include a skills section.";

    return `
      <div class="mb-3"><strong>📄 File:</strong> ${fileName}</div>
      <div class="mb-3"><span class="badge bg-primary fs-6">ATS Score: ${atsScore}%</span> <span class="badge bg-secondary">${level}</span></div>
      <div class="mb-3"><i class="bi bi-check-circle-fill text-success"></i> <strong>Format Analysis:</strong> ${formatAdvice}</div>
      <div class="mb-3"><i class="bi bi-search-heart"></i> <strong>Missing Keywords:</strong> ${missingSample}</div>
      <div class="mb-3"><i class="bi bi-lightbulb-fill text-warning"></i> <strong>Improvement Tip:</strong> ${suggestion}</div>
      <div class="alert alert-info mt-2 small">💡 Pro Tip: Match your resume's skills section exactly with job description phrases.</div>
    `;
  };

  const handleAtsFile = (file) => {
    if (!file) return;
    const valid = [
      "application/pdf",
      "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
      "text/plain",
      "application/msword",
    ];
    if (!valid.includes(file.type)) {
      feedbackDiv.innerHTML = `<div class="alert alert-danger">❌ Unsupported format. Use PDF, DOCX, or TXT.</div>`;
      insightDiv.classList.remove("d-none");
      return;
    }
    if (file.size > 5 * 1024 * 1024) {
      feedbackDiv.innerHTML = `<div class="alert alert-danger">📁 File exceeds 5MB limit.</div>`;
      insightDiv.classList.remove("d-none");
      return;
    }

    feedbackDiv.innerHTML = `<div class="text-center"><div class="spinner-border text-primary"></div><br/>Simulating ATS deep scan...</div>`;
    insightDiv.classList.remove("d-none");

    setTimeout(() => {
      feedbackDiv.innerHTML = generateATSDetailedInsight(file.name, file.type);
    }, 1400);
  };

  uploadZoneAts.addEventListener("click", (e) => {
    if (e.target !== uploadBtnAts && !uploadBtnAts.contains(e.target)) {
      fileInputAts.click();
    }
  });

  uploadBtnAts.addEventListener("click", (e) => {
    e.stopPropagation();
    fileInputAts.click();
  });

  fileInputAts.addEventListener("change", () => {
    if (fileInputAts.files.length) {
      handleAtsFile(fileInputAts.files[0]);
    }
  });

  uploadZoneAts.addEventListener("dragover", (e) => {
    e.preventDefault();
    uploadZoneAts.classList.add("border-primary");
  });

  uploadZoneAts.addEventListener("dragleave", () => {
    uploadZoneAts.classList.remove("border-primary");
  });

  uploadZoneAts.addEventListener("drop", (e) => {
    e.preventDefault();
    uploadZoneAts.classList.remove("border-primary");
    const files = e.dataTransfer.files;
    if (files.length) {
      fileInputAts.files = files;
      handleAtsFile(files[0]);
    }
  });
}

