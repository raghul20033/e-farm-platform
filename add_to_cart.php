<?php
session_start();
include '../db_connect.php';

$product_id = intval($_POST['product_id']);
$quantity = intval($_POST['quantity']);

// Fetch product details from DB
$sql = "SELECT id, name, price, image FROM products WHERE id = $product_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();

    // If product already in cart, increase quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name'     => $product['name'],
            'price'    => $product['price'],
            'image'    => $product['image'],
            'quantity' => $quantity
        ];
    }
}

header("Location: cart.php");
exit();
?>
