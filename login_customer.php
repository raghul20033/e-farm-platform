<?php
// login_customer.php
session_start();
include '../db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM customers WHERE email=?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $db_password);
            $stmt->fetch();

            // Plain password comparison
            if ($password === $db_password) {
                $_SESSION['customer_id'] = $id;
                header("Location: ../customer/index.php");
                exit();
            } else {
                echo "<script>alert('Incorrect password.'); window.location.href='../customer/login.html';</script>";
            }
        } else {
            echo "<script>alert('No customer account found with that email.'); window.location.href='../customer/login.html';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Database error.'); window.location.href='../customer/login.html';</script>";
    }
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='../customer/login.html';</script>";
}
