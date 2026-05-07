<?php
session_start();
include "inc/connection.php";  // this sets $link, NOT $conn

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header("Location: login.php");
    exit;
}

$username = mysqli_real_escape_string($link, $_POST['username']);
$password = mysqli_real_escape_string($link, $_POST['password']);

// ROLE CHECK ORDER
$roles = [
    "librarian" => "lib_registration",
    "teacher"   => "t_registration",
    "student"   => "std_registration",
    "staff"     => "staff_registration"
];

foreach ($roles as $role => $table) {

    $query = mysqli_query($link, 
        "SELECT * FROM $table 
         WHERE username='$username' AND password='$password'"
    );

    if (mysqli_num_rows($query) > 0) {

        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        // REDIRECT ROLE
        if ($role == "librarian") {
            header("Location: dashboard.php"); 
            exit;
        }

        if ($role == "teacher") {
            header("Location: user/teacher/dashboard.php"); 
            exit;
        }

        if ($role == "student") {
            header("Location: user/student/dashboard.php"); 
            exit;
        }
        if ($role == "staff") {
            header("Location: user/staff/dashboard.php"); 
            exit;
        }
    }
}

// If no match
$_SESSION['error'] = "Incorrect username or password.";
header("Location: login.php");
exit;
?>
