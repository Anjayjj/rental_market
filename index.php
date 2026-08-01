<?php
// Debug: tampilkan semua error PHP
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Cek apakah file init.php ada
$initFile = __DIR__ . '/app/init.php';
if (!file_exists($initFile)) {
    die('ERROR: app/init.php tidak ditemukan di ' . $initFile);
}

require_once $initFile;
