<?php
session_start();
include 'inc/connection.php';

$id = $_GET['id'];
$type = $_GET['type'];

if ($type == "Student") {
    mysqli_query($link, "UPDATE std_registration SET status='active' WHERE id='$id'");
} else {
    mysqli_query($link, "UPDATE t_registration SET status='active' WHERE id='$id'");
}

header("Location: manage_user.php");
exit;
?>
