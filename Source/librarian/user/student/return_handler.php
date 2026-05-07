<?php
session_start();
include 'inc/connection.php';

if (!isset($_SESSION['student'])) {
	echo "Unauthorized";
	exit;
}

if (!isset($_POST['issue_id']) || !isset($_POST['reason'])) {
	echo "Invalid request";
	exit;
}

$issue_id = $_POST['issue_id'];
$reason   = $_POST['reason'];

// get issue details
$res = mysqli_query($link, "SELECT booksname FROM issue_book WHERE id='$issue_id'");
$row = mysqli_fetch_assoc($res);
$bookName = $row['booksname'];

$returnDate = date("Y-m-d");

// penalty logic
$issueData = mysqli_query($link, "SELECT booksreturndate FROM issue_book WHERE id='$issue_id'");
$issueInfo = mysqli_fetch_assoc($issueData);

$due = strtotime($issueInfo['booksreturndate']);
$today = strtotime(date("Y-m-d"));
$overdueDays = max(0, floor(($today - $due) / 86400));
$fineAmount = $overdueDays * 5; // ₱5/day

// update issue record
mysqli_query($link, "
	UPDATE issue_book 
	SET status='Returned',
		return_type='$reason',
		actual_return_date='$returnDate',
		overdue_days='$overdueDays',
		fine='$fineAmount'
	WHERE id='$issue_id'
");

// return stock
mysqli_query($link, "
	UPDATE add_book SET books_availability = books_availability + 1 
	WHERE books_name='$bookName'
");

// NOTIFICATION (THIS PART BELONGS HERE)
$username = $_SESSION['student'];
mysqli_query($link, "
	INSERT INTO notifications(username, message) VALUES(
		'$username',
		'📦 Your book return ($bookName) has been received.'
	)
");

echo "📦 Book returned successfully!";
?>
