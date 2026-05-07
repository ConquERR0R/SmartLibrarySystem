<?php
session_start();
include "inc/connection.php";

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "staff") {
    header("Location: ../../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location='all-teacher-info.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// CHECK IF TEACHER EXISTS
$chk = mysqli_query($link, "SELECT * FROM t_registration WHERE id='$id'");
if (mysqli_num_rows($chk) == 0) {
    echo "<script>alert('Teacher not found!'); window.location='all-teacher-info.php';</script>";
    exit;
}

// PREVENT DELETE IF TEACHER STILL HAS ISSUED BOOKS
$usr = mysqli_fetch_assoc($chk);
$username = $usr['username'];

$borrow = mysqli_query($link, "
    SELECT * FROM issue_book
    WHERE username='$username' AND status='Borrowed'
");

if (mysqli_num_rows($borrow) > 0) {
    echo "<script>alert('Cannot delete: Teacher still has borrowed books!'); 
          window.location='all-teacher-info.php';</script>";
    exit;
}

// DELETE TEACHER
mysqli_query($link, "DELETE FROM t_registration WHERE id='$id'");

echo "<script>alert('Teacher deleted successfully!'); window.location='all-teacher-info.php';</script>";
exit;
