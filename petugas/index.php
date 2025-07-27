<?php
require '../db.php';
include 'header.php';

$result = $conn->query("SELECT id_user, nama_user, username FROM petugas");
?>

<div class="container">
    <h2 class="mb-4">Manajemen Petugas</h2>

    <a href="create.php" class="btn btn-success mb-3">+ Tambah Petugas</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nama_user'] ?></td>
                <td><?= $row['username'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id_user'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $row['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="../dashboard.php" class="btn btn-secondary">&larr; Kembali</a>
</div>

<?php include 'footer.php'; ?>
