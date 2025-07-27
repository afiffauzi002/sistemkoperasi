<?php include 'header.php'; ?>
<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="alert alert-success">Data berhasil disimpan.</div>
<?php endif; ?>

<h2 class="mb-4">Tambah Customer</h2>
<form action="store.php" method="POST">
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama_customer" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Telp</label>
        <input type="text" name="telp" class="form-control">
    </div>
    <div class="mb-3">
        <label>Fax</label>
        <input type="text" name="fax" class="form-control">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="../dashboard.php" class="btn btn-secondary">Kembali</a>
</form>

<?php include 'footer.php'; ?>
