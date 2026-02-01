<?php
/**
 * Reset password backend: validate new password, update admins or users, redirect to login.
 */

require __DIR__ . '/init.php';

$loginUrl = '../Login/login.php';
$resetUrl = '../Login/reset.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($resetUrl);
}

$email = $_SESSION['reset_email'] ?? trim($_POST['email'] ?? '');
$userType = $_SESSION['reset_user_type'] ?? 'user';
$newPassword = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    setFlash('error', 'Session expired. Please request a new OTP.');
    unset($_SESSION['reset_email'], $_SESSION['reset_user_type']);
    redirect($loginUrl);
}

if (strlen($newPassword) < 6) {
    setFlash('error', 'Password must be at least 6 characters.');
    redirect($resetUrl);
}

if ($newPassword !== $confirmPassword) {
    setFlash('error', 'Passwords do not match.');
    redirect($resetUrl);
}

$table = ($userType === 'admin') ? 'admins' : 'users';
if (!in_array($table, ['admins', 'users'], true)) {
    $table = 'users';
}

try {
    $pdo = getDb();
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE {$table} SET password_hash = ?, updated_at = NOW() WHERE email = ?");
    $stmt->execute([$hash, $email]);
    if ($stmt->rowCount() === 0) {
        setFlash('error', 'User not found. Please request a new OTP.');
        redirect($loginUrl);
    }
} catch (PDOException $e) {
    setFlash('error', 'Service temporarily unavailable.');
    redirect($resetUrl);
}

unset($_SESSION['reset_email'], $_SESSION['reset_user_type']);
setFlash('success', 'Password updated. You can sign in now.');
redirect($loginUrl);