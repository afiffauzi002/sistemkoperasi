</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

// index.php
<?php
require '../db.php';
include 'header.php';
$result = $conn->query("SELECT * FROM petugas");
?>
<h2 class="mb-4">Manajemen Petugas</h2>
<a href="create.php" class="btn btn-success mb-3">+ Tambah Petugas</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr><th>Nama</th><th>Username</th><th>Aksi</th></tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['nama_user'] ?></td>
            <td><?= $row['username'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id_user'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?= $row['id_user'] ?>" onclick="return confirm('Hapus?')" class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
<a href="../dashboard.php" class="btn btn-secondary">← Kembali</a>
<?php include 'footer.php'; ?>