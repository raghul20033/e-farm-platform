<?php
session_start();
include '../db_connect.php';

// Ensure farmer is logged in
if (!isset($_SESSION['farmer_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="../css/farmer_dashboard.css">
</head>
<body>

<header class="site-header">
    <h1>Farmer Dashboard</h1>
    <nav class="dashboard-nav">
        <a href="index.php">🏠 Dashboard</a>
        <a href="add_product.php">➕ Add Products</a>
        <a href="your_products.php">📦 Your Products</a>
        <a href="notifications.php">🔔 Notifications</a>
        <a href="transactions.php">💰 Transactions</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>
</header>

<main>
    <h2></h2>
    <p></p>
</main>

</body>
</html>
