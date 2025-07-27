<?php
require '../db.php';
include 'header.php';
$id = $_GET['id'];
$conn->query("DELETE FROM item WHERE id_item = $id");
header("Location: index.php");
?>
<?php include 'header.php'; ?>