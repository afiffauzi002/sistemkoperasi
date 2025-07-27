<?php
require '../db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM customer WHERE id_customer = $id");
header("Location: index.php");
