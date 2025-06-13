<?php
session_start(); // VERY IMPORTANT
include "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to cart
if (isset($_GET['add'])) {
    $pid = $_GET['add'];
    if (isset($_SESSION['cart'][$pid])) {
        $_SESSION['cart'][$pid] += 1; // Increment quantity
    } else {
        $_SESSION['cart'][$pid] = 1;
    }
}

// Remove from cart
if (isset($_GET['remove'])) {
    $pid = $_GET['remove'];
    unset($_SESSION['cart'][$pid]);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="topbar">
        <h2>🛒 Your Shopping Cart</h2>
        <a href="home.php" class="btn">← Back to Shop</a>
    </div>

    <div class="cart-list">
        <?php
        $total = 0;
        if (empty($_SESSION['cart'])) {
            echo "<p>Your cart is empty.</p>";
        } else {
            foreach ($_SESSION['cart'] as $pid => $qty) {
                $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->bind_param("i", $pid);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($item = $res->fetch_assoc()) {
                    $subtotal = $item['price'] * $qty;
                    echo "<div class='cart-item'>
                            <img src='images/{$item['image']}' width='80'>
                            <div>
                                <strong>{$item['name']}</strong><br>
                                ₹{$item['price']} x $qty = ₹$subtotal
                            </div>
                            <a href='cart.php?remove={$pid}' class='remove'>Remove</a>
                          </div>";
                    $total += $subtotal;
                }
            }
            echo "<hr><h3>Total: ₹{$total}</h3>";
            echo "<a href='checkout.php' class='btn'>Proceed to Checkout</a>";
        }
        ?>
    </div>
</body>

</html>
