<?php
include 'db.php';
include 'verifikasi.php';


$stmt = $pdo->query("SELECT * FROM produk");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Product Management</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['idproduk'] ?></td>
                    <td><?= $product['namaproduk'] ?></td>
                    <td><?= $product['pencipta'] ?></td>
                    <td><?= $product['harga'] ?></td>
                    <td><?= $product['stok'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
