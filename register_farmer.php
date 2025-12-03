<?php
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $place = trim($_POST["place"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];

    $sql = "INSERT INTO farmers (name, email, place, phone, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssss", $name, $email, $place, $phone, $password);
        if ($stmt->execute()) {
            header("Location: ../farmer/login.html");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Database error: " . $conn->error;
    }
    $conn->close();
}
?>
