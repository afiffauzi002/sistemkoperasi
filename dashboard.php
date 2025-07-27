<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
require 'db.php';

// Ambil statistik
$jumlah_customer = $conn->query("SELECT COUNT(*) AS total FROM customer")->fetch_assoc()['total'];
$jumlah_item = $conn->query("SELECT COUNT(*) AS total FROM item")->fetch_assoc()['total'];
$jumlah_sales = $conn->query("SELECT COUNT(*) AS total FROM sales")->fetch_assoc()['total'];
$total_penjualan = $conn->query("SELECT SUM(amount) AS total FROM transaksi")->fetch_assoc()['total'];
$total_penjualan = $total_penjualan ?? 0;
$status_draft = $conn->query("SELECT COUNT(*) as total FROM sales WHERE status = 'Draft'")->fetch_assoc()['total'];
$status_selesai = $conn->query("SELECT COUNT(*) as total FROM sales WHERE status = 'Selesai'")->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Koperasi</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }
        .wrapper {
            display: flex;
            height: 100vh;
        }
        .sidebar {
            width: 220px;
            background: linear-gradient(135deg, #2193b0 0%, #6dd5ed 100%);
            color: white;
            padding-top: 30px;
            display: flex;
            flex-direction: column;
            height: 100vh;
            box-shadow: 2px 0 12px rgba(33,147,176,0.08);
        }
        .sidebar h2 {
            text-align: center;
            font-size: 22px;
            margin-bottom: 30px;
            letter-spacing: 2px;
            font-weight: bold;
            color: #fff;
            text-shadow: 0 2px 8px rgba(33,147,176,0.15);
        }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 6px;
            margin: 4px 12px;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar a:not(.logout-btn):hover {
            background-color: rgba(255,255,255,0.12);
            color: #ffc107;
        }
        .sidebar .logout-btn {
            margin-top: auto;
            margin-bottom: 20px;
            background-color: #dc3545;
            color: white !important;
            text-align: center;
            border-radius: 6px;
            padding: 12px 20px;
            font-weight: bold;
            transition: background 0.2s;
            display: block;
        }
        .sidebar .logout-btn:hover {
            background-color: #b71c1c;
        }
        .sidebar a svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }
        .content {
            flex: 1;
            padding: 30px;
            background-color: #ffffff;
            overflow-y: auto;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar h1 {
            margin: 0;
        }
        .logout-link a {
            color: red;
            text-decoration: none;
        }
        .logout-link a:hover {
            text-decoration: underline;
        }
        .statistik-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .card {
            padding: 20px;
            background-color: #f1f1f1;
            border-left: 5px solid #007bff;
            border-radius: 8px;
        }
        .card h3 {
            margin: 0 0 10px;
            color: #333;
        }
        .card p {
            font-size: 24px;
            margin: 0;
            color: #007bff;
            font-weight: bold;
        }
        .chart-container {
            display: flex;
            gap: 40px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        .chart-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            flex: 1;
            min-width: 320px;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="sidebar">
        <h2>KOPERASI</h2>
        <a href="customer/index.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/></svg> Manajemen Customer</a>
        <a href="item/index.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 6H4V4h16v2zm0 2v12H4V8h16zm-2 2H6v8h12v-8z"/></svg> Manajemen Barang</a>
        <a href="sales/index.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0-8h2V7H3v2zm4 8h14v-2H7v2zm0-4h14v-2H7v2zm0-8v2h14V5H7z"/></svg> Transaksi Penjualan</a>
        <a href="transaksi/index.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zm-7-3h2v-2h-2v2zm0-4h2v-2h-2v2zm0-4h2V7h-2v2z"/></svg> Detail Transaksi</a>
        <a href="petugas/index.php"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/></svg> Manajemen Petugas</a>
        <a href="login.php" class="logout-btn">Logout</a>
    </div>
    <div class="content">
        <div class="topbar">
            <h1> Dashboard</h1>
            <div class="logout-link">
                Selamat datang, <strong><?php echo $_SESSION['user']['nama_user']; ?></strong>
            </div>
        </div>
        <hr>
        <p>Selamat datang di Aplikasi Pengadaan Barang dan Perlengkapan Rumah Tangga Koperasi Pegawai. Silakan pilih menu di sebelah kiri.</p>
        <!-- Statistik -->
        <div class="statistik-container">
            <div class="card">
                <h3>Jumlah Customer</h3>
                <p><?= $jumlah_customer ?></p>
            </div>
            <div class="card">
                <h3>Jumlah Barang</h3>
                <p><?= $jumlah_item ?></p>
            </div>
            <div class="card">
                <h3>Jumlah Transaksi</h3>
                <p><?= $jumlah_sales ?></p>
            </div>
            <div class="card">
                <h3>Total Penjualan</h3>
                <p>Rp <?= number_format($total_penjualan, 0, ',', '.') ?></p>
            </div>
        </div>
        <h3>Visualisasi Data</h3>
        <div class="chart-container">
            <div class="chart-box">
                <canvas id="barChart" height="120"></canvas>
            </div>
            <div class="chart-box">
                <canvas id="statusChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
    // Bar Chart: Jumlah data utama
    const barCtx = document.getElementById('barChart').getContext('2d');
    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Customer', 'Barang', 'Transaksi'],
            datasets: [{
                label: 'Jumlah Data',
                data: [<?= $jumlah_customer ?>, <?= $jumlah_item ?>, <?= $jumlah_sales ?>],
                backgroundColor: ['#007bff', '#28a745', '#ffc107']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
    // Doughnut Chart: Status transaksi
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Draft', 'Selesai'],
            datasets: [{
                data: [<?= $status_draft ?>, <?= $status_selesai ?>],
                backgroundColor: ['#6c757d', '#17a2b8']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
</body>
</html>
