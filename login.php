<?php
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
    <title>Login - Fashion Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="form-page">
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
