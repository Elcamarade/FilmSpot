<?php
session_start();
require_once 'php/functions.php';

$lang  = $_SESSION['lang'] ?? 'ro';
$theme = $_SESSION['theme'] ?? 'dark';
$error = '';
$success = '';

if (isset($_GET['lang']) && in_array($_GET['lang'], ['ro','en','ru'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header('Location: contact.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Completați toate câmpurile.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email invalid.';
    } elseif (strlen($message) < 10) {
        $error = 'Mesajul este prea scurt (min. 10 caractere).';
    } else {
        // Save to JSON
        $contacts = readJSON('data/contacts.json');
        $contacts[] = [
            'id'      => uniqid(),
            'name'    => $name,
            'email'   => $email,
            'message' => $message,
            'date'    => date('Y-m-d H:i:s'),
        ];
        saveJSON('data/contacts.json', $contacts);
        $success = 'Mesajul a fost trimis cu succes! Vă vom contacta în curând.';
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" data-theme="<?= $theme ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmSpot — Contact</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <a href="index.php" class="logo">Film<span>Spot</span></a>
    <ul class="nav-links">
        <li><a href="index.php">Acasă</a></li>
        <?php if (isset($_SESSION['user'])): ?>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="logout.php" class="btn-nav">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php" class="btn-nav">Register</a></li>
        <?php endif; ?>
        <li><a href="contact.php" class="active">Contact</a></li>
    </ul>
    <div class="nav-controls">
        <div class="lang-switcher">
            <a href="?lang=ro" class="<?= $lang==='ro'?'active':'' ?>">RO</a>
            <a href="?lang=en" class="<?= $lang==='en'?'active':'' ?>">EN</a>
            <a href="?lang=ru" class="<?= $lang==='ru'?'active':'' ?>">RU</a>
        </div>
        <button class="theme-toggle" onclick="toggleTheme()">☀</button>
        <button class="hamburger" onclick="toggleMenu()">☰</button>
    </div>
</nav>

<main class="contact-page">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h1>Contactează-ne</h1>
                <p>Ai întrebări despre rezervări sau filme? Suntem aici pentru tine.</p>
                <div class="contact-details">
                    <div class="contact-item">
                        <span>📧</span>
                        <span>contact@filmspot.md</span>
                    </div>
                    <div class="contact-item">
                        <span>📞</span>
                        <span>+373 22 123 456</span>
                    </div>
                    <div class="contact-item">
                        <span>📍</span>
                        <span>Chișinău, Moldova</span>
                    </div>
                </div>
            </div>

            <div class="auth-card contact-card">
                <?php if ($error): ?>
                    <div class="alert alert-error">⚠ <?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success">✓ <?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <form method="POST" class="auth-form" novalidate>
                    <div class="form-group">
                        <label for="name">Nume</label>
                        <input type="text" id="name" name="name" placeholder="Numele tău" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="email@exemplu.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Mesaj</label>
                        <textarea id="message" name="message" placeholder="Scrie mesajul tău..." rows="5" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn-primary full-width">Trimite mesaj</button>
                </form>
            </div>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">
        <div class="footer-bottom">
            <p>© 2025 FilmSpot. Toate drepturile rezervate.</p>
        </div>
    </div>
</footer>
<script src="js/script.js"></script>
</body>
</html>
