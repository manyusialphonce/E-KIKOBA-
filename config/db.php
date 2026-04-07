<?php
$conn = new mysqli("localhost", "root", "", "ekikoba_db");
if ($conn->connect_error) {
    die("Database Connection Failed");
}

// Start session safely
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
