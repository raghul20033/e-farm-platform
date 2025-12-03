<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit();
}

$farmerId = $_SESSION['farmer_id'];
$farmerName = $_SESSION['farmer_name'] ?? 'Farmer';

// Fetch products
$products = $conn->query("SELECT * FROM products WHERE farmer_id = $farmerId");

// Fetch orders
$orders = $conn->query("
    SELECT orders.*, products.name AS product_name 
    FROM orders 
    JOIN products ON orders.product_id = products.id 
    WHERE products.farmer_id = $farmerId
    ORDER BY orders.created_at DESC
");

// Fetch transactions
$transactions = $conn->query("
    SELECT * FROM transactions 
    WHERE farmer_id = $farmerId 
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="../css/farmer_dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f7fa;
            color: #333;
            scroll-behavior: smooth;
        }
        header {
            background: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .welcome-banner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            padding: 30px;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border-radius: 10px;
            margin: 20px auto;
            max-width: 1000px;
        }
        .welcome-banner img {
            width: 250px;
            height: auto;
            border-radius: 10px;
        }
        .dashboard-nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            background: #34495e;
            padding: 15px;
            flex-wrap: wrap;
        }
        .dashboard-nav a {
            color: white;
            text-decoration: none;
            background: #3498db;
            padding: 10px 15px;
            border-radius: 6px;
            transition: 0.3s;
        }
        .dashboard-nav a:hover {
            background: #2980b9;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            padding: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .card h2 {
            margin-top: 0;
        }
        input, button {
            padding: 10px;
            margin-bottom: 15px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background: #3498db;
            color: white;
            border: none;
        }
        button:hover {
            background: #2980b9;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            padding: 10px;
            background: #ecf0f1;
            margin-bottom: 10px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 10px;
        }
        .product-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .accept-btn {
            background: green;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
        }
        .delete-btn {
            background: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<header>
    <h1>Farmer Dashboard</h1>
</header>

<!-- Welcome Banner -->
<div class="welcome-banner">
    <img src="../images/farmer_welcome.jpg" alt="Welcome Farmer">
    <div>
        <h2>Welcome, <?php echo htmlspecialchars($farmerName); ?> 👋</h2>
        <p>Manage your products, track your orders, and view your transactions — all in one place.</p>
    </div>
</div>

<!-- Navigation Modules -->
<nav class="dashboard-nav">
    <a href="#add-product">Add Product</a>
    <a href="#your-products">Your Products</a>
    <a href="#notifications">Notifications</a>
    <a href="#transactions">Transactions</a>
    <a href="../backend/logout.php">Logout</a>
</nav>

<div class="container">

    <!-- Add Product -->
    <section id="add-product" class="card">
        <h2>Add New Product</h2>
        <form action="../backend/add_product.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Product Name" required>
            <input type="number" name="price" step="0.01" placeholder="Price" required>
            <input type="file" name="image" required>
            <input type="number" name="discount" placeholder="Discount %" min="0" max="100" required>
            <button type="submit">Add Product</button>
        </form>
    </section>

    <!-- Products List -->
    <section id="your-products" class="card">
        <h2>Your Products</h2>
        <ul>
            <?php while($row = $products->fetch_assoc()) { ?>
                <li>
                    <div class="product-item">
                        <img src="../uploads/<?php echo $row['image']; ?>" class="product-img">
                        <span><?php echo $row['name']; ?> - ₹<?php echo $row['price']; ?></span>
                    </div>
                    <form action="../backend/delete_product.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="delete-btn">Remove</button>
                    </form>
                </li>
            <?php } ?>
        </ul>
    </section>

    <!-- Notifications -->
    <section id="notifications" class="card">
        <h2>Order Notifications</h2>
        <ul>
            <?php while($order = $orders->fetch_assoc()) { ?>
                <li>
                    <?php echo $order['product_name']; ?> | Qty: <?php echo $order['quantity']; ?> | Status: <?php echo ucfirst($order['status']); ?>
                    <?php if ($order['status'] == 'pending') { ?>
                        <form action="../backend/accept_order.php" method="POST">
                            <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                            <button type="submit" class="accept-btn">Accept</button>
                        </form>
                    <?php } ?>
                </li>
            <?php } ?>
        </ul>
    </section>

    <!-- Transactions -->
    <section id="transactions" class="card">
        <h2>Transaction History</h2>
        <ul>
            <?php while($txn = $transactions->fetch_assoc()) { ?>
                <li>
                    ₹<?php echo $txn['amount']; ?> - <?php echo $txn['description']; ?> (<?php echo $txn['created_at']; ?>)
                </li>
            <?php } ?>
        </ul>
    </section>

</div>

</body>
</html>
