<?php
include "inc/connection.php";

mysqli_query($link, "UPDATE std_registration SET status='active' WHERE status='pending'");
mysqli_query($link, "UPDATE t_registration SET status='active' WHERE status='pending'");
mysqli_query($link, "UPDATE request_books SET read1='yes' WHERE read1='no'");

echo "done";
?>
