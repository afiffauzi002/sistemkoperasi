<?php
require '../db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM petugas WHERE id_user = $id");
header("Location: index.php");