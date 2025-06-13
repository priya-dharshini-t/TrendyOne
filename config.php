<?php
$conn = new mysqli("localhost", "root", "", "men_style");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
