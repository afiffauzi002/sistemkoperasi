<?php
require '../db.php';
include 'header.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM customer WHERE id_customer = $id")->fetch_assoc();
?>

<h2 class="mb-4">Edit Customer</h2>
<form action="update.php" method="POST">
    <input type="hidden" name="id_customer" value="<?= $data['id_customer'] ?>">

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama_customer" value="<?= $data['nama_customer'] ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Alamat</label>
        <textarea name="alamat" class="form-control"><?= $data['alamat'] ?></textarea>
    </div>
    <div class="mb-3">
        <label>Telp</label>
        <input type="text" name="telp" value="<?= $data['telp'] ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>Fax</label>
        <input type="text" name="fax" value="<?= $data['fax'] ?>" class="form-control">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="<?= $data['email'] ?>" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

<?php include 'footer.php'; ?>
