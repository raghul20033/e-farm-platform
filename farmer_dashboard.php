<?php
session_start();
if (!isset($_SESSION['farmer_id'])) {
    header("Location: ../farmer/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Farmer Dashboard</title>
  <link rel="stylesheet" href="../css/farmer_dashboard.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f6f8;
    }

    nav {
      background: #27ae60;
      padding: 15px;
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    nav a, nav button {
      background: #2ecc71;
      color: white;
      padding: 10px 20px;
      border: none;
      text-decoration: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
      font-size: 16px;
    }

    nav a:hover, nav button:hover {
      background: #1e8449;
    }
    /* Profile button (right corner) */
.profile-btn {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  border: 2px solid white;
  background-color: #2ecc71;   /* fallback color */
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  flex-shrink: 0;
}

.profile-btn img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
}

.profile-btn:hover {
  transform: scale(1.1);
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.7);
}


    main {
      text-align: center;
      padding: 30px 20px;
      min-height: 500px;
    }

    /* Profile panel (hidden by default) */
    #profile-panel {
      position: fixed;
      top: 0;
      right: -500px; /* Hidden initially */
      width: 400px;
      height: 100%;
      background: white;
      box-shadow: -4px 0 12px rgba(0, 0, 0, 0.2);
      padding: 20px;
      transition: right 0.5s ease;
      overflow-y: auto;
      z-index: 1000;
    }
    

    #profile-panel.active {
      right: 0; /* Slide in */
    }

    #close-profile {
      background: #e74c3c;
      border: none;
      color: white;
      padding: 8px 15px;
      border-radius: 6px;
      cursor: pointer;
      float: right;
    }

    #profile-content h2 {
      margin-top: 0;
      color: #2c3e50;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav>
    <a href="add_product.php">➕ Add Products</a>
    <a href="your_products.php">📦 Your Products</a>
    <a href="notifications.php">🔔 Notifications</a>
    <a href="transactions.php">💰 Transactions</a>
    <a href="logout.php">🚪 Logout</a>
   
  </nav>

  <!-- Main Dashboard -->
  <main>
    <h1></h1>
    <p></p>
  </main>

  <!-- Profile Panel -->
  

  <script>
    function openProfile() {
      document.getElementById("profile-panel").classList.add("active");

      // Fetch profile content using AJAX
      fetch("profile.php")
        .then(response => response.text())
        .then(data => {
          document.getElementById("profile-content").innerHTML = data;
        })
        .catch(err => {
          document.getElementById("profile-content").innerHTML = "<p style='color:red;'>Failed to load profile.</p>";
        });
    }

    function closeProfile() {
      document.getElementById("profile-panel").classList.remove("active");
    }
  </script>

</body>
</html>
