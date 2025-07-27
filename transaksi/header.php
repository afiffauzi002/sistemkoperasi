<?php
require '../db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6dd5ed 0%, #2193b0 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            margin-top: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(33,147,176,0.15);
        }
        h2 {
            font-weight: 700;
            color: #2193b0;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }
        .table td {
            vertical-align: middle;
        }
        .btn {
            min-width: 90px;
            border-radius: 6px;
        }
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 500;
        }
        .form-control, .form-select {
            border-radius: 6px;
        }
        .alert {
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="container">
