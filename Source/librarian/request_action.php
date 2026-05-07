<?php
session_start();
include 'inc/connection.php';

$action = $_POST['action'];
$id     = $_POST['id'];

if($action == 'approve'){

	$username = $_POST['username'];
	$bookname = $_POST['bookname'];

	// update request status
	mysqli_query($link, "UPDATE request_books SET status='approved' WHERE id='$id'");

	// insert into issue_book table
	mysqli_query($link, "
		INSERT INTO issue_book (username, booksname, booksissuedate, booksreturndate, status)
		VALUES ('$username', '$bookname', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'Borrowed')
	");

	echo "📘 Request Approved Successfully!";
}

elseif($action == 'decline'){
	mysqli_query($link, "UPDATE request_books SET status='declined' WHERE id='$id'");
	echo "❌ Request Declined.";
}

?>
