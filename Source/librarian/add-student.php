<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("location: login.php");
    exit;
}

include 'inc/header.php';
include 'inc/connection.php';

// Handle approval
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    mysqli_query($link, "UPDATE std_registration SET status='approved' WHERE id='$id'");
}

// Handle decline
if (isset($_GET['decline'])) {
    $id = $_GET['decline'];
    mysqli_query($link, "DELETE FROM std_registration WHERE id='$id'");
}

?>

<div class="dashboard-content">
	<div class="dashboard-header">
		<div class="container text-center">
			<h3>Pending Student Accounts</h3>
			<p>Review requests and approve/decline accounts</p>
		</div>
	</div>

	<div class="container mt-4">
	<table id="studentsTable" class="table table-dark table-striped text-center">
		<thead>
			<tr>
				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Reg No</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php  
			$res = mysqli_query($link, "SELECT * FROM std_registration ORDER BY id DESC");
			while ($row = mysqli_fetch_array($res)) {
				echo "<tr>";
				echo "<td>{$row['name']}</td>";
				echo "<td>{$row['username']}</td>";
				echo "<td>{$row['email']}</td>";
				echo "<td>{$row['phone']}</td>";
				echo "<td>{$row['regno']}</td>";
				echo "<td>{$row['status']}</td>";
				echo "<td>";

				// Buttons
				if ($row['status'] == 'pending' || $row['status'] == 'no') {
					echo "<a href='add-student.php?approve={$row['id']}' class='btn btn-success btn-sm'>Approve</a> ";
					echo "<a href='add-student.php?decline={$row['id']}' class='btn btn-danger btn-sm'>Decline</a>";
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
	$('#studentsTable').DataTable();
});
</script>

<?php include 'inc/footer.php'; ?>
