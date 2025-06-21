<?php
session_start();
include "config.php";

// Initialize cart session if needed
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ✅ First: Handle add to cart (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $pid = $_POST['id'];
    $size = $_POST['size'] ?? '';
    $found = false;

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $pid && $item['size'] == $size) {
            $item['qty'] += 1;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $pid,
            'size' => $size,
            'qty' => 1
        ];
    }
}

// ✅ Then: Require login only to *view* cart
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// ✅ Remove item
if (isset($_GET['remove'])) {
    $index = $_GET['remove'];
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 45px;
            gap: 15px;
            background: #f9f9f9;
            padding: 10px;
            border-radius: 10px;
        }

        .cart-item img {
            border-radius: 8px;
        }

        .remove {
            margin-left: auto;
            color: red;
            text-decoration: none;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }

        .btn {
            background: #28a745;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
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
            foreach ($_SESSION['cart'] as $index => $item) {
                $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->bind_param("i", $item['id']);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($product = $res->fetch_assoc()) {
                    $subtotal = $product['price'] * $item['qty'];
                    echo "<div class='cart-item'>
                            <img src='images/{$product['image']}' width='80'>
                            <div>
                                <strong>{$product['name']}</strong><br>
                                ₹{$product['price']} × {$item['qty']} = ₹$subtotal<br>
                                <small>Size: {$item['size']}</small>
                            </div>
                            <a href='cart.php?remove={$index}' class='remove'>Remove</a>
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
