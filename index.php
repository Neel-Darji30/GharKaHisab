<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.html");
  exit();
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ghar Ka Hisab</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Ghar Ka Hisab — Apke Kharchon Ka Asli Record</h1>
    <h2>Welcome, <?= htmlspecialchars($username) ?>!</h2>

    <div class="form-wrapper">
      <!-- Expenses Form -->
      <div class="card">
        <h3>Enter Your Expenses</h3>
        <form action="save.php" method="POST">
          <input type="number" name="amount" step="0.01" placeholder="Amount in ₹" required>
          <input type="text" name="purpose" placeholder="Purpose (e.g. groceries, rent, etc.)" required>
          <button type="submit">Save</button>
        </form>
      </div>

      <!-- Lending Form -->
      <div class="card">
        <h3>Give Money to Someone</h3>
        <form action="give.php" method="POST">
          <input type="text" name="name" placeholder="Name" required>
          <input type="number" name="amount" step="0.01" placeholder="Amount in ₹" required>
          <button type="submit">Record</button>
        </form>
      </div>
    </div>

    <div class="links">
      <a href="summary.php">View Expenses Summary</a> |
      <a href="lending_summary.php">View Given Money Summary</a> |
      <a href="logout.php">Logout</a>
    </div>

    <footer>
      © 2025 <strong>Neel Darji</strong>. All rights reserved.
    </footer>
  </div>
</body>
</html>
