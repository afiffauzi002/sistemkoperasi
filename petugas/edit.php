<?php
require '../db.php';
include 'header.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM petugas WHERE id_user = $id")->fetch_assoc();
?>

<h2 class="mb-4">Edit Petugas</h2>
<div class="row justify-content-center">
    <div class="col-md-6">
        <form method="POST" action="update.php">
            <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama_user" class="form-control" value="<?= $data['nama_user'] ?>" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password <span class="text-muted">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>