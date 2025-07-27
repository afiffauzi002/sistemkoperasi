<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "koperasi";

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>