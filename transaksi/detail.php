<?php
require '../db.php';
include 'header.php';

$id_sales = $_GET['id'] ?? '';

// Ambil info penjualan
$sales = $conn->query("
    SELECT s.*, c.nama_customer 
    FROM sales s 
    JOIN customer c ON s.id_customer = c.id_customer 
    WHERE s.id_sales = $id_sales
")->fetch_assoc();

// Ambil item-item transaksi terkait
$detail = $conn->query("
    SELECT t.*, i.nama_item 
    FROM transaksi t 
    JOIN item i ON t.id_item = i.id_item 
    WHERE t.id_transaction = $id_sales
");
?>

<h2 class="mb-4">Detail Transaksi</h2>

<div class="mb-3">
    <strong>Tanggal:</strong> <?= htmlspecialchars($sales['tgl_sales']) ?><br>
    <strong>Customer:</strong> <?= htmlspecialchars($sales['nama_customer']) ?><br>
    <strong>DO Number:</strong> <?= htmlspecialchars($sales['do_number']) ?><br>
</div>


<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
    <?php $grand = 0; while ($row = $detail->fetch_assoc()):
        $total = $row['price'] * $row['quantity'];
        $grand += $total;
    ?>
        <tr>
            <td><?= htmlspecialchars($row['nama_item']) ?></td>
            <td>Rp <?= number_format($row['price'], 2, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['quantity']) ?></td>
            <td>Rp <?= number_format($total, 2, ',', '.') ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3">Grand Total</th>
            <th colspan="2"><strong>Rp <?= number_format($grand, 2, ',', '.') ?></strong></th>
        </tr>
    </tfoot>
</table>

<a href="index.php" class="btn btn-secondary">&larr; Kembali ke Daftar</a>

<?php include 'footer.php'; ?>
