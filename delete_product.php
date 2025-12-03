<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    $farmerId = $_SESSION['farmer_id'];

    // Debug: check IDs
    // echo "Trying to delete Product ID: $productId for Farmer ID: $farmerId"; exit;

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND farmer_id = ?");
    $stmt->bind_param("ii", $productId, $farmerId);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: ../farmer/your_products.php?success=1");
            exit();
        } else {
            echo "⚠️ No product deleted. Either product doesn’t exist or doesn’t belong to you.";
        }
    } else {
        echo "❌ SQL Error: " . $stmt->error;
    }
}
?>
