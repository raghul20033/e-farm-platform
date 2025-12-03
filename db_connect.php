<?php
// db_connect.php
$servername = "localhost";
$username = "root";    // your DB username
$password = "";        // your DB password (empty by default in XAMPP)
$dbname = "efarm";  // change this to your database name!

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
