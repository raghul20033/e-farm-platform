<?php
session_start();
include '../db_connect.php';

$result = $conn->query("SELECT * FROM farmers ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Farmers</title>
    <style>
        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th { background: #3498db; color: white; }
        tr:nth-child(even) { background: #f2f2f2; }
    </style>
    <nav>
        <a href="../admin/manage_farmers.php">👨‍🌾 Manage Farmers</a>
        <a href="../admin/manage_customers.php">👥 Manage Customers</a>
        <a href="../admin/manage_products.php">📦 Manage Products</a>
        <a href="../admin/manage_transactions.php">💰 View Transactions</a>
        <a href="../admin/monitor_expiry.php">🗑 Remove Expired Products</a>
        <a href="../admin/logout.php">🚪 Logout</a>
    </nav>
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
<h2 style="text-align:center;">👨‍🌾 Farmers List</h2>
<table>
    <tr>
        <th>ID</th><th>Name</th><th>Email</th><th>Phone</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['email'] ?></td>
        <td><?= $row['phone'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
