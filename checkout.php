<?php
session_start();
$_SESSION['cart'] = [];
echo "<h2>Thank you for your purchase!</h2>";
echo "<a href='index.php'>Go back to shop</a>";
?>
