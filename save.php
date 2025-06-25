<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.html");
    exit();
}

include 'config.php';

$username = $_SESSION['username'];
$amount   = $_POST['amount'];
$purpose  = $_POST['purpose'];

$stmt = $conn->prepare("INSERT INTO savings (username, amount, purpose) VALUES (?, ?, ?)");

if (!$stmt) {
    die("❌ Prepare failed: " . $conn->error);
}

$stmt->bind_param("sds", $username, $amount, $purpose);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: index.php?success=expense");
exit();
?>
