<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_item  = $_POST['nama_item'] ?? '';
    $uom        = $_POST['uom'] ?? '';
    $harga_beli = $_POST['harga_beli'] ?? '';
    $harga_jual = $_POST['harga_jual'] ?? '';

    if ($nama_item && $uom && is_numeric($harga_beli) && is_numeric($harga_jual)) {
        $stmt = $conn->prepare("INSERT INTO item (nama_item, uom, harga_beli, harga_jual) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdd", $nama_item, $uom, $harga_beli, $harga_jual);
        if ($stmt->execute()) {
            header("Location: index.php?status=success");
            exit;
        } else {
            header("Location: create.php?error=" . urlencode($stmt->error));
            exit;
        }
    } else {
        header("Location: create.php?error=Data tidak lengkap atau salah");
        exit;
    }
} else {
    header("Location: create.php");
    exit;
}