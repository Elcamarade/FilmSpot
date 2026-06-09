//Theme

(function () {
  const saved = localStorage.getItem('fs_theme') || 'dark';
  document.documentElement.setAttribute('data-theme', saved);
})();

function toggleTheme() {
  const html = document.documentElement;
  const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
  html.setAttribute('data-theme', next);
  localStorage.setItem('fs_theme', next);
  document.querySelector('.theme-toggle').textContent = next === 'dark' ? '☀' : '🌙';
}

function toggleMenu() {
  document.getElementById("navLinks").classList.toggle("open");
}

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

//Translate

function doTranslate(lang) {
  const select = document.querySelector('.goog-te-combo');
  if (select) {
    select.value = lang;
    select.dispatchEvent(new Event('change'));
  }
}