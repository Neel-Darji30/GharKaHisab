<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.html");
    exit();
}

include 'config.php';

$username = $_SESSION['username'];
$name     = $_POST['name'];
$amount   = $_POST['amount'];

// Safe insert with prepared statement
$stmt = $conn->prepare("INSERT INTO lending (username, name, amount) VALUES (?, ?, ?)");

if (!$stmt) {
    die("❌ Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssd", $username, $name, $amount);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: index.php?success=given");
exit();
?>
