<?php 
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit();
}

$farmerId = $_SESSION['farmer_id'];
$products = $conn->query("SELECT * FROM products WHERE farmer_id = $farmerId");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Products</title>
    <link rel="stylesheet" href="../css/farmer_dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
        }
        h2 {
            margin-bottom: 20px;
        }
        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }
        .product-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f0f0f0;
        }
        .product-details {
            padding: 15px;
        }
        .product-details h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #2c3e50;
        }
        .product-details p {
            margin: 8px 0;
            color: #555;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-top: 1px solid #eee;
            background: #fafafa;
        }
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: bold;
            transition: background 0.3s, transform 0.2s;
        }
        .edit-btn {
            background: #3498db;
            color: #fff;
        }
        .edit-btn:hover {
            background: #2980b9;
            transform: scale(1.05);
        }
        .delete-btn {
            background: #e74c3c;
            color: #fff;
        }
        .delete-btn:hover {
            background: #c0392b;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <header class="site-header">
        <h1>Your Product</h1>
        <nav class="dashboard-nav">
            <a href="index.php">🏠 Dashboard</a>
            <a href="add_product.php">➕ Add Products</a>
            <a href="your_products.php" class="active">📦 Your Products</a>
            <a href="notifications.php">🔔 Notifications</a>
            <a href="transactions.php">💰 Transactions</a>
            <a href="logout.php">🚪 Logout</a>
        </nav>
    </header>

    <main style="padding: 20px;">
        <h2>Your Products</h2>
        <div class="products-container">
            <?php while($row = $products->fetch_assoc()) { ?>
                <div class="product-card">
                    <img src="../img/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="product-image">


                    <div class="product-details">
                        <h3><?php echo $row['name']; ?></h3>
                        <p>💰 Price: ₹<?php echo $row['price']; ?></p>
                        <p>⚡ Discount: <?php echo $row['discount']; ?>%</p>
                        <p>📅 Expiry: <?php echo $row['expiry_date']; ?></p>
                    </div>

                    <div class="actions">
                        <!-- Edit Button -->
                        <form action="edit_product.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn edit-btn">✏️ Edit</button>
                        </form>

                        <!-- Delete Button -->
                        <form action="../backend/delete_product.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn delete-btn">🗑️ Delete</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>
