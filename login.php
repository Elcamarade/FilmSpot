<?php
session_start();
require_once 'php/auth.php';
require_once 'php/functions.php';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$lang = $_SESSION['lang'] ?? 'ro';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'Completați toate câmpurile.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email invalid.';
    } else {
        $result = loginUser($email, $password);
        if ($result === true) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = $result;
        }
    }
}

if (isset($_GET['lang']) && in_array($_GET['lang'], ['ro', 'en', 'ru'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header('Location: login.php');
    exit;
}

$theme = $_SESSION['theme'] ?? 'dark';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" data-theme="<?= $theme ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmSpot — Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navbar">
        <a href="index.php" class="logo">Film<span>Spot</span></a>
        <ul class="nav-links">
            <li><a href="index.php">Acasă</a></li>
            <li><a href="login.php" class="active">Login</a></li>
            <li><a href="register.php" class="btn-nav">Register</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="nav-controls">
            <div class="lang-switcher">
                <a href="?lang=ro" class="<?= $lang === 'ro' ? 'active' : '' ?>">RO</a>
                <a href="?lang=en" class="<?= $lang === 'en' ? 'active' : '' ?>">EN</a>
                <a href="?lang=ru" class="<?= $lang === 'ru' ? 'active' : '' ?>">RU</a>
            </div>
            <button class="theme-toggle" onclick="toggleTheme()">☀</button>
            <button class="hamburger" onclick="toggleMenu()">☰</button>
        </div>
    </nav>

    <main class="auth-page">
        <div class="auth-card">
            <div class="auth-header">
                <span class="auth-icon">🎬</span>
                <h1>Autentificare</h1>
                <p>Bun venit înapoi la FilmSpot</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">⚠ <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success">✓ <?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" class="auth-form" novalidate>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="email@exemplu.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Parolă</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-primary full-width">Intră în cont</button>
            </form>

            <p class="auth-switch">Nu ai cont? <a href="register.php">Înregistrează-te</a></p>
        </div>
    </main>

    <script src="js/script.js"></script>
</body>

</html>