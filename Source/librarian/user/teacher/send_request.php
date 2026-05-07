<?php
session_start();
include 'inc/connection.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    echo "Unauthorized";
    exit();
}

$username = $_SESSION['username'];
$book_id  = intval($_POST['book_id']);

// USER TYPE FIX
$utype = 'teacher';

// GET BOOK NAME
$b = mysqli_query($link,"
    SELECT books_name FROM add_book 
    WHERE id='$book_id' LIMIT 1
");
$book = mysqli_fetch_assoc($b);
$bookName = $book['books_name'];

// PREVENT DUPLICATE
$check = mysqli_query($link,"
    SELECT id FROM reservations
    WHERE username='$username'
    AND book_id='$book_id'
    AND status='pending'
");

if (mysqli_num_rows($check) > 0) {
    echo "Already reserved.";
    exit();
}

// INSERT
mysqli_query($link,"
    INSERT INTO reservations
    (username, utype, book_id, book_name, reserved_at, status)
    VALUES
    ('$username','$utype','$book_id','$bookName',NOW(),'pending')
");

echo "Reservation sent.";
