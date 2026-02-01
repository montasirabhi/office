<?php
/**
 * OTP verify backend: validate OTP, set reset_email in session, redirect to reset page.
 */

require __DIR__ . '/init.php';

$loginUrl = '../Login/login.php';
$otpUrl = '../Login/otp.php';
$resetUrl = '../Login/reset.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($otpUrl);
}

$email = trim(strtolower($_POST['email'] ?? ''));
$otp = trim($_POST['otp'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^\d{6}$/', $otp)) {
    setFlash('error', 'Invalid email or OTP.');
    redirect($otpUrl . ($email ? '?email=' . rawurlencode($email) : ''));
}

try {
    $pdo = getDb();
    $stmt = $pdo->prepare(
        'SELECT id, user_type FROM otp_codes WHERE email = ? AND code = ? AND expires_at > NOW() AND used_at IS NULL ORDER BY id DESC LIMIT 1'
    );
    $stmt->execute([$email, $otp]);
    $row = $stmt->fetch();
} catch (PDOException $e) {
    setFlash('error', 'Service temporarily unavailable.');
    redirect($otpUrl . '?email=' . rawurlencode($email));
}

if (!$row) {
    setFlash('error', 'Invalid or expired OTP. Request a new one.');
    redirect($otpUrl . '?email=' . rawurlencode($email));
}

try {
    $pdo->prepare('UPDATE otp_codes SET used_at = NOW() WHERE id = ?')->execute([$row['id']]);
} catch (PDOException $e) {
    // continue
}

$_SESSION['reset_email'] = $email;
$_SESSION['reset_user_type'] = $row['user_type'];
setFlash('success', 'OTP verified. Set your new password.');
redirect($resetUrl);
