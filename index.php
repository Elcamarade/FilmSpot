<!DOCTYPE html>
<html lang="ro" data-theme="light">

<head>
<script>
    (function () {
      const t = localStorage.getItem('fs_theme') || 'dark';
      document.documentElement.setAttribute('data-theme', t);
    })();
  </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmSpot — Rezervă bilete la cinema</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <div id="google_translate_element" style="display:none"></div>
    <script>
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'ro',
                includedLanguages: 'ro,en,ru',
                autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</head>

<body>
    <?php
    $films = json_decode(file_get_contents(__DIR__ . '/data/items.json'), true) ?? [];
    $lang = $_SESSION['lang'] ?? 'ro';
    $theme = $_SESSION['theme'] ?? 'dark';
    ?>

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
            <div class="lang-switcher" translate="no">
                <a href="#" onclick="doTranslate('ro'); return false;">RO</a>
                <a href="#" onclick="doTranslate('en'); return false;">EN</a>
                <a href="#" onclick="doTranslate('ru'); return false;">RU</a>
            </div>
            <button class="theme-toggle" onclick="toggleTheme()">☀</button>
            <button class="hamburger" onclick="toggleMenu()">☰</button>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-content">
            <p class="hero-eyebrow">🎬 FILMSPOT CINEMA</p>
            <h1>
                <span class="hero-line">EXPERIENȚA</span>
                <span class="hero-line">CINEMA,</span>
                <span class="hero-line red">REDEFINITĂ.</span>
            </h1>
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

    <!-- FILMS -->
    <section class="films-section" id="films">
        <div class="container">
            <h2 class="section-title">Acum pe ecrane</h2>
            <div class="films-grid">
                <?php foreach ($films as $film): ?>
                    <div class="film-card" data-id="<?= htmlspecialchars($film['id']) ?>">
                        <div class="film-poster">
                            <div class="poster-placeholder" style="background: <?= $film['color'] ?? 'linear-gradient(135deg,#e50914,#831010)' ?>">
                                <span class="poster-emoji"><?= $film['emoji'] ?? '🎬' ?></span>
                            </div>
                            <div class="film-overlay">
                                <?php if (isset($_SESSION['user'])): ?>
                                    <a href="dashboard.php?reserve=<?= $film['id'] ?>" class="btn-reserve">Rezervă bilet</a>
                                <?php else: ?>
                                    <a href="login.php" class="btn-reserve">Rezervă bilet</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="film-info">
                            <h3><?= htmlspecialchars($film['title']) ?></h3>
                            <div class="film-meta">
                                <span class="badge"><?= htmlspecialchars($film['genre']) ?></span>
                                <span class="meta-item">⏱ <?= $film['duration'] ?> min </span>
                                <span class="meta-item">⭐ <?= $film['rating'] ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section class="about-section" id="about">
        <div class="container">
            <div class="about-grid">
                <div class="about-text">
                    <h2>Despre <span class="accent">FilmSpot</span></h2>
                    <p>FilmSpot este platforma ta modernă de rezervare a biletelor la cinema. Oferim o experiență simplă, rapidă și plăcută pentru toți iubitorii de film.</p>
                    <p>Alege din zeci de filme, selectează locul preferat și primești confirmarea instant — totul online, fără cozi.</p>
                </div>
                <div class="about-stats">
                    <div class="stat"><span class="stat-num">50+</span><span>Filme</span></div>
                    <div class="stat"><span class="stat-num">5★</span><span>Rating</span></div>
                    <div class="stat"><span class="stat-num">24/7</span><span>Online</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Funcționalități</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <span class="feature-icon">🎟</span>
                    <h3>Rezervare rapidă</h3>
                    <p>Bilete rezervate în mai puțin de 60 de secunde.</p>
                </div>
                <div class="feature-card">
                    <span class="feature-icon">💺</span>
                    <h3>Alegere loc</h3>
                    <p>Vezi sala și alege locul preferat vizual.</p>
                </div>
                <div class="feature-card">
                    <span class="feature-icon">🌙</span>
                    <h3>Dark / Light mode</h3>
                    <p>Interfață adaptată preferințelor tale.</p>
                </div>
                <div class="feature-card">
                    <span class="feature-icon">🌍</span>
                    <h3>Multilingv</h3>
                    <p>Disponibil în română, engleză și rusă.</p>
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