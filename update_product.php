<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit();
}

$id         = $_POST['id'];
$name       = $_POST['name'];
$price      = $_POST['price'];
$discount   = $_POST['discount'];
$expiryDate = $_POST['expiry_date'];
$imageName  = null;

// If new image uploaded
if (!empty($_FILES['image']['name'])) {
    $imageName = $_FILES['image']['name'];
    $imageTmp  = $_FILES['image']['tmp_name'];
    $path = "../uploads/" . $imageName;
    move_uploaded_file($imageTmp, $path);

    $sql = "UPDATE products SET name=?, price=?, discount=?, expiry_date=?, image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdsssi", $name, $price, $discount, $expiryDate, $imageName, $id);
} else {
    $sql = "UPDATE products SET name=?, price=?, discount=?, expiry_date=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssi", $name, $price, $discount, $expiryDate, $id);
}

$stmt->execute();

header("Location: ../farmer/your_products.php");
exit();
?>
