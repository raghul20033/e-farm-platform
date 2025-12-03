<?php
include 'db.php';

$email = $_POST['email'];
$otp = $_POST['otp'];
$role = $_POST['role'];

$table = $role === 'admin' ? 'admins' : $role . 's';

$sql = "SELECT * FROM $table WHERE email='$email' AND otp='$otp'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $conn->query("UPDATE $table SET is_verified=1 WHERE email='$email'");
    echo "OTP Verified. You can now log in.";
} else {
    echo "Invalid OTP.";
}
?>
