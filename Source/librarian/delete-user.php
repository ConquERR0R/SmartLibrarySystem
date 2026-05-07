<?php
include "inc/connection.php";

$id = $_GET['id'] ?? 0;
$type = $_GET['type'] ?? "";
$action = $_GET['action'] ?? "";

if (!$id || !$type || !$action) {
    header("Location: manage_user.php");
    exit;
}

$table = ($type == "Student") ? "std_registration" : "t_registration";

switch ($action) {

    case "archive":
        mysqli_query($link, "UPDATE $table SET status='archived' WHERE id='$id' LIMIT 1");
        break;

    case "restore":
        mysqli_query($link, "UPDATE $table SET status='active' WHERE id='$id' LIMIT 1");
        break;

    case "delete":
        mysqli_query($link, "DELETE FROM $table WHERE id='$id' LIMIT 1");
        break;
}

header("Location: manage_user.php"); // FIXED
exit;
?>
