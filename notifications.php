<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) {
    header("Location: login.php");
    exit;
}

$farmer_id = $_SESSION['farmer_id'];

// Fetch orders related to this farmer’s products
$sql = "SELECT o.id AS order_id, p.name AS product_name, o.customer_name, 
               o.customer_phone, o.customer_address, o.quantity, 
               o.status, o.created_at
        FROM orders o
        JOIN products p ON o.product_id = p.id
        WHERE p.farmer_id = ?
        ORDER BY o.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer Notifications</title>
    <link rel="stylesheet" href="../css/farmer_dashboard.css">
    <style>
        .order-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
            background: #fff;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        .order-card p { margin: 5px 0; }
        .order-actions { margin-top: 10px; }
        .btn-accept {
            background: #28a745;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-reject {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<header class="site-header">
    <h1>🔔 Order Notifications</h1>
    <nav class="dashboard-nav">
        <a href="index.php">🏠 Dashboard</a>
        <a href="add_product.php">➕ Add Products</a>
        <a href="your_products.php">📦 Your Products</a>
        <a href="notifications.php" class="active">🔔 Notifications</a>
        <a href="transactions.php">💰 Transactions</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>
</header>

<main style="padding:20px;">
    <h2>📦 New & Pending Orders</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="order-card">
                <p><strong>🛒 Product:</strong> <?= htmlspecialchars($row['product_name']) ?></p>
                <p><strong>👤 Customer:</strong> <?= htmlspecialchars($row['customer_name']) ?></p>
                <p><strong>📞 Phone:</strong> <?= htmlspecialchars($row['customer_phone']) ?></p>
                <p><strong>📍 Address:</strong> <?= htmlspecialchars($row['customer_address']) ?></p>
                <p><strong>🔢 Quantity:</strong> <?= (int)$row['quantity'] ?></p>
                <p><strong>📅 Ordered On:</strong> <?= $row['created_at'] ?></p>
                <p><strong>⚡ Status:</strong> 
                    <span style="color:<?= $row['status']=='Pending'?'orange':($row['status']=='Confirmed'?'green':'red') ?>;">
                        <?= $row['status'] ?>
                    </span>
                </p>

                <?php if ($row['status'] == 'Pending'): ?>
                    <div class="order-actions">
                        <form action="confirm_order.php" method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                            <button type="submit" name="action" value="accept" class="btn-accept">✅ Accept</button>
                        </form>
                        <form action="confirm_order.php" method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                            <button type="submit" name="action" value="reject" class="btn-reject">❌ Reject</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No new orders found.</p>
    <?php endif; ?>
</main>

</body>
</html>
