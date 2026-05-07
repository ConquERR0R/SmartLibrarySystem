<?php 
session_start();

// ================= ROLE VALIDATION =================
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'staff') {
    header("Location: ../../login.php");
    exit();
}

// 👇 FIX: Ensure 'staff' index exists
if (!isset($_SESSION['staff'])) {
    $_SESSION['staff'] = $_SESSION['username']; 
}

$page = 'home';

include 'inc/connection.php'; 
include 'inc/header.php';

// Logged user
$username = $_SESSION['username']; 
$staff_id = $_SESSION['staff'];
?>

<!-- STAFF DASHBOARD -->
<div class="dashboard-content">

    <div class="dashboard-header">
        <div class="container">
            <div class="row">
                
                <div class="col-md-6">
                    <div class="left">
                        <p><span>dashboard</span> Staff Control Panel</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="right text-right">
                        <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
                        <span class="disabled">Dashboard</span>
                    </div>
                </div>

            </div>
        </div>  
    </div>

    <!-- MAIN STAFF FUNCTIONS -->
    <div class="container mt-4">

        <h4 class="mb-3">📌 Staff Tools</h4>

        <div class="row">

            <!-- Manage Students -->
            <div class="col-md-4">
                <a href="all-student-info.php" class="staff-box">
                    <div class="box-inner">
                        <h5>👨‍🎓 Manage Students</h5>
                        <p>View all student accounts and information.</p>
                    </div>
                </a>
            </div>

            <!-- Manage Teachers -->
            <div class="col-md-4">
                <a href="all-teacher-info.php" class="staff-box">
                    <div class="box-inner">
                        <h5>👩‍🏫 Manage Teachers</h5>
                        <p>View and update teacher information.</p>
                    </div>
                </a>
            </div>

            <!-- reservations Requests -->
            <div class="col-md-4">
                <a href="reservations.php" class="staff-box">
                    <div class="box-inner">
                        <h5>📚 reservations Requests</h5>
                        <p>Approve or reject book reservationss.</p>
                    </div>
                </a>
            </div>

            <!-- Borrower Status -->
<div class="col-md-4">
    <a href="borrower_status.php" class="staff-box">
        <div class="box-inner">
            <h5>📚 Borrower Status</h5>
            <p>Approve or decline borrow & reservation requests.</p>
        </div>
    </a>
</div>

            <!-- Returning -->
            <div class="col-md-4">
                <a href="return_book.php" class="staff-box">
                    <div class="box-inner">
                        <h5>🔄 Return Books</h5>
                        <p>Mark books as returned, handle overdue.</p>
                    </div>
                </a>
            </div>

            <!-- Logs -->
            <div class="col-md-4">
                <a href="logs.php" class="staff-box">
                    <div class="box-inner">
                        <h5>📝 Activity Logs</h5>
                        <p>All borrow & return activity records.</p>
                    </div>
                </a>
            </div>

        </div>
    </div>

</div>

<style>
.staff-box {
    text-decoration:none;
}
.box-inner{
    background:#222; 
    color:white; 
    padding:20px;
    border-radius:8px;
    margin-bottom:20px;
    box-shadow:0 0 8px rgba(255,255,255,0.1);
    transition:0.2s;
}
.box-inner:hover{
    transform:translateY(-5px);
    background:#333;
}
</style>

<?php include 'inc/footer.php'; ?>
