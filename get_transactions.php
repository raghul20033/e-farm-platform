<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) die("Unauthorized");

$farmer_id = $_SESSION['farmer_id'];

$stmt = $conn->prepare("SELECT * FROM transactions WHERE farmer_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()) {
  echo "<p>{$row['description']} - ₹{$row['amount']} on {$row['created_at']}</p>";
}
?>
