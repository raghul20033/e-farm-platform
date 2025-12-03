<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../admin/login.html"); // redirect to login if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f8;
        }
        header {
            background: #2c3e50;
            padding: 20px;
            color: white;
            text-align: center;
        }
        nav {
            background: #34495e;
            padding: 10px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        nav a {
            background: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        nav a:hover {
            background: #2980b9;
        }
        main {
            padding: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1></h1>
        <p></p>
    </header>

    <nav>
        <a href="../admin/manage_farmers.php">👨‍🌾 Manage Farmers</a>
        <a href="../admin/manage_customers.php">👥 Manage Customers</a>
        <a href="../admin/manage_products.php">📦 Manage Products</a>
        <a href="../admin/manage_transactions.php">💰 View Transactions</a>
        <a href="../admin/remove_expired.php">🗑 Remove Expired Products</a>
        <a href="../admin/logout.php">🚪 Logout</a>
    </nav>

    <main>
        <h2></h2>
        <p></p>
    </main>
</body>
</html>
