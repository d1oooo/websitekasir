<?php
session_start();
require 'db.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];
    $cash = $_POST['cash'];


    $stmt = $pdo->prepare("SELECT * FROM produk WHERE idproduk = ?");
    $stmt->execute([$idproduk]);
    $product = $stmt->fetch();

    if ($product) {
        $total = $product['harga'] * $qty;

        if ($cash >= $total) {
            $change = $cash - $total;

            $pdo->beginTransaction();
            try {
                $stmt = $pdo->prepare("INSERT INTO pesanan (tanggal, iduser) VALUES (NOW(), ?)");
                $stmt->execute([$_SESSION['iduser']]);
                $idpesanan = $pdo->lastInsertId();

                $stmt = $pdo->prepare("INSERT INTO detailpesanan (idpesanan, idproduk, qty) VALUES (?, ?, ?)");
                $stmt->execute([$idpesanan, $idproduk, $qty]);

                $pdo->commit();

                $success = "Transaksi berhasil! Total: Rp" . number_format($total) . ". Uang tunai: Rp" . number_format($cash) . ". Kembalian: Rp" . number_format($change);
            } catch (Exception $e) {
                $pdo->rollBack();
                $error = "Stok Tidak Cukup.";
            }
        } else {
            $error = "Uang tunai tidak mencukupi. Total pembayaran adalah Rp" . number_format($total);
        }
    } else {
        $error = "Produk tidak ditemukan.";
    }
}

$stmt = $pdo->query("SELECT * FROM produk");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script>
        function calculateTotal() {
            var qty = parseInt(document.getElementById('qty').value);
            var productSelect = document.getElementById('idproduk');
            var price = parseInt(productSelect.options[productSelect.selectedIndex].dataset.price);
            var total = qty * price;
            document.getElementById('total').value = total;
        }
    </script>
</head>
<body>
<div class="container mt-5">
    <h1>Transaksi</h1>

    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="idproduk" class="form-label">Produk</label>
            <select name="idproduk" id="idproduk" class="form-select" onchange="calculateTotal()" required>
                <option value="" disabled selected>Pilih produk</option>
                <?php foreach ($products as $product): ?>
                    <option value="<?= $product['idproduk'] ?>" data-price="<?= $product['harga'] ?>">
                        <?= htmlspecialchars($product['namaproduk']) ?> 
                        (Harga: Rp<?= number_format($product['harga']) ?> | Stok: <?= $product['stok'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="qty" class="form-label">Jumlah</label>
            <input type="number" name="qty" id="qty" class="form-control" min="1" required onchange="calculateTotal()">
        </div>
        <div class="mb-3">
            <label for="total" class="form-label">Total Harga</label>
            <input type="text" id="total" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="cash" class="form-label">Uang Tunai</label>
            <input type="number" name="cash" id="cash" class="form-control" min="0" required>
        </div>
        <button type="submit" name="calculate" class="btn btn-secondary">Hitung</button>
        <button type="submit" name="pay" class="btn btn-primary">Bayar</button>
    </form>
</div>

<script src="public/js/bootstrap.min.js"></script>
</body>
</html>
