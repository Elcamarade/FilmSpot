<?php
require_once __DIR__ . '/functions.php';

function loginUser($email, $password) {
    $users = readJSON('data/users.json');
    foreach ($users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'name'  => $user['name'],
                'email' => $user['email'],
            ];
            return true;
        }
    }
    return 'Email sau parolă incorectă.';
}

function registerUser($name, $email, $password) {
    $users = readJSON('data/users.json');
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return 'Există deja un cont cu acest email.';
        }
    }
    $users[] = [
        'id'           => uniqid(),
        'name'         => $name,
        'email'        => $email,
        'password'     => password_hash($password, PASSWORD_DEFAULT),
        'created_at'   => date('Y-m-d H:i:s'),
        'reservations' => [],
    ];
    saveJSON('data/users.json', $users);
    return true;
}

function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }
}
