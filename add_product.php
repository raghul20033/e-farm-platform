<?php
session_start();
if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/farmer_dashboard.css">
</head>
<body>
    <header class="site-header">
        <h1>Add Product</h1>
        <nav class="dashboard-nav">
            <a href="index.php">🏠 Dashboard</a>
            <a href="add_product.php">➕ Add Products</a>
            <a href="your_products.php">📦 Your Products</a>
            <a href="notifications.php">🔔 Notifications</a>
            <a href="transactions.php">💰 Transactions</a>
            <a href="logout.php">🚪 Logout</a>
        </nav>
    </header>

    <?php include 'farmer_header.php'; ?> <!-- Reuse header -->

    <main style="padding: 20px;">
        <h2>Add New Product</h2>
        <form action="../backend/add_product.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="number" name="price" step="0.01" placeholder="Price" required>
            <input type="file" name="image" required>
            <input type="number" name="discount" placeholder="Discount %" required>
            <label for="expiry_date">Expiry Date:</label>
            <input type="date" name="expiry_date" required> <!-- ✅ Added field -->
            <button type="submit" class="btn">Add Product</button>
        </form>
    </main>
</body>
</html>
