<?php
session_start();
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM farmers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($farmerId, $storedPassword);
        $stmt->fetch();

        if ($password === $storedPassword) {
            $_SESSION['farmer_id'] = $farmerId;
            header("Location: ../farmer/farmer_dashboard.php");
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
    }
}
?>
