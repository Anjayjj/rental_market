<?php
define('BASEURL', 'http://localhost:8080/rental_marketplace/public');

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