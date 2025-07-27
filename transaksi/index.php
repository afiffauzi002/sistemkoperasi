<?php
require '../db.php';
include 'header.php';

$sales = $conn->query("
    SELECT s.*, c.nama_customer 
    FROM sales s 
    JOIN customer c ON s.id_customer = c.id_customer
    ORDER BY s.tgl_sales DESC
");
?>

<h2 class="mb-4">Data Transaksi</h2>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Tanggal</th>
            <th>Customer</th>
            <th>DO Number</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $sales->fetch_assoc()): ?>
        <tr>
            <td><?= $row['tgl_sales'] ?></td>
            <td><?= $row['nama_customer'] ?></td>
            <td><?= $row['do_number'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a href="detail.php?id=<?= $row['id_sales'] ?>" class="btn btn-sm btn-info">Detail</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="../dashboard.php" class="btn btn-secondary">← Kembali</a>

<?php include 'footer.php'; ?>
