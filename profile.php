<?php
session_start();
include '../db_connect.php';

if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit();
}

$farmerId = $_SESSION['farmer_id'];
$sql = "SELECT * FROM farmers WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $farmerId);
$stmt->execute();
$result = $stmt->get_result();
$farmer = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f4f6f8;
        }
        .profile-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .profile-container img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #3498db;
            margin-bottom: 15px;
        }
        .profile-container h2 {
            margin: 10px 0;
            color: #2c3e50;
        }
        .profile-container form {
            text-align: left;
        }
        .profile-container label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #34495e;
        }
        .profile-container input, .profile-container textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .profile-container button {
            margin-top: 15px;
            background: #3498db;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 6px;
            cursor: pointer;
        }
        .profile-container button:hover {
            background: #2980b9;
        }
        
    </style>
    
</head>
<body>

<div class="profile-container">
    <img src="../uploads/<?php echo !empty($farmer['profile_photo']) ? $farmer['profile_photo'] : 'profile_default.png'; ?>" alt="Profile">
    <h2><?php echo htmlspecialchars($farmer['name']); ?></h2>

    <form action="update_profile.php" method="POST" enctype="multipart/form-data">
        <label>Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($farmer['name']); ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($farmer['email']); ?>" required>

        <label>Phone Number</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($farmer['phone']); ?>" required>

        <label>Address</label>
        <textarea name="address" required><?php echo htmlspecialchars($farmer['address']); ?></textarea>

        <label>Profile Photo</label>
        <input type="file" name="profile_photo">

        <button type="submit">Update Profile</button>
    </form>
</div>

</body>
</html>
