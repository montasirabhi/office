<?php
/**
 * Bootstrap: session and common setup for login backend.
 */

session_start();

require __DIR__ . '/config/database.php';

function redirect(string $url, int $code = 302): void {
    header('Location: ' . $url, true, $code);
    exit;
}

function setFlash(string $key, string $message): void {
    $_SESSION['flash'][$key] = $message;
}

function getFlash(string $key): ?string {
    $msg = $_SESSION['flash'][$key] ?? null;
    if ($msg !== null) {
        unset($_SESSION['flash'][$key]);
    }
    return $msg;
}

function loginBaseUrl(): string {
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $base = dirname(dirname($script));
    return rtrim($base, '/') . '/Login';
}
