<?php include 'header.php'; ?>

<h2 class="mb-4">Tambah Petugas</h2>
<div class="row justify-content-center">
    <div class="col-md-6">
        <form method="POST" action="store.php">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama_user" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>