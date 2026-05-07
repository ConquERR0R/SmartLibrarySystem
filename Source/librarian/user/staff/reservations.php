<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../login.php");
    exit();
}

include '../../inc/connection.php';
$page = 'reservations';

// Get all reservations
$reservations = mysqli_query($link, "
    SELECT * FROM reservations
    ORDER BY id DESC
");
?>

<?php include 'inc/header.php'; ?>

<div class="staff-content" style="padding:20px;">

    <h3><i class="fas fa-calendar-check"></i> Book Reservation Requests</h3>
    <hr>

    <table id="reserveTable" class="table table-striped table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>User</th>
                <th>User Type</th>
                <th>Book Name</th>
                <th>Book ID</th>
                <th>Date</th>
                <th>Status</th>
                <th>Borrow Count</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while ($row = mysqli_fetch_assoc($reservations)):

            $user = $row['username'];
            $userType = strtolower($row['utype']);  // 'teacher' or 'student'

            // COUNT CURRENT BORROWED BOOKS
            $checkBorrow = mysqli_query($link, "
                SELECT COUNT(*) AS total 
                FROM issue_book
                WHERE username='$user' AND status='Borrowed'
            ");
            $borrowCount = mysqli_fetch_assoc($checkBorrow)['total'];

            // Normalize status
            $status = strtolower($row['status']);

        ?>

        <tr>
            <td><?= $row['username'] ?></td>

            <!-- USER TYPE DISPLAY -->
            <td><?= ucfirst($userType) ?></td>

            <td><?= $row['book_name'] ?></td>
            <td><?= $row['book_id'] ?></td>
            <td><?= $row['reserved_at'] ?></td>

            <!-- STATUS DISPLAY -->
            <td>
                <?php if ($status == 'pending' || $status == 'requested' || $status == 'reserved'): ?>
                    <span class="badge bg-warning text-dark">Pending</span>
                <?php elseif ($status == 'active' || $status == 'approved'): ?>
                    <span class="badge bg-success">Approved</span>
                <?php elseif ($status == 'declined'): ?>
                    <span class="badge bg-danger">Declined</span>
                <?php endif; ?>
            </td>

            <!-- BORROW COUNT DISPLAY -->
            <td>
                <?php if ($userType === 'teacher'): ?>
                    <b><?= $borrowCount ?></b> <span class="badge bg-info">Unlimited</span>
                <?php else: ?>
                    <b><?= $borrowCount ?></b> / 3
                <?php endif; ?>
            </td>

            <!-- ACTION BUTTONS -->
            <td>
                <?php 
                // Only for pending
                if ($status == 'pending' || $status == 'requested' || $status == 'reserved') {

                    // STUDENT: limit of 3
                    if ($userType == 'student' && $borrowCount >= 3) {
                        echo '<button class="btn btn-secondary btn-sm" disabled>Limit Reached</button>';
                    } else {
                        echo '<a href="reservations_action.php?id='.$row['id'].'&action=approve" 
                                class="btn btn-success btn-sm">Accept</a> ';
                    }

                    // Decline always available
                    echo '<a href="reservations_action.php?id='.$row['id'].'&action=decline" 
                            class="btn btn-danger btn-sm">Decline</a>';
                }

                // Approved state
                elseif ($status == 'active' || $status == 'approved') {
                    echo '<span class="text-success">Approved</span>';
                }

                // Declined
                else {
                    echo '<span class="text-danger">Declined</span>';
                }
                ?>
            </td>

        </tr>

        <?php endwhile; ?>
        </tbody>
    </table>

</div>

<script>
$(document).ready(function() {
    $('#reserveTable').DataTable();
});
</script>

<?php include 'inc/footer.php'; ?>
