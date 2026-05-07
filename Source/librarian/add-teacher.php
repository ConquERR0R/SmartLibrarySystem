<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location: login.php");
    exit;
}

include 'inc/header.php';
include 'inc/connection.php';

// Approve
if (isset($_GET['approve'])) {
    mysqli_query($link, "UPDATE t_registration SET status='approved' WHERE id='{$_GET['approve']}'");
}

// Decline
if (isset($_GET['decline'])) {
    mysqli_query($link, "DELETE FROM t_registration WHERE id='{$_GET['decline']}'");
}
?>

<div class="dashboard-content">
	<div class="dashboard-header">
		<div class="container text-center">
			<h3>Pending Teacher Accounts</h3>
			<p>Approve or decline new teacher registrations</p>
		</div>
	</div>

	<div class="container mt-4">
	<table id="teachersTable" class="table table-dark table-striped text-center">
		<thead>
			<tr>
				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Phone</th>
				<th>ID No</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php  
			$res = mysqli_query($link, "SELECT * FROM t_registration ORDER BY id DESC");
			while ($row = mysqli_fetch_array($res)) {
				echo "<tr>";
				echo "<td>{$row['name']}</td>";
				echo "<td>{$row['username']}</td>";
				echo "<td>{$row['email']}</td>";
				echo "<td>{$row['phone']}</td>";
				echo "<td>{$row['idno']}</td>";
				echo "<td>{$row['status']}</td>";
				echo "<td>";

				if ($row['status'] == 'pending' || $row['status'] == 'no') {
					echo "<a href='add-teacher.php?approve={$row['id']}' class='btn btn-success btn-sm'>Approve</a> ";
					echo "<a href='add-teacher.php?decline={$row['id']}' class='btn btn-danger btn-sm'>Decline</a>";
				} else {
					echo "<span class='badge badge-success'>Active</span>";
				}

				echo "</td>";
				echo "</tr>";
			}
		?>
		</tbody>
	</table>
	</div>
</div>

<script>
$(document).ready(function () {
	$('#teachersTable').DataTable();
});
</script>

<?php include 'inc/footer.php'; ?>
