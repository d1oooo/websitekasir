<?php
require 'db.php'; // Menyesuaikan dengan nama file database.php Anda

// Contoh data user admin dan kasir
$users = [
    ['username' => 'admin', 'password' => password_hash('admin123', PASSWORD_DEFAULT), 'role' => 'admin'],
    ['username' => 'kasir', 'password' => password_hash('kasir123', PASSWORD_DEFAULT), 'role' => 'kasir'],
];

try {
    // Insert user ke database
    foreach ($users as $user) {
        $query = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $query->execute([
            'username' => $user['username'],
            'password' => $user['password'],
            'role'     => $user['role']
        ]);
    }

    echo "Data user berhasil dimasukkan!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
