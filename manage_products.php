<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: admin_login.php"); exit(); }

$conn = new mysqli("localhost", "root", "", "efarm");
$products = $conn->query("SELECT * FROM products");
?>
<h2>Manage Products</h2>
<table border="1">
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
    <a href="remove_expired.php" 
   onclick="return confirm('Are you sure you want to remove all expired products?');" 
   class="btn btn-danger">
   🗑 Remove Expired Products
</a>
<a href="delete_product.php?id=<?php echo $row['id']; ?>" 
   onclick="return confirm('Are you sure you want to delete this product?');">
   🗑 Delete
</a>


<tr><th>ID</th><th>Farmer ID</th><th>Name</th><th>Price</th><th>Expiry Date</th><th>Action</th></tr>
<?php while($row = $products->fetch_assoc()): ?>
<tr style="color: <?= (strtotime($row['expiry_date']) < time()) ? 'red' : 'black' ?>;">
  <td><?= $row['id'] ?></td>
  <td><?= $row['farmer_id'] ?></td>
  <td><?= $row['name'] ?></td>
  <td><?= $row['price'] ?></td>
  <td><?= $row['expiry_date'] ?></td>
  <td><a href="delete_product.php?id=<?= $row['id'] ?>">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
