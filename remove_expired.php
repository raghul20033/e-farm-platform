<?php
session_start();
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);

    // Step 1: Delete orders linked to this product
    $conn->query("DELETE FROM orders WHERE product_id = $productId");

    // Step 2: Delete the product itself
    $conn->query("DELETE FROM products WHERE id = $productId");

    echo "<script>alert('Expired product and related orders removed successfully!'); window.location.href='expired_products.php';</script>";
    exit();
}

// Bulk removal (delete all expired products + their orders)
if (isset($_POST['remove_all'])) {
    // Step 1: Delete orders linked to expired products
    $conn->query("DELETE FROM orders WHERE product_id IN (SELECT id FROM products WHERE expiry_date < NOW())");

    // Step 2: Delete expired products
    $conn->query("DELETE FROM products WHERE expiry_date < NOW()");

    echo "<script>alert('All expired products and their related orders removed successfully!'); window.location.href='expired_products.php';</script>";
    exit();
}
?>
