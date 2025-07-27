<?php
require '../db.php';
// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);

// Update status menjadi 'Selesai'
$stmt = $conn->prepare("UPDATE sales SET status = 'Selesai' WHERE id_sales = ? AND status = 'Draft'");
$stmt->bind_param('i', $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $msg = 'Status berhasil diubah menjadi Selesai.';
} else {
    $msg = 'Status gagal diubah atau transaksi sudah selesai.';
}
$stmt->close();

header('Location: index.php?msg=' . urlencode($msg));
exit;
