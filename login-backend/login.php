<?php
/**
 * Login backend: validate credentials against admins or users, set session, redirect.
 */

require __DIR__ . '/init.php';

$loginUrl = '../Login/login.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($loginUrl);
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    setFlash('error', 'Please enter username/email and password.');
    redirect($loginUrl);
}

try {
    $pdo = getDb();
    $user = null;
    $role = null;

    // Check admins first
    $stmt = $pdo->prepare('SELECT id, email, password_hash, name FROM admins WHERE email = ? LIMIT 1');
    $stmt->execute([$username]);
    $row = $stmt->fetch();
    if ($row) {
        $user = $row;
        $role = 'admin';
    }

    // Then check users
    if (!$user) {
        $stmt = $pdo->prepare('SELECT id, email, password_hash, name FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        if ($row) {
            $user = $row;
            $role = 'user';
        }
    }
} catch (PDOException $e) {
    setFlash('error', 'Service temporarily unavailable.');
    redirect($loginUrl);
}

if (!$user || !password_verify($password, $user['password_hash'])) {
    setFlash('error', 'Invalid username or password.');
    redirect($loginUrl);
}

$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_name'] = $user['name'] ?? $user['email'];
$_SESSION['user_role'] = $role;
unset($_SESSION['reset_email'], $_SESSION['reset_user_type'], $_SESSION['flash']);

setFlash('success', 'Welcome back, ' . ($user['name'] ?: $user['email']) . '.');

redirect('../Login/login.php?welcome=1');