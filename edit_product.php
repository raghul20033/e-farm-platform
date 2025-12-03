<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit();
}

$id = $_GET['id'];
$farmerId = $_SESSION['farmer_id'];

// Fetch product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id=? AND farmer_id=?");
$stmt->bind_param("ii", $id, $farmerId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Product not found!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/farmer_dashboard.css">
</head>
<body>
    <header class="site-header">
        <h1>Edit Product</h1>
    </header>

    <main style="padding: 20px;">
        <form action="../backend/update_product.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

            <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
            <input type="number" name="discount" value="<?php echo $product['discount']; ?>" required>
            
            <label>Expiry Date:</label>
            <input type="date" name="expiry_date" value="<?php echo $product['expiry_date']; ?>" required>

            <label>Change Image (optional):</label>
            <input type="file" name="image">

            <button type="submit" class="btn">Update Product</button>
        </form>
    </main>
</body>
</html>
