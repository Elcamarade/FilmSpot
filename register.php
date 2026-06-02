<?php
session_start();
require_once 'php/auth.php';
require_once 'php/functions.php';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$lang = $_SESSION['lang'] ?? 'ro';
$theme = $_SESSION['theme'] ?? 'dark';
$error = '';
$success = '';

if (isset($_GET['lang']) && in_array($_GET['lang'], ['ro', 'en', 'ru'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header('Location: register.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm'] ?? '');

    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $error = 'Completați toate câmpurile.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresa de email nu este validă.';
    } elseif (strlen($password) < 6) {
        $error = 'Parola trebuie să aibă cel puțin 6 caractere.';
    } elseif ($password !== $confirm) {
        $error = 'Parolele nu coincid.';
    } else {
        $result = registerUser($name, $email, $password);
        if ($result === true) {
            $success = 'Cont creat cu succes! Te poți autentifica.';
        } else {
            $error = $result;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" data-theme="<?= $theme ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmSpot — Înregistrare</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="navbar">
        <a href="index.php" class="logo">Film<span>Spot</span></a>
        <ul class="nav-links">
            <li><a href="index.php">Acasă</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php" class="active btn-nav">Register</a></li>
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
                <span class="auth-icon">🎟</span>
                <h1>Înregistrare</h1>
                <p>Creează-ți contul FilmSpot</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">⚠ <?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success">✓ <?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST" class="auth-form" novalidate>
                <div class="form-group">
                    <label for="name">Nume complet</label>
                    <input type="text" id="name" name="name" placeholder="Ion Popescu" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="email@exemplu.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Parolă <small>(min. 6 caractere)</small></label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <div class="form-group">
                    <label for="confirm">Confirmă parola</label>
                    <input type="password" id="confirm" name="confirm" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-primary full-width">Creează cont</button>
            </form>

            <p class="auth-switch">Ai deja cont? <a href="login.php">Autentifică-te</a></p>
        </div>
    </main>

    <script src="js/script.js"></script>
</body>

</html>