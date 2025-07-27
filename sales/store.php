<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_customer = $_POST['id_customer'] ?? '';
    $tgl_sales   = $_POST['tgl_sales'] ?? '';
    $do_number   = $_POST['do_number'] ?? '';
    $status      = $_POST['status'] ?? '';

    if ($id_customer && $tgl_sales && $do_number && $status) {
        $stmt = $conn->prepare("INSERT INTO sales (id_customer, tgl_sales, do_number, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $id_customer, $tgl_sales, $do_number, $status);
        if ($stmt->execute()) {
            header("Location: index.php?status=success");
            exit;
        } else {
            header("Location: create.php?error=" . urlencode($stmt->error));
            exit;
        }
    } else {
        header("Location: create.php?error=Data tidak lengkap");
        exit;
    }
} else {
    header("Location: create.php");
    exit;
}
