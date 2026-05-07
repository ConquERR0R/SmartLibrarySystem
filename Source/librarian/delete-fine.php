<?php
include 'inc/connection.php';
$id = $_GET['id'];
mysqli_query($link, "DELETE FROM add_book WHERE id='$id'");
header("Location: display-books.php");
exit();
?>
