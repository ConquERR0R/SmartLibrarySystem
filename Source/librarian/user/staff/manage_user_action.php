<?php
include "../../inc/connection.php";

$id = $_GET['id'];
$type = $_GET['type'];
$action = $_GET['action'];

$table = ($type == "Student") ? "std_registration" : "t_registration";

if ($action == "archive") {
    mysqli_query($link, "UPDATE $table SET status='archived' WHERE id='$id'");
}
elseif ($action == "restore") {
    mysqli_query($link, "UPDATE $table SET status='active' WHERE id='$id'");
}
elseif ($action == "delete") {
    mysqli_query($link, "DELETE FROM $table WHERE id='$id' LIMIT 1");
}

header("Location: manage-users.php"); // ⭐ FIXED NAME
exit;
?>
