<?php
session_start();

// CLEAR ALL session values
$_SESSION = array();

// DESTROY session completely
session_destroy();

// REDIRECT to login
header("Location: ../../login.php");
exit;
?>
