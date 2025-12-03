<?php
session_start();
include '../db_connect.php';

// Ensure farmer is logged in
if (!isset($_SESSION['farmer_id'])) {
    header("Location: login.php");
    exit;
}

$farmer_id = $_SESSION['farmer_id'];

// Fetch all transactions related to this farmer's products
$sql = "SELECT t.id, t.amount, t.payment_method, t.status, t.created_at, 
               o.id AS order_id, 
               p.name AS product_name,
               c.name AS customer_name
        FROM transactions t
        JOIN orders o ON t.order_id = o.id
        JOIN products p ON o.product_id = p.id
        JOIN customers c ON o.customer_id = c.id
        WHERE p.farmer_id = ?
        ORDER BY t.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $farmer_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer Transactions</title>
    <link rel="stylesheet" href="../css/farmer_dashboard.css">
    <style>
        .transaction-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            margin: 15px 0;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        .transaction-card p { margin: 5px 0; }
        .status-paid { color: green; font-weight: bold; }
        .status-pending { color: orange; font-weight: bold; }
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

<?php  ?>

<main>
    <h2>💰 My Transactions</h2>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="transaction-card">
                <p><strong>🛒 Product:</strong> <?= htmlspecialchars($row['product_name']) ?></p>
                <p><strong>📦 Order ID:</strong> #<?= $row['order_id'] ?></p>
                <p><strong>👤 Customer:</strong> <?= htmlspecialchars($row['customer_name']) ?></p>
                <p><strong>💰 Amount:</strong> ₹<?= number_format($row['amount'], 2) ?></p>
                <p><strong>📅 Date:</strong> <?= $row['created_at'] ?></p>
                <p><strong>⚡ Status:</strong> 
                    <span class="<?= $row['status']=='Paid'?'status-paid':'status-pending' ?>">
                        <?= $row['status'] ?>
                    </span>
                </p>
                <p><strong>💳 Payment Method:</strong> <?= $row['payment_method'] ?: 'Not Selected' ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No transactions found.</p>
    <?php endif; ?>
</main>

</body>
</html>
