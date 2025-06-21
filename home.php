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
$dressCategories = ['T-Shirt', 'Shirts', 'Jeans', 'Trousers', 'Shorts', 'Suits and Blazers'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - TrendyOne</title>
    <link rel="stylesheet" href="style.css?v=5">
    <style>
        .category-section {
            background: white;
            margin: 30px 20px;
            padding: 20px;
            border-radius: 12px;
            position: relative;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 60px;
        }
        .category-title {
            font-size: 22px;
            margin-bottom: 10px;
            color: #333;
            padding-left: 10px;
        }
        .view-more-overlay {
            position: absolute;
            bottom: 20px;
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
            background-color: DarkSeaGreen;
            padding-bottom: 60px;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn:focus {
            outline: none;
            box-shadow: none;
        }
        .topbar h2 {
            margin: 0;
        }
        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin: 20px 0 40px;
        }
        .product img {
            height: 180px;
        }
        .product {
            background: white;
            padding: 10px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .product h3 {
            font-size: 16px;
            min-height: 40px;
            margin: 10px 0 5px;
            line-height: 1.2;
        }
        .product p {
            margin: 0 0 10px;
            font-weight: bold;
        }
        .product form {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .product .btn {
            margin-top: auto;
        }
        .products + .products {
            margin-top: 30px;
        }
        .sizes {
            display: none;
        }
        .trending-banner {
            background: linear-gradient(135deg, #ff8a00, #e52e71);
            color: white;
            padding: 12px 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }
        @media (max-width: 768px) {
            .products {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
            .topbar, .category-bar, .products-container {
                padding: 10px;
            }
            .topbar h2 {
                font-size: 20px;
            }
            .topbar form input {
                width: 60%;
            }
            .category-title {
                font-size: 18px;
            }
        }
    </style>
    <script>
        function validateSize(form, isDress) {
            if (isDress) {
                const sizeInput = form.querySelector("input[name='size']");
                if (!sizeInput || !sizeInput.value) {
                    const name = form.querySelector('h3')?.innerText || 'this item';
                    alert("Please select a size for " + name);
                    return false;
                }
            }
            return true;
        }
    </script>
</head>
<body>
<div class="trending-banner">
    🔥 Big Summer Sale! Up to 50% OFF on selected items!
</div>
<div class="topbar">
    <h2>TrendyOne</h2>
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
        echo "<a href='?category=" . urlencode($cat) . "' $active>$cat</a> ";
    }
    ?>
</div>

<div class="products-container">
<?php
function renderProduct($row, $isDress = false) {
    echo "<div class='product'>
            <form method='get' action='cart.php' onsubmit='return validateSize(this, " . ($isDress ? "true" : "false") . ")'>
                <a href='product.php?id={$row['id']}'>
                    <img src='images/{$row['image']}' alt='{$row['name']}'>
                    <h3>{$row['name']}</h3>
                </a>
                <p>₹{$row['price']}</p>";
    if ($isDress) {
        echo "<div class='sizes'>
                <input type='hidden' name='size' value=''> <!-- hidden and blank by default -->
              </div>";
    } else {
        echo "<input type='hidden' name='size' value='Free'>";
    }
    echo "<input type='hidden' name='add' value='{$row['id']}'>
          <button type='submit' class='btn'>Add to Cart</button>
          </form>
        </div>";
}

if ($search !== '') {
    echo "<h3 style='margin: 30px 20px 10px;'>Search results for: " . htmlspecialchars($search) . "</h3>";
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
    $stmt->bind_param("ss", $filter, $filter);
    $stmt->execute();
    $res = $stmt->get_result();

    echo "<div class='products'>";
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $isDress = in_array($row['category'], $dressCategories);
            renderProduct($row, $isDress);
        }
    } else {
        echo "<p style='margin: 20px;'>No products found matching your search.</p>";
    }
    echo "</div>";
} elseif ($category) {
    echo "<div class='category-section'>";
    echo "<h3 class='category-title'>$category</h3>";
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $res = $stmt->get_result();
    echo "<div class='products'>";
    while ($row = $res->fetch_assoc()) {
        $isDress = in_array($row['category'], $dressCategories);
        renderProduct($row, $isDress);
    }
    echo "</div>";
    echo "</div>";
} else {
    foreach ($categories as $cat) {
        echo "<div class='category-section'>";
        echo "<h3 class='category-title'>$cat</h3>";
        $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? LIMIT 6");
        $stmt->bind_param("s", $cat);
        $stmt->execute();
        $res = $stmt->get_result();

        echo "<div class='products'>";
        while ($row = $res->fetch_assoc()) {
            $isDress = in_array($cat, $dressCategories);
            renderProduct($row, $isDress);
        }
        echo "</div>";
        echo "<div class='view-more-overlay'>
                <a href='?category=" . urlencode($cat) . "' class='view-more-btn'>View More →</a>
              </div>";
        echo "</div>";
    }
}
?>
</div>
</body>
</html>
