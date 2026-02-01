<?php
/**
 * Forgot password backend: generate OTP, store in DB (with user_type), send email, redirect to OTP page.
 */

require __DIR__ . '/init.php';

$loginUrl = '../Login/login.php';
$forgotUrl = '../Login/forgot.php';
$otpUrl = '../Login/otp.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($forgotUrl);
}

$email = trim(strtolower($_POST['email'] ?? ''));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    setFlash('error', 'Please enter a valid email address.');
    redirect($forgotUrl);
}

try {
    $pdo = getDb();
    $userType = null;

    $stmt = $pdo->prepare('SELECT id FROM admins WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $userType = 'admin';
    }
    if (!$userType) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $userType = 'user';
        }
    }

    if (!$userType) {
        setFlash('info', 'If that email is registered, you will receive an OTP shortly.');
        redirect($otpUrl . '?email=' . rawurlencode($email));
    }

    $code = (string) random_int(100000, 999999);
    $expiresAt = date('Y-m-d H:i:s', time() + 600);

    $pdo->prepare('UPDATE otp_codes SET used_at = NOW() WHERE email = ?')->execute([$email]);
    $stmt = $pdo->prepare('INSERT INTO otp_codes (email, user_type, code, expires_at) VALUES (?, ?, ?, ?)');
    $stmt->execute([$email, $userType, $code, $expiresAt]);
} catch (PDOException $e) {
    setFlash('error', 'Service temporarily unavailable.');
    redirect($forgotUrl);
}

$subject = 'MSKS – Password reset OTP';
$body = "Your OTP is: $code\nIt expires in 10 minutes.";
$headers = 'From: noreply@msks.local';
@mail($email, $subject, $body, $headers);

setFlash('info', 'If that email is registered, you will receive an OTP shortly.');
redirect($otpUrl . '?email=' . rawurlencode($email));