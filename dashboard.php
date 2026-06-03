<?php
session_start();
require_once 'php/auth.php';
require_once 'php/functions.php';
requireLogin();

$lang  = $_SESSION['lang'] ?? 'ro';
$theme = $_SESSION['theme'] ?? 'dark';
$user  = $_SESSION['user'];

$films = readJSON('data/items.json');
$users = readJSON('data/users.json');

$error   = '';
$success = '';

if (isset($_GET['lang']) && in_array($_GET['lang'], ['ro','en','ru'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header('Location: dashboard.php');
    exit;
}

// Find current user data
$currentUser = null;
foreach ($users as &$u) {
    if ($u['email'] === $user['email']) {
        $currentUser = &$u;
        break;
    }
}

// RESERVE a film
if (isset($_GET['reserve'])) {
    $filmId = $_GET['reserve'];
    $film   = findById($films, $filmId);
    if ($film) {
        $alreadyReserved = false;
        foreach ($currentUser['reservations'] ?? [] as $r) {
            if ($r['film_id'] === $filmId) {
                $alreadyReserved = true;
                break;
            }
        }
        if (!$alreadyReserved) {
            $currentUser['reservations'][] = [
                'film_id'   => $filmId,
                'film_title'=> $film['title'],
                'date'      => date('Y-m-d'),
                'time'      => '20:00',
                'seat'      => 'A' . rand(1, 20),
            ];
            saveJSON('data/users.json', $users);
            $_SESSION['user'] = $currentUser;
            $success = 'Bilet rezervat cu succes!';
        } else {
            $error = 'Ai deja o rezervare pentru acest film.';
        }
    }
}

// DELETE a reservation
if (isset($_GET['delete'])) {
    $filmId = $_GET['delete'];
    $currentUser['reservations'] = array_values(array_filter(
        $currentUser['reservations'] ?? [],
        fn($r) => $r['film_id'] !== $filmId
    ));
    saveJSON('data/users.json', $users);
    $_SESSION['user'] = $currentUser;
    $success = 'Rezervare anulată.';
    header('Location: dashboard.php');
    exit;
}

// EDIT reservation time
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_film_id'])) {
    $filmId  = $_POST['edit_film_id'];
    $newTime = $_POST['new_time'] ?? '20:00';
    foreach ($currentUser['reservations'] as &$r) {
        if ($r['film_id'] === $filmId) {
            $r['time'] = $newTime;
            break;
        }
    }
    saveJSON('data/users.json', $users);
    $_SESSION['user'] = $currentUser;
    $success = 'Ora rezervării actualizată.';
}

$reservations = $currentUser['reservations'] ?? [];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" data-theme="<?= $theme ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilmSpot — Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<nav class="navbar">
    <a href="index.php" class="logo">Film<span>Spot</span></a>
    <ul class="nav-links">
        <li><a href="index.php">Acasă</a></li>
        <li><a href="dashboard.php" class="active">Dashboard</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="logout.php" class="btn-nav">Logout</a></li>
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

<main class="dashboard-page">
    <div class="container">
        <div class="dash-header">
            <div>
                <h1>Bun venit, <span class="accent"><?= htmlspecialchars($user['name']) ?></span>!</h1>
                <p><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <a href="logout.php" class="btn-ghost">Logout</a>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error">⚠ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success">✓ <?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <!-- Reservations -->
        <section class="dash-section">
            <h2>🎟 Rezervările mele</h2>
            <?php if (empty($reservations)): ?>
                <div class="empty-state">
                    <span>🎬</span>
                    <p>Nu ai nicio rezervare încă. <a href="index.php#films">Explorează filmele</a></p>
                </div>
            <?php else: ?>
                <div class="reservations-list">
                    <?php foreach ($reservations as $r): ?>
                    <div class="reservation-card">
                        <div class="res-info">
                            <h3><?= htmlspecialchars($r['film_title']) ?></h3>
                            <p>📅 <?= $r['date'] ?> &nbsp; 🕐 <?= $r['time'] ?> &nbsp; 💺 Loc <?= $r['seat'] ?></p>
                        </div>
                        <div class="res-actions">
                            <button class="btn-edit" onclick="openEdit('<?= $r['film_id'] ?>', '<?= $r['time'] ?>')">✏ Modifică</button>
                            <a href="?delete=<?= $r['film_id'] ?>" class="btn-delete" onclick="return confirm('Anulezi rezervarea?')">🗑 Anulează</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- All films to reserve -->
        <section class="dash-section">
            <h2>🎥 Toate filmele</h2>
            <div class="films-grid small">
                <?php foreach ($films as $film): ?>
                <div class="film-card">
                    <div class="film-poster small-poster">
                        <div class="poster-placeholder" style="background: <?= $film['color'] ?? 'linear-gradient(135deg,#e50914,#831010)' ?>">
                            <span class="poster-emoji"><?= $film['emoji'] ?? '🎬' ?></span>
                        </div>
                    </div>
                    <div class="film-info">
                        <h3><?= htmlspecialchars($film['title']) ?></h3>
                        <div class="film-meta">
                            <span class="badge"><?= $film['genre'] ?></span>
                            <span class="meta-item">⭐ <?= $film['rating'] ?></span>
                        </div>
                        <a href="?reserve=<?= $film['id'] ?>" class="btn-primary small-btn">Rezervă</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</main>

<!-- Edit Modal -->
<div id="edit-modal" class="modal hidden">
    <div class="modal-content">
        <h3>Modifică ora rezervării</h3>
        <form method="POST">
            <input type="hidden" name="edit_film_id" id="edit-film-id">
            <div class="form-group">
                <label>Ora</label>
                <select name="new_time" id="edit-time">
                    <option value="14:00">14:00</option>
                    <option value="16:30">16:30</option>
                    <option value="19:00">19:00</option>
                    <option value="20:00">20:00</option>
                    <option value="22:00">22:00</option>
                </select>
            </div>
            <div class="modal-btns">
                <button type="submit" class="btn-primary">Salvează</button>
                <button type="button" class="btn-ghost" onclick="closeEdit()">Anulează</button>
            </div>
        </form>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <div class="footer-bottom">
            <p>© 2025 FilmSpot. Toate drepturile rezervate.</p>
        </div>
    </div>
</footer>

<script src="js/script.js"></script>
<script>
function openEdit(filmId, currentTime) {
    document.getElementById('edit-film-id').value = filmId;
    document.getElementById('edit-time').value = currentTime;
    document.getElementById('edit-modal').classList.remove('hidden');
}
function closeEdit() {
    document.getElementById('edit-modal').classList.add('hidden');
}
</script>
</body>
</html>
