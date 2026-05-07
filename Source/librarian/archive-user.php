<?php
include 'inc/connection.php';

$id = $_GET['id'] ?? 0;
$type = $_GET['type'] ?? "";

if ($id && $type) {
    if ($type === "Student") {
        mysqli_query($link, "UPDATE std_registration SET status='archived' WHERE id='$id'");
    } else {
        mysqli_query($link, "UPDATE t_registration SET status='archived' WHERE id='$id'");
    }
}

header("Location: manage_user.php");
exit;
?>
