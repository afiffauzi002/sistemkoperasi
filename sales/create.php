<?php
require '../db.php';
include 'header.php';

// Ambil daftar customer & item
$customers = $conn->query("SELECT * FROM customer");
$items = $conn->query("SELECT * FROM item");
?>

<h2 class="mb-4">Tambah Transaksi Penjualan</h2>
<div class="row justify-content-center">
    <div class="col-md-6">
        <form action="store.php" method="POST">
            <!-- Customer -->
            <div class="mb-3">
                <label class="form-label">Customer</label>
                <select name="id_customer" class="form-select" required>
                    <option value="">-- Pilih Customer --</option>
                    <?php while($row = $customers->fetch_assoc()): ?>
                        <option value="<?= $row['id_customer'] ?>">
                            <?= htmlspecialchars($row['nama_customer']) ?> - <?= htmlspecialchars($row['alamat']) ?> - <?= htmlspecialchars($row['telp']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Tanggal -->
            <div class="mb-3">
                <label class="form-label">Tanggal Transaksi</label>
                <input type="date" name="tgl_sales" class="form-control" required>
            </div>

            <!-- DO Number -->
            <div class="mb-3">
                <label class="form-label">DO Number</label>
                <input type="text" name="do_number" class="form-control" required>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="Draft">Draft</option>
                </select>
            </div>

            <!-- Barang -->
            <div class="mb-3">
                <label class="form-label">Barang</label>
                <select name="id_item" id="barang" class="form-select" onchange="setHarga()" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($items as $item): ?>
                        <option value="<?= $item['id_item'] ?>"><?= $item['nama_item'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Harga -->
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" id="harga" class="form-control" readonly>
            </div>

            <!-- Quantity -->
            <div class="mb-3">
                <label class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" required oninput="hitungTotal()">
            </div>

            <!-- Total -->
            <div class="mb-3">
                <label class="form-label">Total</label>
                <input type="number" id="total" class="form-control" readonly>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>

<!-- JavaScript Autofill -->
<script>
    const hargaBarang = {};
    <?php foreach ($items as $item): ?>
        hargaBarang["<?= $item['id_item'] ?>"] = <?= $item['harga_jual'] ?>;
    <?php endforeach; ?>

    function setHarga() {
        const idItem = document.getElementById('barang').value;
        const harga = hargaBarang[idItem] || 0;
        document.getElementById('harga').value = harga;
        hitungTotal();
    }

    function hitungTotal() {
        const harga = parseFloat(document.getElementById('harga').value) || 0;
        const qty = parseInt(document.getElementById('quantity').value) || 0;
        const total = harga * qty;
        document.getElementById('total').value = total;
    }
</script>

<?php include 'footer.php'; ?>
