<?php
session_start();
include "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

if (isset($_GET['add'])) {
    $pid = $_GET['add'];
    $_SESSION['wishlist'][$pid] = true;
}

if (isset($_GET['remove'])) {
    $pid = $_GET['remove'];
    unset($_SESSION['wishlist'][$pid]);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Wishlist</title>
    <link rel="stylesheet" href="style.css?v=6">
</head>
<body>
    <h2>💖 Your Wishlist</h2>
    <a href="home.php" class="btn">← Back to Shop</a>

    <div class="products">
        <?php
        if (empty($_SESSION['wishlist'])) {
            echo "<p>Your wishlist is empty.</p>";
        } else {
            foreach ($_SESSION['wishlist'] as $pid => $_) {
                $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->bind_param("i", $pid);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($row = $res->fetch_assoc()) {
                    echo "<div class='product'>
                            <img src='images/{$row['image']}' alt='{$row['name']}' height='150'><br>
                            <strong>{$row['name']}</strong><br>
                            ₹{$row['price']}<br>
                            <a href='cart.php?add={$row['id']}' class='btn'>Add to Cart</a>
                            <a href='wishlist.php?remove={$row['id']}' class='btn'>Remove</a>
                          </div>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
