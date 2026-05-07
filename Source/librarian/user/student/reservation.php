<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../login.php");
    exit();
}

include '../../inc/connection.php';
$page = 'reservations';

$reservations = mysqli_query($link, "SELECT * FROM reservations ORDER BY id DESC");

include 'inc/header.php';
?>

<div class="staff-content" style="padding:20px;">
  <h3><i class="fas fa-calendar-check"></i> Book Reservation Requests</h3>
  <hr>

  <table id="reserveTable" class="table table-striped table-bordered text-center">
    <thead class="table-dark">
      <tr>
        <th>User</th>
        <th>Email</th>
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
        $type = strtolower($row['user_type']);

        if ($type == 'teacher') {
            // Teachers have unlimited books
            $cb = mysqli_query($link, "
                SELECT COUNT(*) AS total 
                FROM issue_book 
                WHERE username='$user' AND status='Borrowed'
            ");
            $borrowCount = mysqli_fetch_assoc($cb)['total'];
            $borrowText = "<b>$borrowCount</b> / 3";
        } else {
            // Teachers = unlimited
            $borrowCount = 0;
            $borrowText = "<span class='badge bg-info'>Unlimited</span>";
        }
      ?>

      <tr>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= ucfirst(htmlspecialchars($row['user_type'])) ?></td>
        <td><?= htmlspecialchars($row['book_name']) ?></td>
        <td><?= htmlspecialchars($row['book_id']) ?></td>
        <td><?= htmlspecialchars($row['reserved_at']) ?></td>

        <td>
          <?php if ($row['status'] == 'pending'): ?>
            <span class="badge bg-warning text-dark">Pending</span>
          <?php elseif ($row['status'] == 'approved'): ?>
            <span class="badge bg-success">Approved</span>
          <?php else: ?>
            <span class="badge bg-danger">Declined</span>
          <?php endif; ?>
        </td>

        <td><?= $borrowText ?></td>

        <td>
          <?php if ($row['status'] == 'pending'): ?>

            <?php if ($type == '' && $borrowCount >= 3): ?>
              <button class="btn btn-secondary btn-sm" disabled>Limit Reached</button>
            <?php else: ?>
              <a href="reservation_action.php?id=<?= $row['id'] ?>&action=approve"
                 class="btn btn-success btn-sm">Accept</a>
            <?php endif; ?>

            <a href="reservation_action.php?id=<?= $row['id'] ?>&action=decline"
               class="btn btn-danger btn-sm">Decline</a>

          <?php elseif ($row['status'] == 'approved'): ?>
            <span class="text-success">Approved</span>

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
