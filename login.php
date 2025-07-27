<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM petugas WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6dd5ed 0%, #2193b0 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
        }
        .login-container {
            background: #fff;
            padding: 35px 30px 25px 30px;
            max-width: 400px;
            margin: 60px auto;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(33,147,176,0.15);
        }
        .login-title {
            font-weight: 700;
            color: #2193b0;
            margin-bottom: 25px;
            text-align: center;
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .form-control {
            border-radius: 6px;
        }
        .btn-login {
            background: linear-gradient(90deg, #2193b0 0%, #6dd5ed 100%);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            padding: 10px;
            width: 100%;
            margin-top: 10px;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background: linear-gradient(90deg, #6dd5ed 0%, #2193b0 100%);
        }
        .register-link {
            text-align: center;
            margin-top: 18px;
        }
        .alert-danger {
            border-radius: 6px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2 class="login-title">Login Petugas</h2>
    <form method="post">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-login">Login</button>
    </form>
</div>

</body>
</html>
