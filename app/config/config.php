<?php
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
define('BASEURL', $protocol . '://' . $host . $scriptDir);

define('DB_HOST', '127.0.0.1:33060');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'rental_marketplace');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
