<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = $_POST['nama_customer'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $telp   = $_POST['telp'] ?? '';
    $fax    = $_POST['fax'] ?? '';
    $email  = $_POST['email'] ?? '';

    if ($nama && $alamat && $telp && $email) {
        $stmt = $conn->prepare("INSERT INTO customer (nama_customer, alamat, telp, fax, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama, $alamat, $telp, $fax, $email);
        if ($stmt->execute()) {
            header("Location: index.php?status=success");
            exit;
        } else {
            header("Location: index.php?status=error&msg=" . urlencode($stmt->error));
            exit;
        }
    } else {
        header("Location: index.php?status=error&msg=Data tidak lengkap");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
