<?php
require '../db.php';
include 'header.php';

// Ambil keyword dari form
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Query dengan pencarian jika ada keyword
if ($keyword) {
    $stmt = $conn->prepare("SELECT * FROM item WHERE nama_item LIKE ?");
    $search = "%$keyword%";
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM item");
}
?>

<h2 class="mb-4">Manajemen Barang</h2>

<!-- FORM PENCARIAN -->
<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="keyword" class="form-control" placeholder="Cari nama barang..." value="<?= htmlspecialchars($keyword) ?>">
        <button class="btn btn-outline-secondary" type="submit">Cari</button>
        <?php if ($keyword): ?>
            <a href="index.php" class="btn btn-outline-danger">Reset</a>
        <?php endif; ?>
    </div>
</form>

<!-- TOMBOL TAMBAH -->
<a href="create.php" class="btn btn-primary mb-3">+ Tambah Barang</a>

<!-- TABEL BARANG -->
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nama Barang</th>
            <th>Satuan</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['nama_item'] ?></td>
            <td><?= $row['uom'] ?></td>
            <td><?= number_format($row['harga_beli'], 2, ',', '.') ?></td>
            <td><?= number_format($row['harga_jual'], 2, ',', '.') ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_item'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete.php?id=<?= $row['id_item'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    <?php else: ?>
        <tr><td colspan="5" class="text-center text-muted">Tidak ada data ditemukan.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<a href="../dashboard.php" class="btn btn-secondary">← Kembali ke Dashboard</a>

<?php include 'footer.php'; ?>
