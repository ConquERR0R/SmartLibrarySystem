<?php
include "inc/connection.php";

$username = $_POST['username'] ?? '';

if(!$username){ echo ""; exit; }

if(mysqli_num_rows(mysqli_query($link, "SELECT id FROM lib_registration WHERE username='$username'")) > 0){
    echo "Librarian";
}
elseif(mysqli_num_rows(mysqli_query($link, "SELECT id FROM t_registration WHERE username='$username'")) > 0){
    echo "Teacher";
}
elseif(mysqli_num_rows(mysqli_query($link, "SELECT id FROM std_registration WHERE username='$username'")) > 0){
    echo "Student";
}
elseif(mysqli_num_rows(mysqli_query($link, "SELECT id FROM staff_registration WHERE username='$username'")) > 0){
    echo "Staff";
}
else{
    echo "";
}
