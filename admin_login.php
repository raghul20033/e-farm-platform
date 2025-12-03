<?php
session_start();

$admin_email = "admin@gmail.com";
$admin_pass  = "admin123";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($email === $admin_email && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
