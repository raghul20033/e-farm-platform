<?php
$conn = new mysqli("localhost", "root", "", "efarm");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
