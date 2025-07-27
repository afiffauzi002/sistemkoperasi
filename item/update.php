<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_item    = $_POST['id_item'] ?? '';
    $nama_item  = $_POST['nama_item'] ?? '';
    $uom        = $_POST['uom'] ?? '';
    $harga_beli = $_POST['harga_beli'] ?? '';
    $harga_jual = $_POST['harga_jual'] ?? '';

    if ($id_item && $nama_item && $uom && is_numeric($harga_beli) && is_numeric($harga_jual)) {
        $stmt = $conn->prepare("UPDATE item SET nama_item=?, uom=?, harga_beli=?, harga_jual=? WHERE id_item=?");
        $stmt->bind_param("ssddi", $nama_item, $uom, $harga_beli, $harga_jual, $id_item);
        if ($stmt->execute()) {
            header("Location: index.php?status=success");
            exit;
        } else {
            header("Location: edit.php?id=$id_item&error=" . urlencode($stmt->error));
            exit;
        }
    } else {
        header("Location: edit.php?id=$id_item&error=Data tidak lengkap atau salah");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}