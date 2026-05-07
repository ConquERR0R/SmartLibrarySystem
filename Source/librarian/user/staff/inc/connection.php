<?php
// Database connection
$link = mysqli_connect("localhost", "root", "", "project");

// Connection error check
if (!$link) {
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>
