<?php
require '../db.php';


$stmt = $conn->prepare("UPDATE customer SET nama_customer=?, alamat=?, telp=?, fax=?, email=? WHERE id_customer=?");
$stmt->bind_param("sssssi",
    $_POST['nama_customer'],
    $_POST['alamat'],
    $_POST['telp'],
    $_POST['fax'],
    $_POST['email'],
    $_POST['id_customer']
);

if ($stmt->execute()) {
    header("Location: index.php");
} else {
    echo "Gagal update data.";
}
