function toggleTheme() {
  const html = document.documentElement;
  const next = html.getAttribute("data-theme") === "dark" ? "light" : "dark";
  html.setAttribute("data-theme", next);
  document.getElementById("themeBtn").textContent =
    next === "dark" ? "☀" : "🌙";
  localStorage.setItem("fs_theme", next);
}

function toggleMenu() {
  document.getElementById("navLinks").classList.toggle("open");
}
(function () {
  const t = localStorage.getItem("fs_theme");
  if (t) {
    document.documentElement.setAttribute("data-theme", t);
    const btn = document.getElementById("themeBtn");
    if (btn) btn.textContent = t === "dark" ? "☀" : "🌙";
  }
})();

// Load saved theme from localStorage (fast, before page paint)
(function () {
    const saved = localStorage.getItem('filmspot_theme');
    if (saved) {
        document.documentElement.setAttribute('data-theme', saved);
        // Sync icon
        const icon = document.querySelector('.theme-icon');
        if (icon) icon.textContent = saved === 'dark' ? '☀' : '🌙';
    }
})();

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', (e) => {
        const target = document.querySelector(link.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Form validation feedback
document.querySelectorAll('.auth-form input, .auth-form textarea').forEach(input => {
    input.addEventListener('blur', () => {
        if (input.required && !input.value.trim()) {
            input.style.borderColor = '#e50914';
        } else {
            input.style.borderColor = '';
        }
    });
    input.addEventListener('input', () => {
        input.style.borderColor = '';
    });
});

// Animate cards on scroll
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.style.opacity = '1';
            e.target.style.transform = 'translateY(0)';
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.film-card, .feature-card').forEach(card => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    observer.observe(card);
});
