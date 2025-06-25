<?php
// Do NOT use session_start() here — it should be in the individual PHP files

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "savings_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
