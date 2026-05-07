<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit();
}

include 'inc/connection.php';
include 'inc/header.php';

$username = $_SESSION['username'];

// CURRENT SEMESTER (example only – adjust if naa kay semester table)
$current_semester = "2024-2025-1st";
?>

<div class="container mt-4">
    <h3>📄 Clearance Status</h3>

    <?php
    $check = mysqli_query($link,"
        SELECT COUNT(*) AS total
        FROM issue_book
        WHERE username='$username'
        AND status='Borrowed'
        AND semester='$current_semester'
    ");

    $row = mysqli_fetch_assoc($check);
    $unreturned = $row['total'];

    if ($unreturned > 0):
    ?>
        <div class="alert alert-danger">
            ❌ <b>Clearance NOT Cleared</b><br>
            You still have <b><?= $unreturned ?></b> unreturned book(s) this semester.
        </div>
    <?php else: ?>
        <div class="alert alert-success">
            ✅ <b>Clearance Cleared</b><br>
            All borrowed books for this semester are returned.
        </div>
    <?php endif; ?>

</div>

<?php include 'inc/footer.php'; ?>
