<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include "config.php";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($pass, $user['password'])) {
            $_SESSION['user'] = $user['email'];
            header("Location: home.php");
            exit();
        }
    }
    $error = "Invalid email or password!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - TrendyOne</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: DarkSeaGreen;
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-box {
            background: cornsilk;
            padding: 100px 40px;
            border-radius: 6px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 1.08);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .form-box h2 {
            color: #2D2E32;
            margin-bottom: 20px;
        }

        .form-box input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .btn {
            background-color: #28a745;
            color: white;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 12px;
        }

        .btn:hover {
            background-color: #6845e3;
        }

        .form-box a {
            color: #7F5AF0;
            text-decoration: none;
            font-weight: bold;
        }

        .form-box p {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login" class="btn">Login</button>
        <p>Don't have an account? <a href="signup.php">Signup</a></p>
    </form>
</div>
</body>
</html>
