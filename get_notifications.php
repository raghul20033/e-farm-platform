<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) die("Unauthorized");

$farmer_id = $_SESSION['farmer_id'];

$stmt = $conn->prepare("
  SELECT o.id, o.customer_name, p.name as product_name, o.quantity, o.status, o.created_at 
  FROM orders o 
  JOIN products p ON o.product_id = p.id 
  WHERE p.farmer_id = ?
  ORDER BY o.created_at DESC
");
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
  echo "<p><strong>{$row['customer_name']}</strong> ordered <strong>{$row['quantity']}</strong> of <strong>{$row['product_name']}</strong> - Status: {$row['status']} <em>({$row['created_at']})</em></p>";
}
?>
