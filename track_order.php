<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.html');
    exit;
}

$customer_id = (int)$_SESSION['customer_id'];

$stmt = $conn->prepare("
    SELECT o.id, o.product_id, o.quantity, o.status, o.created_at,
           p.name AS product_name, p.image AS product_image, f.name AS farmer_name
    FROM orders o
    JOIN products p ON o.product_id = p.id
    JOIN farmers f ON p.farmer_id = f.id
    WHERE o.customer_id = ?
    ORDER BY o.created_at DESC
");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Track Orders</title>
  <link rel="stylesheet" href="../css/customer_dashboard.css">
  <style>
        .notifications-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 10px;
        }
        .notification-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin: 12px 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        .notification-card p {
            margin: 5px 0;
            font-size: 15px;
        }
        .notification-date {
            display: block;
            font-size: 13px;
            color: #777;
            margin-top: 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 13px;
            margin-top: 6px;
        }
        .status-confirmed { background: #28a745; color: white; }
        .status-rejected { background: #dc3545; color: white; }
        .status-pending { background: #ffc107; color: #333; }
    </style>
    <header class="site-header">
    <h1>📦 My Orders</h1>
    <nav class="dashboard-nav">
        <a href="index.php">🏠 Dashboard</a>
        <a href="track_order.php">📦 My Orders</a>
        <a href="notifications.php" class="active">🔔 Notifications</a>
        <a href="transactions.php">💰 Transactions</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>
</header>
</head>
<body>
<header>
  
</header>

<main style="padding:20px;">
  <?php if (!empty($_GET['placed'])): ?>
    <div class="notice success">Order placed successfully! You can track it below.</div>
  <?php endif; ?>

  <?php if (empty($orders)): ?>
    <p>No orders yet.</p>
  <?php else: ?>
    <div class="orders-list">
      <?php foreach ($orders as $o): ?>
        <div class="order-card">
          <img src="../uploads/<?= htmlspecialchars($o['product_image']) ?>" alt="" />
          <div class="order-info">
            <h3><?= htmlspecialchars($o['product_name']) ?></h3>
            <p>Farmer: <?= htmlspecialchars($o['farmer_name']) ?></p>
            <p>Qty: <?= (int)$o['quantity'] ?> | Status: <strong><?= htmlspecialchars($o['status']) ?></strong></p>
            <small>Placed: <?= htmlspecialchars($o['created_at']) ?></small>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>
</body>
</html>
