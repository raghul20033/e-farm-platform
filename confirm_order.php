<?php
// farmer/confirm_order.php
session_start();
require_once __DIR__ . '/../db_connect.php';

if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: notifications.php");
    exit;
}

$order_id = (int)($_POST['order_id'] ?? 0);
if ($order_id <= 0) {
    die('Invalid order id.');
}

// Fetch the order and check ownership (ensure the logged-in farmer owns the product)
$sql = "SELECT o.customer_id, p.farmer_id 
        FROM orders o 
        JOIN products p ON o.product_id = p.id 
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die('Prepare failed: ' . $conn->error);
}
$stmt->bind_param("i", $order_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if (!$row) {
    die('Order not found.');
}

$customer_id = (int)$row['customer_id'];
$order_farmer_id = (int)$row['farmer_id'];

if ($order_farmer_id !== (int)$_SESSION['farmer_id']) {
    die('Not authorized to confirm this order.');
}

// 1) update order status
$stmt = $conn->prepare("UPDATE orders SET status='Confirmed' WHERE id = ?");
if (!$stmt) {
    die('Prepare failed (update): ' . $conn->error);
}
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->close();

// 2) insert notification for the customer
$msg = "Your order #{$order_id} has been confirmed by the farmer.";
$stmt = $conn->prepare("INSERT INTO notifications (customer_id, order_id, message, created_at) VALUES (?, ?, ?, NOW())");
if (!$stmt) {
    die('Prepare failed (insert notification): ' . $conn->error);
}
$stmt->bind_param("iis", $customer_id, $order_id, $msg);
$stmt->execute();
$stmt->close();

// Redirect back to farmer notifications page
header("Location: notifications.php?confirmed=1");
exit;
