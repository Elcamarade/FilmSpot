<!DOCTYPE html>
<html lang="ro" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmSpot — Rezervă bilete la cinema</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <!-- MENIU -->
    <nav class="navbar">
        <a href="index.php" class="logo">FILM<span>SPOT</span></a>
        <ul class="nav-links" id="navLinks">
            <li><a href="index.php" class="active">Acasă</a></li>
            <li><a href="#despre">Despre</a></li>
            <li><a href="#functionalitati">Funcționalități</a></li>
            <li><a href="login.php">Autentificare</a></li>
            <li><a href="register.php" class="btn-register">Înregistrare</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="nav-right">
            <div class="lang-switcher">
                <a href="#" class="active">RO</a>
                <a href="#">EN</a>
                <a href="#">RU</a>
            </div>
            <button class="theme-toggle" onclick="toggleTheme()">☀</button>
            <button class="hamburger" onclick="toggleMenu()">☰</button>
        </div>
    </nav>

    <!-- PAGINA PRINCIPALĂ / HERO -->
    <section class="hero">
        <div class="hero-content">
            <p class="hero-eyebrow">🎬 FILMSPOT CINEMA</p>
            <h1>EXPERIENȚA<br>CINEMA,<br><span class="red">REDEFINITĂ.</span></h1>
            <p class="hero-desc">Rezervă biletele tale online în câteva secunde. Alege filmul, ora, locul — și bucură-te de magie.</p>
            <div class="hero-btns">
                <a href="#filme" class="btn-primary">Explorează filme</a>
                <a href="register.php" class="btn-outline">Înregistrare</a>
            </div>
        </div>
        <div class="hero-visual">
            <div class="screen-card">
                <div class="screen-glow"></div>
                <div class="screen-dots">
                    <span></span><span></span><span></span><span></span>
                    <span></span><span></span><span></span><span></span>
                    <span></span><span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container footer-inner">
            <a href="index.php" class="logo">FILM<span>SPOT</span></a>
            <p>© 2026 FilmSpot. Toate drepturile rezervate.</p>
            <div class="footer-links">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
                <a href="contact.php">Contact</a>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>

</html>