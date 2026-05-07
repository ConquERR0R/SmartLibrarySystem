<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Account | Smart Library</title>

<link rel="stylesheet" href="inc/css/bootstrap.min.css">

<style>
body{
    background: url("styles/ctu2.jpg");
    background-size: cover;
    background-position: center;
    backdrop-filter: blur(2px);
}

.box{
    width: 420px;
    background: rgba(255,255,255,0.9);
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.2);
    margin: 80px auto;
}

.role-btn{
    border-radius: 10px;
    padding: 12px;
    font-size: 17px;
    font-weight: bold;
    transition: 0.3s;
}

.role-btn:hover{
    transform: scale(1.05);
}
</style>
</head>

<body>

<div class="box text-center">
    <h3 class="fw-bold mb-3">Create your Account</h3>
    <p class="text-muted mb-4">Choose what type of user you want to register as:</p>

    <!-- STUDENT BUTTON -->
    <a href="user/student/registration.php" 
       class="btn btn-primary w-100 role-btn mb-3">
        👨‍🎓 Register as Student
    </a>

    <!-- TEACHER BUTTON -->
    <a href="user/teacher/registration.php" 
       class="btn btn-success w-100 role-btn mb-3">
        👨‍🏫 Register as Teacher
    </a>

    <!-- BACK TO LOGIN -->
    <a href="login.php" class="btn btn-secondary w-100 role-btn">
        ← Back to Login
    </a>
</div>

</body>
</html>
