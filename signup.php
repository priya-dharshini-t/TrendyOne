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
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="form-page">
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
