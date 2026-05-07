<?php
session_start();
include "inc/connection.php";

if(!isset($_GET['id'])){
    header("Location: display-books.php");
    exit();
}

$id = $_GET['id'];

// Restore book
mysqli_query($link, "UPDATE add_book SET status='active' WHERE id='$id'");

echo "<script>
alert('Book restored successfully.');
window.location='display-books.php';
</script>";
?>
