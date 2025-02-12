<?php
session_start();
include 'db.php'; 


$query = "SELECT idproduk, namaproduk FROM produk";
$stmt = $pdo->prepare($query);
$stmt->execute();
$produk = $stmt->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idproduk'], $_POST['qty'])) {
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    
    $query = "SELECT stok FROM produk WHERE idproduk = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$idproduk]);
    $produkData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($produkData) {
        $newStok = $produkData['stok'] + $qty;

        
        $updateQuery = "UPDATE produk SET stok = ? WHERE idproduk = ?";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([$newStok, $idproduk]);

        
        $insertQuery = "INSERT INTO masuk (idproduk, qty, tanggal) VALUES (?, ?, NOW())";
        $insertStmt = $pdo->prepare($insertQuery);
        $insertStmt->execute([$idproduk, $qty]);

        echo "Stok berhasil ditambahkan!";
    } else {
        echo "Produk tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Stok</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Stok Produk</h2>
        <form action="addstock.php" method="POST">
            <div class="form-group">
                <label for="idproduk">Pilih Produk</label>
                <select name="idproduk" id="idproduk" class="form-control" required>
                    <option value="">Pilih Produk</option>
                    <?php foreach ($produk as $item): ?>
                        <option value="<?= $item['idproduk'] ?>"><?= $item['namaproduk'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="qty">Jumlah Stok yang Ditambahkan</label>
                <input type="number" name="qty" id="qty" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Tambah Stok</button>
        </form>
    </div>

    <script src="public/js/bootstrap.min.js"></script>
</body>
</html>
