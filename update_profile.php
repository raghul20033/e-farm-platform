<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit();
}

$farmerId = $_SESSION['farmer_id'];
$name     = $_POST['name'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$address  = $_POST['address'];

$profilePhoto = null;
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == 0) {
    $fileName = time() . "_" . $_FILES['profile_photo']['name'];
    $target = "../uploads/" . $fileName;
    move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target);
    $profilePhoto = $fileName;
}

if ($profilePhoto) {
    $sql = "UPDATE farmers SET name=?, email=?, phone=?, address=?, profile_photo=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $email, $phone, $address, $profilePhoto, $farmerId);
} else {
    $sql = "UPDATE farmers SET name=?, email=?, phone=?, address=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $farmerId);
}

if ($stmt->execute()) {
    header("Location: profile.php");
} else {
    echo "Error updating profile!";
}
exit();
?>
