<?php
session_start();
include("../config/db.php");

// Check if product id is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    // Prepare SQL to delete product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect with success message
        header("Location: manage_products.php?msg=Product+deleted+successfully");
        exit();
    } else {
        echo "❌ Error deleting product: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "⚠️ Invalid product ID.";
}
?>
