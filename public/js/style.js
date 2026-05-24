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
    { threshold: 0.3 },
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
            const waLink =
                groupLinks[groupName] ||
                "https://chat.whatsapp.com/invite_sample";
            showToastMessage(
                `✨ Joining ${groupName} group! Redirecting to WhatsApp...`,
            );
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
                showToastMessage(
                    `📢 Thanks! We'll notify ${userEmail} about new groups.`,
                );
            } else if (userEmail) {
                alert("Please enter a valid email address.");
            }
        });
    }
};

window.addEventListener("DOMContentLoaded", () => {
    setupCommunityActions();
});
