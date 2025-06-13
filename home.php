<?php
session_start();
include "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$filter = "%" . $search . "%";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - Fashion Store</title>
    <link rel="stylesheet" href="style.css?v=5">
    <style>
        .category-section {
            background: white;
            margin: 30px 20px;
            padding: 20px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .category-title {
            font-size: 22px;
            margin-bottom: 10px;
            color: #333;
            padding-left: 10px;
        }

        .view-more-overlay {
            position: absolute;
            bottom: 10px;
            right: 20px;
            background: rgba(255, 255, 255, 0.8);
            padding: 6px 12px;
            border-radius: 6px;
            z-index: 10;
        }

        .view-more-btn {
            color: #28a745;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .view-more-btn:hover {
            text-decoration: underline;
            color: #218838;
        }

        .products-container {
            padding: 10px 20px;
        }

        .topbar h2 {
            margin: 0;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-top: 10px;
        }

        .product img {
            height: 180px;
        }
    </style>
</head>
<body>
<div class="topbar">
    <h2>Fashion Store</h2>
    <form method="get" class="search-bar">
        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search products">
        <button type="submit">Search</button>
        <a href="cart.php">🛒 Cart</a>
        <a href="logout.php" style="margin-left: 20px;">Logout</a>
    </form>
</div>

<div class="category-bar">
    <?php
    $categories = ['T-Shirt', 'Shirts', 'Jeans','Trousers','Shorts', 'Suits and Blazers', 'Watch', 'Glasses', 'Shoes', 'Bags and Wallets'];
    foreach ($categories as $cat) {
        $active = $cat === $category ? "style='font-weight:bold; text-decoration:underline;'" : "";
        echo "<a href='?category=" . urlencode($cat) . "' $active>$cat</a>";
    }
    ?>
</div>

<div class="products-container">
<?php
if ($category) {
    echo "<h3 style='margin: 30px 20px 10px;'>$category</h3>";
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $res = $stmt->get_result();
    echo "<div class='products'>";
    while ($row = $res->fetch_assoc()) {
        echo "<div class='product'>
                <img src='images/{$row['image']}' alt='{$row['name']}'>
                <h3>{$row['name']}</h3>
                <p>₹{$row['price']}</p>
                <a href='cart.php?add={$row['id']}' class='btn'>Add to Cart</a>
              </div>";
    }
    echo "</div>";
} else {
    foreach ($categories as $cat) {
        echo "<div class='category-section'>";
        echo "<h3 class='category-title'>$cat</h3>";

        $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? LIMIT 5");
        $stmt->bind_param("s", $cat);
        $stmt->execute();
        $res = $stmt->get_result();

        echo "<div class='products'>";
        while ($row = $res->fetch_assoc()) {
            echo "<div class='product'>
                    <img src='images/{$row['image']}' alt='{$row['name']}'>
                    <h3>{$row['name']}</h3>
                    <p>₹{$row['price']}</p>
                    <a href='cart.php?add={$row['id']}' class='btn'>Add to Cart</a>
                  </div>";
        }
        echo "</div>"; // .products

        echo "<div class='view-more-overlay'>
                <a href='?category=" . urlencode($cat) . "' class='view-more-btn'>View More →</a>
              </div>";

        echo "</div>"; // .category-section
    }
}
?>
</div>
</body>
</html>
