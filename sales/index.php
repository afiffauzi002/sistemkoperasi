<?php
require '../db.php';
include 'header.php';

// Ambil keyword pencarian
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

// Query dengan filter
if ($keyword) {
    $stmt = $conn->prepare("
        SELECT s.*, c.nama_customer,
            (
                SELECT GROUP_CONCAT(COALESCE(i.nama_item, '-') SEPARATOR ', ')
                FROM transaksi t 
                LEFT JOIN item i ON t.id_item = i.id_item 
                WHERE t.id_transaction = s.id_sales
            ) AS daftar_barang,
            (
                SELECT SUM(t.quantity) 
                FROM transaksi t 
                WHERE t.id_transaction = s.id_sales
            ) AS total_qty,
            (
                SELECT SUM(t.quantity * t.price) 
                FROM transaksi t 
                WHERE t.id_transaction = s.id_sales
            ) AS total_harga
        FROM sales s 
        LEFT JOIN customer c ON s.id_customer = c.id_customer
        WHERE c.nama_customer LIKE ? OR s.do_number LIKE ?
        ORDER BY s.tgl_sales DESC
    ");
    $param = "%$keyword%";
    $stmt->bind_param("ss", $param, $param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("
        SELECT s.*, c.nama_customer,
            (
                SELECT GROUP_CONCAT(COALESCE(i.nama_item, '-') SEPARATOR ', ')
                FROM transaksi t 
                LEFT JOIN item i ON t.id_item = i.id_item 
                WHERE t.id_transaction = s.id_sales
            ) AS daftar_barang,
            (
                SELECT SUM(t.quantity) 
                FROM transaksi t 
                WHERE t.id_transaction = s.id_sales
            ) AS total_qty,
            (
                SELECT SUM(t.quantity * t.price) 
                FROM transaksi t 
                WHERE t.id_transaction = s.id_sales
            ) AS total_harga
        FROM sales s 
        LEFT JOIN customer c ON s.id_customer = c.id_customer
        ORDER BY s.tgl_sales DESC
    ");
}
?>


<div class="container py-4">
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['msg']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <h2 class="mb-4">Daftar Transaksi Penjualan</h2>

    <!-- Form Pencarian -->
    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="keyword" class="form-control" placeholder="Cari berdasarkan nama customer atau DO number..." value="<?= htmlspecialchars($keyword) ?>">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
            <?php if ($keyword): ?>
                <a href="index.php" class="btn btn-outline-danger">Reset</a>
            <?php endif; ?>
        </div>
    </form>

    <a href="create.php" class="btn btn-primary mb-3">+ Tambah Transaksi</a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>DO Number</th>
                <th>Barang</th>
                <th>Qty</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['tgl_sales']) ?></td>
                <td><?= htmlspecialchars($row['nama_customer']) ?></td>
                <td><?= htmlspecialchars($row['do_number']) ?></td>
                <td><?= htmlspecialchars($row['daftar_barang'] ?? '-') ?></td>
                <td><?= $row['total_qty'] !== null ? (int)$row['total_qty'] : 0 ?></td>
                <td>Rp <?= number_format($row['total_harga'] ?? 0, 0, ',', '.') ?></td>
                <td>
                    <?php if ($row['status'] === 'Draft'): ?>
                        <span class="badge bg-warning text-dark">Draft</span>
                    <?php elseif ($row['status'] === 'Selesai'): ?>
                        <span class="badge bg-success">Selesai</span>
                    <?php else: ?>
                        <span class="badge bg-secondary"><?= htmlspecialchars($row['status']) ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="edit.php?id=<?= $row['id_sales'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete.php?id=<?= $row['id_sales'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus transaksi ini?')">Hapus</a>
                        <?php if ($row['status'] === 'Draft'): ?>
                            <a href="selesai.php?id=<?= $row['id_sales'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Ubah status transaksi menjadi Selesai?')">Selesai</a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8" class="text-center text-muted">Tidak ada transaksi ditemukan.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <a href="../dashboard.php" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>
</div>

<?php include 'footer.php'; ?>
