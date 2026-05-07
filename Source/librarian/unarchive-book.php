<?php
include 'inc/connection.php';
$id = $_GET['id'];

mysqli_query($link, "UPDATE add_book SET status='active' WHERE id='$id'");

header("Location: display-books.php");
exit();
?>
