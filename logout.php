<?php
session_start();         // Start session to access it
session_unset();         // Optional: Clear all session variables
session_destroy();       // Destroy the session
header("Location: login.html");  // Redirect to login
exit();
?>
