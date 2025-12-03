<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['customer_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: transactions.php");
    exit;
}

$transaction_id = (int)$_POST['transaction_id'];
$method = $_POST['method'];

// Mark transaction as paid
$stmt = $conn->prepare("UPDATE transactions SET payment_method=?, status='Paid' WHERE id=?");
$stmt->bind_param("si", $method, $transaction_id);
$stmt->execute();
$stmt->close();

header("Location: transactions.php?paid=1");
exit;
