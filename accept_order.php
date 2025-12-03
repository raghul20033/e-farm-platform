<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $orderId = intval($_POST['order_id']);

    // Update order status to confirmed
    $stmt = $conn->prepare("UPDATE orders SET status = 'confirmed' WHERE id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->close();

    // Fetch order details to send notification
    $orderQuery = $conn->prepare("
        SELECT orders.customer_id, products.name AS product_name
        FROM orders 
        JOIN products ON orders.product_id = products.id
        WHERE orders.id = ?
    ");
    $orderQuery->bind_param("i", $orderId);
    $orderQuery->execute();
    $orderResult = $orderQuery->get_result();

    if ($orderRow = $orderResult->fetch_assoc()) {
        $customerId = $orderRow['customer_id'];
        $productName = $orderRow['product_name'];

        // Insert notification for customer
        $message = "Your order for '$productName' has been confirmed by the farmer.";
        $notifStmt = $conn->prepare("INSERT INTO notifications (user_id, message, created_at) VALUES (?, ?, NOW())");
        $notifStmt->bind_param("is", $customerId, $message);
        $notifStmt->execute();
        $notifStmt->close();
    }

    $orderQuery->close();

    // Redirect back to dashboard
    header("Location: ../pages/farmer_dashboard.php#notifications");
    exit();
} else {
    header("Location: ../pages/farmer_dashboard.php");
    exit();
}
?>
