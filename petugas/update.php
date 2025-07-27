<?php
require '../db.php';
$id = $_POST['id_user'];
$nama = $_POST['nama_user'];
$username = $_POST['username'];
if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE petugas SET nama_user=?, username=?, password=? WHERE id_user=?");
    $stmt->bind_param("sssi", $nama, $username, $password, $id);
} else {
    $stmt = $conn->prepare("UPDATE petugas SET nama_user=?, username=? WHERE id_user=?");
    $stmt->bind_param("ssi", $nama, $username, $id);
}
$stmt->execute();
header("Location: index.php");