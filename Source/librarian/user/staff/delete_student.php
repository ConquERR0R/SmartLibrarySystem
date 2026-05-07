<?php
session_start();
include "inc/connection.php";

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "staff") {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location='all-student-info.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// CHECK IF STUDENT EXISTS
$chk = mysqli_query($link, "SELECT * FROM std_registration WHERE id='$id'");
if (mysqli_num_rows($chk) == 0) {
    echo "<script>alert('Student not found!'); window.location='all-student-info.php';</script>";
    exit;
}

// CHECK IF STUDENT HAS ACTIVE BORROWED BOOKS
$borrow = mysqli_query($link, "
    SELECT * FROM issue_book 
    WHERE username = (SELECT username FROM std_registration WHERE id='$id')
    AND status='Borrowed'
");

if (mysqli_num_rows($borrow) > 0) {
    echo "<script>alert('Cannot delete student. They still have borrowed books.'); 
          window.location='all-student-info.php';</script>";
    exit;
}

// DELETE RECORD
mysqli_query($link, "DELETE FROM std_registration WHERE id='$id'");

echo "<script>alert('Student deleted successfully!'); window.location='all-student-info.php';</script>";
exit;
