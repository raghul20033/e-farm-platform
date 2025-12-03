<?php
session_start();
include("../config/db.php"); // adjust if your DB file path is different

// Check if customer logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_SESSION['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Get product details
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        $total_price = $product['price'] * $quantity;

        // Insert into orders
        $stmt = $conn->prepare("INSERT INTO orders (customer_id, product_id, quantity, total_price, status) VALUES (?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("iiid", $customer_id, $product_id, $quantity, $total_price);

        if ($stmt->execute()) {
            echo "✅ Order placed successfully!";
            echo "<br> <a href='orders.php'>View My Orders</a>";
        } else {
            echo "❌ Failed to place order.";
        }
    } else {
        echo "❌ Product not found.";
    }
}
?>
