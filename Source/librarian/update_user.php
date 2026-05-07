<?php
session_start();
include 'inc/connection.php';

if (!isset($_SESSION["username"]) || $_SESSION["role"] != "librarian") {
    header("location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("location: all-users.php");
    exit;
}

// Sanitize POST
$id       = isset($_POST['id']) ? intval($_POST['id']) : 0;
$type     = isset($_POST['type']) ? trim($_POST['type']) : '';
$name     = trim($_POST['name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$regno    = trim($_POST['regno'] ?? '');
$address  = trim($_POST['address'] ?? '');
$sem      = trim($_POST['sem'] ?? '');
$session  = trim($_POST['session'] ?? '');
$dept     = trim($_POST['dept'] ?? '');
$status   = trim($_POST['status'] ?? 'active');

// Basic validation
if (!$id || ($type !== 'Student' && $type !== 'Teacher')) {
    $_SESSION['flash_error'] = "Invalid user data.";
    header("location: all-users.php");
    exit;
}

// duplicate checks: username, email, regno
// check username in both tables (excluding current record if same table)
$errors = [];

// check username duplicates
$stmt = $link->prepare("SELECT id FROM std_registration WHERE username = ?".($type=='Student' ? " AND id <> ?":""));
if ($type=='Student') $stmt->bind_param("si", $username, $id); else $stmt->bind_param("s", $username);
$stmt->execute(); $stmt->store_result();
if ($stmt->num_rows > 0) $errors[] = "Username already used by a student.";
$stmt->close();

$stmt = $link->prepare("SELECT id FROM t_registration WHERE username = ?".($type=='Teacher' ? " AND id <> ?":""));
if ($type=='Teacher') $stmt->bind_param("si", $username, $id); else $stmt->bind_param("s", $username);
$stmt->execute(); $stmt->store_result();
if ($stmt->num_rows > 0) $errors[] = "Username already used by a teacher.";
$stmt->close();

// check email duplicates
if ($email !== '') {
    $stmt = $link->prepare("SELECT id FROM std_registration WHERE email = ?".($type=='Student' ? " AND id <> ?":""));
    if ($type=='Student') $stmt->bind_param("si", $email, $id); else $stmt->bind_param("s", $email);
    $stmt->execute(); $stmt->store_result();
    if ($stmt->num_rows > 0) $errors[] = "Email already used by a student.";
    $stmt->close();

    $stmt = $link->prepare("SELECT id FROM t_registration WHERE email = ?".($type=='Teacher' ? " AND id <> ?":""));
    if ($type=='Teacher') $stmt->bind_param("si", $email, $id); else $stmt->bind_param("s", $email);
    $stmt->execute(); $stmt->store_result();
    if ($stmt->num_rows > 0) $errors[] = "Email already used by a teacher.";
    $stmt->close();
}

// check regno duplicates (only if provided)
if ($regno !== '') {
    $stmt = $link->prepare("SELECT id FROM std_registration WHERE regno = ?".($type=='Student' ? " AND id <> ?":""));
    if ($type=='Student') $stmt->bind_param("si", $regno, $id); else $stmt->bind_param("s", $regno);
    $stmt->execute(); $stmt->store_result();
    if ($stmt->num_rows > 0) $errors[] = "RegNo already used by a student.";
    $stmt->close();

    $stmt = $link->prepare("SELECT id FROM t_registration WHERE regno = ?".($type=='Teacher' ? " AND id <> ?":""));
    if ($type=='Teacher') $stmt->bind_param("si", $regno, $id); else $stmt->bind_param("s", $regno);
    $stmt->execute(); $stmt->store_result();
    if ($stmt->num_rows > 0) $errors[] = "RegNo already used by a teacher.";
    $stmt->close();
}

// if errors found, stop
if (!empty($errors)) {
    $_SESSION['flash_error'] = implode(" ", array_unique($errors));
    header("location: all-users.php");
    exit;
}

// perform update
if ($type === 'Student') {
    $stmt = $link->prepare("UPDATE std_registration SET name=?, username=?, email=?, phone=?, regno=?, address=?, sem=?, session=?, dept=?, status=? WHERE id=?");
    $stmt->bind_param("ssssssssssi",
        $name, $username, $email, $phone, $regno, $address, $sem, $session, $dept, $status, $id
    );
    $ok = $stmt->execute();
    $stmt->close();
} else { // Teacher
    $stmt = $link->prepare("UPDATE t_registration SET name=?, username=?, email=?, phone=?, regno=?, dept=?, status=? WHERE id=?");
    $stmt->bind_param("sssssssi",
        $name, $username, $email, $phone, $regno, $dept, $status, $id
    );
    $ok = $stmt->execute();
    $stmt->close();
}

if ($ok) {
    $_SESSION['flash_success'] = "User updated successfully.";
} else {
    $_SESSION['flash_error'] = "Update failed. Try again.";
}

header("location: all-users.php");
exit;
