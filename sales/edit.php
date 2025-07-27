<?php
require '../db.php';
include 'header.php';

$id = $_GET['id'] ?? '';
$data = $conn->query("SELECT * FROM sales WHERE id_sales = $id")->fetch_assoc();
$customers = $conn->query("SELECT * FROM customer");
if (!$data) {
    echo '<div class="alert alert-danger">Data transaksi tidak ditemukan.</div>';
    include 'footer.php';
    exit;
}
?>

<h2 class="mb-4">Edit Transaksi</h2>
<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="update.php" method="POST">
            <input type="hidden" name="id_sales" value="<?= htmlspecialchars($data['id_sales']) ?>">
            <div class="mb-3">
                <label class="form-label">Customer</label>
                <select name="id_customer" class="form-select" required>
                    <?php while($row = $customers->fetch_assoc()): ?>
                        <option value="<?= $row['id_customer'] ?>" <?= $row['id_customer'] == $data['id_customer'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['nama_customer']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Transaksi</label>
                <input type="date" name="tgl_sales" value="<?= htmlspecialchars($data['tgl_sales']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">DO Number</label>
                <input type="text" name="do_number" value="<?= htmlspecialchars($data['do_number']) ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
