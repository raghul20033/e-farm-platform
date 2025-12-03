<?php
session_start();
include '../db_connect.php';

$total = 0;
$products = [];

// Ensure cart is an array
if (!empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    // Keep only valid product IDs
    $productIds = array_filter(array_keys($_SESSION['cart']), 'is_numeric');

    if (!empty($productIds)) {
        $ids = implode(',', array_map('intval', $productIds));
        $result = $conn->query("SELECT * FROM products WHERE id IN ($ids)");

        while ($row = $result->fetch_assoc()) {
            // Check if cart data for this product is valid
            if (isset($_SESSION['cart'][$row['id']]['quantity']) && is_numeric($_SESSION['cart'][$row['id']]['quantity'])) {
                $quantity = (int)$_SESSION['cart'][$row['id']]['quantity'];
                $row['quantity'] = $quantity;
                $row['total_price'] = $quantity * $row['price'];
                $total += $row['total_price'];
                $products[] = $row;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Your Cart</title>
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
    <h1>🔔 My Notifications</h1>
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
  <div class="logo">🛒 Your Cart</div>
  <a href="index.php" class="back-btn">← Back to Shop</a>
</header>

<div class="product-grid">
  <?php if (!empty($products)) { ?>
      <?php foreach ($products as $product) { ?>
        <div class="product-card">
          <img src="../uploads/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
          <div class="product-info">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p>Qty: <?= $product['quantity'] ?></p>
            <p>Price: ₹<?= number_format($product['total_price'], 2) ?></p>
          </div>
        </div>
      <?php } ?>
  <?php } else { ?>
      <p style="grid-column: 1 / -1; text-align:center;">Your cart is empty.</p>
  <?php } ?>
</div>

<?php if (!empty($products)) { ?>
  <div style="text-align:center; margin: 20px;">
    <h2>Total: ₹<?= number_format($total, 2) ?></h2>
    <form action="../backend/order.php" method="POST">
      <button type="submit" class="add-btn">Place Order</button>
    </form>
  </div>
<?php } ?>

</body>
</html>
