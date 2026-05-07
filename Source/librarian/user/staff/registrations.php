<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../login.php");
    exit();
}
include '../../inc/connection.php';
$page='reservations';
$reservations = mysqli_query($link, "SELECT * FROM reservations ORDER BY id DESC");
include 'inc/header.php';
?>

<div class="staff-content" style="padding:20px;">
  <h3><i class="fas fa-calendar-check"></i> Book reservations Requests</h3>
  <hr>

  <table id="reserveTable" class="table table-striped table-bordered text-center">
    <thead class="table-dark">
      <tr>
        <th>User</th>
        <th>Email</th>
        <th>User Type</th>
        <th>Book Name</th>
        <th>Date</th>
        <th>Status</th>
        <th>Borrowed Count</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($reservationss)):
        $user = $row['username'];
        // count active borrowed
        $cb = mysqli_query($link, "SELECT COUNT(*) AS total FROM issue_book WHERE username='$user' AND status='Borrowed'");
        $borrowCount = mysqli_fetch_assoc($cb)['total'];
      ?>
      <tr>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['user_type']) ?></td>
        <td><?= htmlspecialchars($row['book_name']) ?></td>
        <td><?= htmlspecialchars($row['reserved_at']) ?></td>
        <td>
          <?php if ($row['status']=='pending'): ?>
            <span class="badge bg-warning text-dark">Pending</span>
          <?php elseif ($row['status']=='approved'): ?>
            <span class="badge bg-success">Approved</span>
          <?php else: ?>
            <span class="badge bg-danger">Declined</span>
          <?php endif; ?>
        </td>
        <td><b><?= $borrowCount ?></b> / 3</td>
        <td>
          <?php if ($row['status']=='pending'): ?>
            <?php if ($borrowCount >= 3): ?>
              <button class="btn btn-secondary btn-sm" disabled>Limit Reached</button>
            <?php else: ?>
              <a href="reservations_action.php?id=<?= $row['id'] ?>&action=approve" class="btn btn-success btn-sm">Accept</a>
            <?php endif; ?>
            <a href="reservations_action.php?id=<?= $row['id'] ?>&action=decline" class="btn btn-danger btn-sm">Decline</a>
          <?php elseif($row['status']=='approved'): ?>
            <span class="text-success">Already Approved</span>
          <?php else: ?>
            <span class="text-danger">Declined</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script>
$(document).ready(function(){ $('#reserveTable').DataTable(); });
</script>

<?php include 'inc/footer.php'; ?>
