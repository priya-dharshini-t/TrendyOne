<?php
session_start();
include "config.php";

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<p>Product not found!</p>";
    exit;
}

// ✅ Move these here (before HTML)
$dressCategories = ['T-Shirt', 'Shirts', 'Jeans', 'Trousers', 'Shorts', 'Suits and Blazers'];
$shoeCategories = ['Shoes', 'Slippers', 'Sandals'];
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($product['name']) ?> - Product</title>
    <link rel="stylesheet" href="style.css?v=7">
    <style>
        body {
            font-family: sans-serif;
            background: #f2f2f2;
            padding: 20px;
            background-color:cornsilk;
        }

        .product-page {
            max-width: 1100px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            gap: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .product-page img {
            width: 300px;
            border-radius: 10px;
            object-fit: cover;
        }

        .product-details {
            flex: 1;
        }

        .product-details h2 {
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            margin-top: 10px;
            margin-right: 10px;
            background: #28a745;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #218838;
        }

        .product-details p strong {
            color: #444;
        }

        .stars {
            margin: 6px 0 12px;
        }

        .star {
            font-size: 20px;
            color: #ccc;
        }

        .star.filled {
            color: gold;
        }

        .reviews {
            max-width: 1100px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .reviews h3 {
            margin-bottom: 15px;
        }

        .review {
            background: #f8f8f8;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
        }

        .size-btn {
            display: inline-block;
            padding: 6px 12px;
            margin: 5px 6px 5px 0;
            background: #eee;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: pointer;
        }

        .size-btn.selected {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
    </style>
    <script>
        function selectSize(size) {
            document.getElementById("selectedSize").value = size;
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('selected'));
            document.getElementById("btn-" + size).classList.add('selected');
        }
        function validateSize() {
        const size = document.getElementById("selectedSize").value;
        if (!size) {
            alert("Please select a size before adding to cart.");
            return false; // block form submission
        }
        return true;
    }
    </script>
</head>
<body>
    <a href="home.php" class="btn">← Back</a>
    
    <div class="product-page">
        <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
        <div class="product-details">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p><strong>₹<?= number_format($product['price']) ?></strong></p>

            <div class="stars">
                <?php
                    $rating = (int)$product['rating'];
                    for ($i = 1; $i <= 5; $i++) {
                        echo $i <= $rating
                            ? "<span class='star filled'>★</span>"
                            : "<span class='star'>☆</span>";
                    }
                ?>
            </div>

            <p><?= nl2br(htmlspecialchars($product['description'] ?: 'No description provided.')) ?></p>

            <?php if (in_array($product['category'], $dressCategories)): ?>
                <p><strong>Select Size:</strong></p>
                <div>
                    <?php foreach (['S', 'M', 'L', 'XL'] as $size): ?>
                        <span class="size-btn" id="btn-<?= $size ?>" onclick="selectSize('<?= $size ?>')"><?= $size ?></span>
                    <?php endforeach; ?>
                </div>
            <?php elseif (in_array($product['category'], $shoeCategories)): ?>
                <p><strong>Select Shoe Size:</strong></p>
                <div>
                    <?php foreach (range(6, 10) as $size): ?>
                        <span class="size-btn" id="btn-<?= $size ?>" onclick="selectSize('<?= $size ?>')"><?= $size ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form id="cartForm" action="cart.php" method="post" style="margin-top: 10px;" onsubmit="return validateSize()">
    <input type="hidden" name="id" value="<?= $product['id'] ?>">
    <input type="hidden" name="size" id="selectedSize" value="">
    <button type="submit" class="btn">🛒 Add to Cart</button>
    <a href="wishlist.php?add=<?= $product['id'] ?>" class="btn">♡ Add to Wishlist</a>
</form>

        </div>
    </div>

    <div class="reviews">
        <h3>📝 Customer Reviews</h3>
        <?php
            if (!empty($product['review'])) {
                echo "<div class='review'>" . nl2br(htmlspecialchars($product['review'])) . "</div>";
            } else {
                echo "<p>No reviews yet.</p>";
            }
        ?>
    </div>
</body>
</html>
