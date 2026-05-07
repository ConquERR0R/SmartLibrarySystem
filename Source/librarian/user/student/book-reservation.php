<?php
session_start();
include 'inc/connection.php';
if (!isset($_SESSION['student'])) { header("Location: login.php"); exit(); }
include 'inc/header.php';

$username = mysqli_real_escape_string($link, $_SESSION['student']);
$res = mysqli_query($link, "SELECT * FROM Reservation WHERE username='$username' ORDER BY id DESC");
?>

<div class="dashboard-content">
  <div class="container mt-3">
    <h3>My Book Reservation</h3>
    <table class="table table-bordered table-striped">
      <thead><tr><th>Book</th><th>Date</th><th>Status</th></tr></thead>
      <tbody>
        <?php while($r = mysqli_fetch_assoc($res)): ?>
          <tr>
            <td><?= htmlspecialchars($r['book_name']) ?></td>
            <td><?= htmlspecialchars($r['reserved_at']) ?></td>
            <td><?= htmlspecialchars(ucfirst($r['status'])) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'inc/footer.php'; ?>
