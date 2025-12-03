<?php
session_start();
include '../db_connect.php';

$result = $conn->query("SELECT * FROM products WHERE expiry_date < NOW()");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Expired Products</title>
</head>
<body>
<h2 style="text-align:center;">⏳ Expired Products</h2>
<table border="1" cellpadding="10" cellspacing="0" align="center">
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

    <tr>
        <th>ID</th><th>Name</th><th>Farmer</th><th>Expiry Date</th><th>Action</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['farmer_id'] ?></td>
        <td><?= $row['expiry_date'] ?></td>
        <td>
            <form method="POST" action="remove_expired.php">
                <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                <button type="submit">❌ Remove</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
