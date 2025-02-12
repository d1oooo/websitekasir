<?php
session_start();
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['namaproduk'], $_POST['pencipta'], $_POST['harga'], $_POST['stok'])) {
    $namaproduk = $_POST['namaproduk'];
    $pencipta = $_POST['pencipta'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    
    $query = "INSERT INTO produk (namaproduk, pencipta, harga, stok) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    
    try {
        $stmt->execute([$namaproduk, $pencipta, $harga, $stok]);
        echo "Produk berhasil ditambahkan.";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Produk Baru</h2>
        <form action="addproduct.php" method="POST">
            <div class="form-group">
                <label for="namaproduk">Nama Buku</label>
                <input type="text" name="namaproduk" id="namaproduk" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="pencipta">Pencipta</label>
                <textarea name="pencipta" id="pencipta" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="harga">Harga Produk</label>
                <input type="number" name="harga" id="harga" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok Produk</label>
                <input type="number" name="stok" id="stok" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Tambah Produk</button>
        </form>
    </div>

    <script src="public/js/bootstrap.min.js"></script>
</body>
</html>
