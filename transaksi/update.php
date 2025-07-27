<?php
require '../db.php';

$id_transaksi   = $_POST['id_transaksi'] ?? '';
$id_transaction = $_POST['id_transaction'] ?? '';
$price          = $_POST['price'] ?? '';
$quantity       = $_POST['quantity'] ?? '';
$amount         = is_numeric($price) && is_numeric($quantity) ? $price * $quantity : 0;

if ($id_transaksi && $id_transaction && is_numeric($price) && is_numeric($quantity) && $amount > 0) {
    $stmt = $conn->prepare("UPDATE transaksi SET price=?, quantity=?, amount=? WHERE id_transaksi=?");
    $stmt->bind_param("dddi", $price, $quantity, $amount, $id_transaksi);
    if ($stmt->execute()) {
        header("Location: detail.php?id=$id_transaction&status=success");
        exit;
    } else {
        header("Location: edit.php?id=$id_transaksi&error=" . urlencode($stmt->error));
        exit;
    }
} else {
    header("Location: edit.php?id=$id_transaksi&error=Data tidak lengkap atau salah");
    exit;
}
