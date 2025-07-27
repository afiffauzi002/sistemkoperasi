<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sales = $_POST['id_transaction'] ?? '';
    $id_item  = $_POST['id_item'] ?? '';
    $price    = $_POST['price'] ?? '';
    $qty      = $_POST['quantity'] ?? '';
    $amount   = is_numeric($price) && is_numeric($qty) ? $price * $qty : 0;

    if ($id_sales && $id_item && is_numeric($price) && is_numeric($qty) && $amount > 0) {
        $stmt = $conn->prepare("INSERT INTO transaksi (id_transaction, id_item, price, quantity, amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iidid", $id_sales, $id_item, $price, $qty, $amount);
        if ($stmt->execute()) {
            header("Location: detail.php?id=$id_sales&status=success");
            exit;
        } else {
            header("Location: create.php?id=$id_sales&error=" . urlencode($stmt->error));
            exit;
        }
    } else {
        header("Location: create.php?id=$id_sales&error=Data tidak lengkap atau salah");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
