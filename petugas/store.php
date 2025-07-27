<?php
require '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_user'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($nama && $username && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO petugas (nama_user, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $username, $hash);
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