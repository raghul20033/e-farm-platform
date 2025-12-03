<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>

<header class="main-header">
    <div class="logo">E-Farm Dashboard</div>
    <nav class="top-nav">
        <a href="customer_page.php">Customers</a>
        <a href="farmer_page.php">Farmers</a>
        <a href="add_products.php">Add Products</a>
        <a href="notifications.php">Notifications</a>
        <a href="your_products.php">Your Products</a>
        <a href="transactions.php">Transactions</a>
        <a href="logout.php" class="logout">Logout</a>
    </nav>
    <nav class="dashboard-nav">
    <a href="index.php">Browse Products</a>
    <a href="cart.php">Cart</a>
    <a href="track_order.php">Track Orders</a>
    <a href="notifications.php">My Notifications</a>
    <a href="logout.php">Logout</a>
</nav>

</header>

<main class="dashboard-content">
    <!-- Page-specific content will be inserted here -->
