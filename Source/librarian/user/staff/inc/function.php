<?php
include 'connection.php';

if (isset($_POST["submit"])) {

    // Inputs
    $name     = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $email    = trim($_POST["email"]);
    $phone    = trim($_POST["phone"]);
    $address  = trim($_POST["address"]);

    $photo = "upload/avatar.jpg";
    $status = "active";

    // Empty validation
    if ($name=="" || $username=="" || $password=="" || $email=="" || $phone=="" || $address=="") {
        $error_m = "<b>Error!</b> All fields are required.";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_email = "Invalid email address.";
    }
    elseif (strlen($username) < 6 || strlen($username) > 16) {
        $error_uname = "Username must be 6-16 characters.";
    }
    elseif (strlen($password) < 6 || strlen($password) > 16) {
        $error_pw = "Password must be 6-16 characters.";
    }
    else {

        function exists($link, $table, $field, $value){
            $q = mysqli_query($link, "SELECT id FROM $table WHERE $field='$value' LIMIT 1");
            return mysqli_num_rows($q) > 0;
        }

        // Check duplicates
        $duplicateUsername = (
            exists($link, "std_registration", "username", $username) ||
            exists($link, "t_registration", "username", $username)  ||
            exists($link, "staff_registration", "username", $username) ||
            exists($link, "lib_registration", "username", $username)
        );

        $duplicateEmail = (
            exists($link, "std_registration", "email", $email) ||
            exists($link, "t_registration", "email", $email) ||
            exists($link, "staff_registration", "email", $email) ||
            exists($link, "lib_registration", "email", $email)
        );

        $duplicatePhone = (
            exists($link, "std_registration", "phone", $phone) ||
            exists($link, "t_registration", "phone", $phone) ||
            exists($link, "staff_registration", "phone", $phone) ||
            exists($link, "lib_registration", "phone", $phone)
        );

        if ($duplicateUsername) {
            $error_uname = "Username already exists.";
        }
        elseif ($duplicateEmail) {
            $error_email = "Email already exists.";
        }
        elseif ($duplicatePhone) {
            $error_phone = "Phone number already exists.";
        }
        else {

            $vkey = md5(time() . $username);

            $insert = mysqli_query($link, "
                INSERT INTO staff_registration 
                (name, username, password, email, phone, address, photo, status, vkey, verified)
                VALUES 
                ('$name', '$username', '$password', '$email', '$phone', '$address', '$photo', 'active', '$vkey', 'no')
            ");

            if ($insert) {

                $verifyLink = "http://localhost/webdev2/SmartLibrarySystem/Source/librarian/user/staff/verify.php?vkey=$vkey";

                $subject = "Verify Your Staff Account";
                $message = "<a href='$verifyLink'>Click here to verify your staff account</a>";
                $headers = "From: library-system@gmail.com\r\n";
                $headers.= "MIME-Version: 1.0\r\n";
                $headers.= "Content-type: text/html; charset=UTF-8\r\n";

                mail($email, $subject, $message, $headers);

                header("Location: thankyou.php");
                exit();

            } else {
                echo mysqli_error($link);
            }
        }
    }
}
?>
