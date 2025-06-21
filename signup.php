<?php
session_start();
include "config.php";

if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $pass);

    if ($stmt->execute()) {
        echo "<script>alert('Registered successfully! Please login.'); window.location='login.php';</script>";
    } else {
        echo "<script>alert('Signup failed: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup - TrendyOne</title>
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
            padding: 90px 40px;
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
    <h2>Signup</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="signup" class="btn">Signup</button>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </form>
</div>
</body>
</html>
