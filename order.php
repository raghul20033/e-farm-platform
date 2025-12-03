<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['customer_id']) || empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit;
}

$customerId = $_SESSION['customer_id'];
$cart = $_SESSION['cart'];

foreach ($cart as $product_id => $qty) {
    $stmt = $conn->prepare("INSERT INTO orders (customer_name, product_id, quantity) VALUES ((SELECT name FROM customers WHERE id=?), ?, ?)");
    $stmt->bind_param("iii", $customerId, $product_id, $qty);
    $stmt->execute();
}

unset($_SESSION['cart']);

echo "<script>alert('Order placed successfully!'); window.location.href='track_order.php';</script>";
?>
