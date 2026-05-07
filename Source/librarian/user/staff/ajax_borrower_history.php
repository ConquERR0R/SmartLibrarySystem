<?php
include 'inc/connection.php';
$user = $_GET['user'] ?? '';
$book = $_GET['book'] ?? '';
$user = mysqli_real_escape_string($link, $user);
$book = mysqli_real_escape_string($link, $book);

// collect last 10 records from issue_book, t_issuebook, borrow_records
$html = "<h5>Recent activity for {$user}</h5>";
$html .= "<table class='table table-sm'><thead><tr><th>Date</th><th>Action</th><th>Book</th></tr></thead><tbody>";

$q1 = mysqli_query($link, "SELECT booksissuedate AS dt, 'Issued' as action, booksname AS book FROM issue_book WHERE username='$user' 
        UNION 
        SELECT booksissuedate AS dt, 'Issued (Teacher)' as action, booksname AS book FROM t_issuebook WHERE username='$user'
        UNION
        SELECT borrow_date AS dt, status as action, NULL as book FROM borrow_records WHERE username='$user'
        ORDER BY dt DESC LIMIT 10");

if(mysqli_num_rows($q1) == 0){
    $html .= "<tr><td colspan='3'>No activity found.</td></tr>";
} else {
    while($r = mysqli_fetch_assoc($q1)){
        $html .= "<tr><td>".htmlspecialchars($r['dt'])."</td><td>".htmlspecialchars($r['action'])."</td><td>".htmlspecialchars($r['book'])."</td></tr>";
    }
}

$html .= "</tbody></table>";
echo $html;
