<?php
session_start();
require 'db.php';

$role = $_SESSION['role'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="mb-3">Selamat Datang, <?= htmlspecialchars($username); ?>!</h1>
            <p class="fs-5">Role Anda: <span class="badge bg-info"><?= ucfirst($role); ?></span></p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Menu</h2>
                    <div class="list-group">
                        <?php if ($role === 'admin'): ?>
                            <a href="addproduct.php" class="list-group-item list-group-item-action">Tambah Produk</a>
                            <a href="addstock.php" class="list-group-item list-group-item-action">Tambah Stok</a>
                            <a href="product.php" class="list-group-item list-group-item-action">Cek Gudang</a>
                            <a href="add_user.php" class="list-group-item list-group-item-action">Tambah User</a>
                        <?php endif; ?>
                        <a href="transactions.php" class="list-group-item list-group-item-action">Transaksi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="bg-primary text-white text-center py-3 mt-5">
    <p class="mb-0">&copy; <?= date('Y'); ?> Your Company. All Rights Reserved.</p>
</footer>

<script src="public/js/bootstrap.min.js"></script>
</body>
</html>
