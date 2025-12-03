<?php
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];

$table = $role === 'admin' ? 'admins' : $role . 's';

$sql = "SELECT * FROM $table WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        session_start();
        $_SESSION['user'] = $row;
        header("Location: ../$role/dashboard.php");
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No such user.";
}
$conn->close();
?>
