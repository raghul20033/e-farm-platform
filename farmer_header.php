<?php
if (!isset($_SESSION)) { session_start(); }
if (!isset($_SESSION['farmer_id'])) {
    header("Location: login.html");
    exit();
}
?>

