<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../customer/login.html");
    exit();
}

$customerId = $_SESSION['customer_id'];

// Fetch customer notifications
$stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Notifications</title>
    <link rel="stylesheet" href="../css/customer_dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .notification {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .notification time {
            font-size: 0.9em;
            color: gray;
            display: block;
            margin-top: 5px;
        }
        a.back-btn {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
        }
        a.back-btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="customer_dashboard.php" class="back-btn">← Back to Dashboard</a>
    <h1>Notifications</h1>

    <?php if ($result->num_rows > 0) { ?>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="notification">
                <p><?php echo htmlspecialchars($row['message']); ?></p>
                <time><?php echo $row['created_at']; ?></time>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No notifications yet.</p>
    <?php } ?>
</div>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
