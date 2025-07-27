<?php include 'header.php'; ?>

<h2 class="mb-4">Tambah Barang</h2>
<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="store.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_item" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Satuan (UOM)</label>
                <input type="text" name="uom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Beli</label>
                <input type="number" name="harga_beli" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Jual</label>
                <input type="number" name="harga_jual" class="form-control" step="0.01" min="0" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
