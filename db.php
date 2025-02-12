<?php
// Informasi koneksi ke database
$host = 'localhost';     // Nama host server
$db = 'db_appkasirdio';  // Nama database
$user = 'root';          // Username database
$pass = '';              // Password database

try {
    // Membuat koneksi ke database menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Mengatur mode error agar memunculkan exception jika ada error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Mengatur mode fetch default ke associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Menangani error jika koneksi gagal
    die("Connection failed: " . $e->getMessage());
}
?>
