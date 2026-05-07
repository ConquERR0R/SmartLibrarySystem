<?php
session_start();
include '../../inc/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
    header("Location: ../../login.php");
    exit();
}

$id = intval($_GET['id']);
$action = $_GET['action'];

$res = mysqli_query($link,"
    SELECT * FROM reservations 
    WHERE id='$id' LIMIT 1
");

if (mysqli_num_rows($res) == 0) {
    header("Location: reservations.php");
    exit();
}

$r = mysqli_fetch_assoc($res);

$username  = $r['username'];
$book_id   = $r['book_id'];
$book_name = $r['book_name'];
$utype     = strtolower($r['utype']);

if ($action == 'approve') {

    // STUDENT LIMIT CHECK
    if ($utype == 'student') {
        $cnt = mysqli_query($link,"
            SELECT COUNT(*) AS total 
            FROM issue_book 
            WHERE username='$username'
            AND status='Borrowed'
        ");
        $borrowed = mysqli_fetch_assoc($cnt)['total'];

        if ($borrowed >= 3) {
            header("Location: reservations.php?limit=1");
            exit();
        }
    }

    // INSERT REAL BORROW
    mysqli_query($link,"
        INSERT INTO issue_book
        (username, book_id, booksname, booksissuedate, status)
        VALUES
        ('$username','$book_id','$book_name',NOW(),'Borrowed')
    ");

    // MARK RESERVATION USED
    mysqli_query($link,"
        UPDATE reservations
        SET status='converted'
        WHERE id='$id'
    ");

    header("Location: reservations.php?approved=1");
    exit();
}

if ($action == 'decline') {
    mysqli_query($link,"
        UPDATE reservations
        SET status='declined'
        WHERE id='$id'
    ");

    header("Location: reservations.php?declined=1");
    exit();
}
