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
