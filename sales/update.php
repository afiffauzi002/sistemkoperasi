<?php
require '../db.php';

$id_sales    = $_POST['id_sales'] ?? '';
$id_customer = $_POST['id_customer'] ?? '';
$tgl_sales   = $_POST['tgl_sales'] ?? '';
$do_number   = $_POST['do_number'] ?? '';
$status      = $_POST['status'] ?? '';

if ($id_sales && $id_customer && $tgl_sales && $do_number && $status) {
    $stmt = $conn->prepare("UPDATE sales SET id_customer=?, tgl_sales=?, do_number=?, status=? WHERE id_sales=?");
    $stmt->bind_param("isssi", $id_customer, $tgl_sales, $do_number, $status, $id_sales);
    if ($stmt->execute()) {
        header("Location: index.php?status=success");
        exit;
    } else {
        header("Location: edit.php?id=$id_sales&error=" . urlencode($stmt->error));
        exit;
    }
} else {
    header("Location: edit.php?id=$id_sales&error=Data tidak lengkap");
    exit;
}