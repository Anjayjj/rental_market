<?php
// File uji coba - hapus setelah debugging selesai
echo '<h1>PHP Berjalan</h1>';
echo '<p>PHP Version: ' . phpversion() . '</p>';
echo '<p>PDO MySQL: ' . (extension_loaded('pdo_mysql') ? 'ADA' : 'TIDAK ADA') . '</p>';
echo '<p>File ini ada di: ' . __FILE__ . '</p>';

// Cek apakah config.php bisa dibaca
$configFile = __DIR__ . '/app/config/config.php';
echo '<p>config.php ada: ' . (file_exists($configFile) ? 'YA' : 'TIDAK') . '</p>';

// Cek apakah init.php bisa dibaca
$initFile = __DIR__ . '/app/init.php';
echo '<p>init.php ada: ' . (file_exists($initFile) ? 'YA' : 'TIDAK') . '</p>';

// Coba koneksi database
require_once 'app/config/config.php';
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    echo '<p style="color:green;">Database: TERHUBUNG</p>';
} catch (PDOException $e) {
    echo '<p style="color:red;">Database: GAGAL - ' . htmlspecialchars($e->getMessage()) . '</p>';
}
