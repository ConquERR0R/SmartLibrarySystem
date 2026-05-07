<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../login.php");
    exit();
}

include '../../inc/connection.php';

// ==========================
// VALIDATE INPUT
// ==========================
if (!isset($_GET['id']) || !isset($_GET['action'])) {
    die("Invalid request.");
}

$id = intval($_GET['id']);
$action = $_GET['action'];

// ==========================
// GET RESERVATION DETAILS
// ==========================
$res = mysqli_query($link, "
    SELECT * FROM reservations WHERE id = $id LIMIT 1
");

if (mysqli_num_rows($res) === 0) {
    die("Reservation not found.");
}

$reservation = mysqli_fetch_assoc($res);

$username = $reservation['username'];
$book_id  = $reservation['book_id'];
$bookName = $reservation['book_name'];
$userType = strtolower($reservation['user_type']);  // 'student' or 'teacher'

// ==========================
// COUNT CURRENT BORROWED BOOKS
// ==========================
$countQ = mysqli_query($link, "
    SELECT COUNT(*) AS total 
    FROM issue_book 
    WHERE username='$username' AND status='Borrowed'
");
$borrowCount = mysqli_fetch_assoc($countQ)['total'];

// ==========================
// LIMIT ONLY FOR STUDENTS
// ==========================
if ($userType === 'student' && $borrowCount >= 3) {
    echo "<script>alert('This student already reached the 3-book limit!'); 
    window.location='reservations.php';</script>";
    exit();
}

// ==========================
// APPROVE REQUEST
// ==========================
if ($action === 'approve') {

    // UPDATE reservation status
    mysqli_query($link, "
        UPDATE reservations 
        SET status='approved'
        WHERE id=$id
    ");

    // INSERT into issue_book table
    mysqli_query($link, "
        INSERT INTO issue_book (
            username,
            book_id,
            booksname,
            booksissuedate,
            status
        ) VALUES (
            '$username',
            '$book_id',
            '$bookName',
            NOW(),
            'Borrowed'
        )
    ");

    echo "<script>
        alert('Reservation approved successfully!');
        window.location='reservations.php';
    </script>";
    exit();
}

// ==========================
// DECLINE REQUEST
// ==========================
if ($action === 'decline') {

    mysqli_query($link, "
        UPDATE reservations 
        SET status='declined'
        WHERE id=$id
    ");

    echo "<script>
        alert('Reservation declined.');
        window.location='reservations.php';
    </script>";
    exit();
}

?>
