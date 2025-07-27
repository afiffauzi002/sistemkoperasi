<?php
require '../db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM sales WHERE id_sales = $id");
header("Location: index.php");
