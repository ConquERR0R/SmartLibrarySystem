<?php
include 'inc/connection.php';

$username = $_POST['username'] ?? '';
$book     = $_POST['book'] ?? '';
$utype    = strtolower($_POST['utype'] ?? '');
$reqType  = strtolower($_POST['reqType'] ?? '');

if (!$username || !$book) {
    exit("Invalid request.");
}

// CHECK BOOK AVAILABILITY
$b = mysqli_query($link,"
    SELECT quantity FROM add_book
    WHERE books_name='$book'
    LIMIT 1
");

if (mysqli_num_rows($b)==0) {
    exit("❌ Book not found.");
}

$bk = mysqli_fetch_assoc($b);
if ((int)$bk['quantity'] <= 0) {
    exit("❌ Book Reserved Not Available.");
}

// COUNT BORROWED BOOKS
$c = mysqli_query($link,"
    SELECT COUNT(*) AS total
    FROM issue_book
    WHERE username='$username' AND status='Borrowed'
");
$borrowCount = mysqli_fetch_assoc($c)['total'];

// RULES
if ($utype == 'student') {
    if ($borrowCount >= 3 && $reqType == 'borrow') {
        exit("❌ Student already has 3 borrowed books. Cannot borrow.");
    }
    exit("✅ Book available. Student may reserve.");
}

// TEACHER
exit("✅ Book available. Teacher can borrow (Unlimited).");
