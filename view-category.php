<?php
session_start();
include "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$category = $_GET['category'] ?? '';
if (!$category) {
    echo "No category selected.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($category) ?> - Fashion Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="topbar">
    <h2>Fashion Store</h2>
    <a href="home.php" style="color:white;">⬅ Back to Home</a>
    <a href="cart.php" style="margin-left:20px;">🛒 Cart</a>
</div>

<h2 style="text-align:center; margin-top: 20px;"><?= htmlspecialchars($category) ?></h2>

<div class="products">
    <?php
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        echo "<p>No products found in this category.</p>";
    }

    while ($row = $res->fetch_assoc()) {
        echo "<div class='product'>
                <img src='images/{$row['image']}' alt='{$row['name']}'>
                <h3>{$row['name']}</h3>
                <p>₹{$row['price']}</p>
                <a href='cart.php?add={$row['id']}' class='btn'>Add to Cart</a>
              </div>";
    }
    ?>
</div>
</body>
</html>
