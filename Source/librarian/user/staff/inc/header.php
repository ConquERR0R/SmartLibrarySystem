<?php
// SAFE SESSION START
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CORRECT PATH: same folder level as header.php
include 'connection.php';

// ROLE VALIDATION
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../login.php");
    exit();
}

$staff_username = $_SESSION['username'];

// FETCH STAFF DATA
$staff_q = mysqli_query($link, 
    "SELECT * FROM staff_registration WHERE username='$staff_username' LIMIT 1"
);
$staff = mysqli_fetch_assoc($staff_q);

// FETCH UNREAD NOTIFICATIONS
$notif_q = mysqli_query($link, 
    "SELECT COUNT(*) AS total FROM notifications 
     WHERE username='$staff_username' AND is_read='no'"
);
$notif = mysqli_fetch_assoc($notif_q)['total'] ?? 0;

// ACTIVE PAGE (fallback)
if (!isset($page)) $page = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart Library System - Staff</title>

    <!-- FIXED PATHS TO CSS -->
    <link rel="stylesheet" href="inc/css/bootstrap.min.css">
    <link rel="stylesheet" href="inc/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="inc/css/pro1.css">

    <style>
        /* ----- STAFF SIDEBAR ----- */
        .staff-sidebar{
            width:250px;
            height:100vh;
            background:#111;
            color:white;
            position:fixed;
            left:0; top:0;
            padding:20px;
            box-shadow:2px 0 10px rgba(0,0,0,0.4);
            overflow-y:auto;
        }
        .staff-sidebar h3{ font-weight:bold; font-size:18px; }
        .staff-sidebar img{
            width:85px; height:85px; border-radius:50%; object-fit:cover;
            border:2px solid #fff;
        }
        .staff-menu a{
            display:block; padding:10px; color:white; text-decoration:none; border-radius:6px;
            margin-bottom:6px; transition:0.15s;
        }
        .staff-menu a:hover{ background:#222; transform:translateX(4px); }
        .active-menu{ background:#333 !important; }

        /* TOP NAV */
        .staff-topbar{
            margin-left:250px;
            height:65px;
            background:white;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:0 20px;
            box-shadow:0 2px 6px rgba(0,0,0,0.15);
        }
        .staff-topbar img{
            width:40px; height:40px; border-radius:50%; object-fit:cover;
        }

        .staff-content{
            margin-left:250px; padding:20px;
            min-height:calc(100vh - 80px);
            background:#f5f7fb;
        }

        .badge-notif{
            background:#e53935; color:white; border-radius:50%;
            padding:3px 7px; font-weight:700; margin-left:6px;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="staff-sidebar">
    <h3><i class="fas fa-book"></i> STAFF PANEL</h3>
    <hr>

    <div class="text-center mb-3">

        <!-- FIXED PHOTO PATH -->
        <img src="upload/<?= htmlspecialchars($staff['photo'] ?: 'avatar.jpg'); ?>" alt="">

        <p class="mt-2 mb-0"><?= htmlspecialchars($staff['name']); ?></p>
        <small>@<?= htmlspecialchars($staff_username) ?></small>
    </div>

    <hr>

    <div class="staff-menu">
        <a href="dashboard.php" class="<?= ($page=='home')?'active-menu':'' ?>">
            <i class="fas fa-home"></i> Dashboard
        </a>
		<a href="profile.php" class="<?= ($page=='profile')?'active-menu':'' ?>">
    <i class="fas fa-user"></i> My Profile
</a>


        <a href="reservations.php" class="<?= ($page=='reservations')?'active-menu':'' ?>">
            <i class="fas fa-calendar-check"></i> Reservations
        </a>
		
        <a href="issued_books.php" class="<?= ($page=='issued')?'active-menu':'' ?>">
            <i class="fas fa-book"></i> Issued Books
        </a>

        <a href="return_book.php" class="<?= ($page=='return')?'active-menu':'' ?>">
            <i class="fas fa-sync"></i> Return Book
        </a>

        <a href="borrower_status.php" class="<?= ($page=='borrower_status')?'active-menu':'' ?>">
            <i class="fas fa-clipboard-list"></i> Borrower Status
        </a>

        <a href="penalties.php" class="<?= ($page=='penalties')?'active-menu':'' ?>">
            <i class="fas fa-exclamation-triangle"></i> Penalties
        </a>

        <a href="logs.php" class="<?= ($page=='logs')?'active-menu':'' ?>">
            <i class="fas fa-history"></i> Activity Logs
        </a>

        <a href="notifications.php" class="<?= ($page=='notifications')?'active-menu':'' ?>">
            <i class="fas fa-bell"></i> Notifications
            <?php if($notif>0): ?>
                <span class="badge-notif"><?= $notif ?></span>
            <?php endif; ?>
        </a>

        <a href="logout.php">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>

<!-- TOP BAR -->
<div class="staff-topbar">
    <h4>📚 Smart Library Staff Panel</h4>

    <div class="d-flex align-items-center">
        <a href="notifications.php" class="me-3" style="text-decoration:none;color:#333;">
            <i class="fas fa-bell fa-lg"></i>
            <?php if($notif>0): ?>
                <span class="badge-notif"><?= $notif ?></span>
            <?php endif; ?>
        </a>

        <!-- FIXED TOPBAR PHOTO PATH -->
        <img src="upload/<?= htmlspecialchars($staff['photo'] ?: 'avatar.jpg'); ?>" alt="">
    </div>
</div>

<!-- MAIN CONTENT WRAPPER -->
<div class="staff-content">
