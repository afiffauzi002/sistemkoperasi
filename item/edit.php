<?php
require '../db.php';
include 'header.php';

$id = $_GET['id'] ?? '';
$data = $conn->query("SELECT * FROM item WHERE id_item = $id")->fetch_assoc();
?>

<h2 class="mb-4">Edit Barang</h2>
<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="update.php" method="POST">
            <input type="hidden" name="id_item" value="<?= htmlspecialchars($data['id_item']) ?>">
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_item" value="<?= htmlspecialchars($data['nama_item']) ?>" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Satuan (UOM)</label>
                <input type="text" name="uom" value="<?= htmlspecialchars($data['uom']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Beli</label>
                <input type="number" name="harga_beli" value="<?= htmlspecialchars($data['harga_beli']) ?>" step="0.01" min="0" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Jual</label>
                <input type="number" name="harga_jual" value="<?= htmlspecialchars($data['harga_jual']) ?>" step="0.01" min="0" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
