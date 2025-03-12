<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login page or any other desired page after logout
header("Location: index.html");
exit();
?>
