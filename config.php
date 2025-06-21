<?php
$conn = new mysqli("sql312.byetcluster.com", "epiz_12345678", "9bcCMX2LFNUud", "epiz_12345678_trendyone");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
