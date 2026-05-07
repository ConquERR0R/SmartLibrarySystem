<?php 
session_start();

if (!isset($_SESSION["username"])) {
	echo "<script>window.location='login.php';</script>";
	exit();
}

$page = 'rbook';
include 'inc/header.php';
include 'inc/connection.php';

// Mark notifications as read
mysqli_query($link,"UPDATE request_books SET read1='yes'");
?>

<div class="dashboard-content">
	<div class="dashboard-header">
		<div class="container">

			<div class="row">
				<div class="col-md-6">
					<div class="left">
						<p><span>dashboard</span> Control Panel</p>
					</div>
				</div>
				<div class="col-md-6 text-right">
					<a href="dashboard.php"><i class="fas fa-home"></i>Home</a>
					<span class="disabled">Requested Books</span>
				</div>
			</div>

			<div class="issued-content">
				<div class="row">
					<div class="col-md-12">
						<div class="rbook-info status">

							<table id="dtBasicExample" class="table table-striped table-dark text-center">
								<thead>
									<tr>
										<th>Name</th>
										<th>Username</th>
										<th>User Type</th>
										<th>Email</th>
										<th>Book</th>
										<th>URL</th>
										<th>Status</th>
										<th>Requested On</th>
										<th>Action</th>
									</tr>
								</thead>

								<tbody>
									<?php
									// 🔥 Now sorted by latest time (req_date)
									$res = mysqli_query($link, "SELECT * FROM request_books ORDER BY req_date DESC");

									while ($row = mysqli_fetch_assoc($res)) {
										$status = ucfirst($row['status']); // Format text

										echo "<tr>";
										echo "<td>{$row['name']}</td>";
										echo "<td>{$row['username']}</td>";
										echo "<td>{$row['utype']}</td>";
										echo "<td>{$row['email']}</td>";
										echo "<td>{$row['bname']}</td>";

										// URL display
										if (!empty($row['burl'])) {
											echo "<td><a href='{$row['burl']}' target='_blank'>View</a></td>";
										} else {
											echo "<td>—</td>";
										}

										// Status Badges
										echo "<td>";
										if ($status == 'Pending') echo "<span class='badge badge-warning'>Pending</span>";
										elseif ($status == 'Approved') echo "<span class='badge badge-success'>Approved</span>";
										elseif ($status == 'Rejected') echo "<span class='badge badge-danger'>Rejected</span>";
										else echo "<span class='badge badge-secondary'>$status</span>";
										echo "</td>";

										// Show Time
										echo "<td>" . date("M d, Y h:i A", strtotime($row['req_date'])) . "</td>";

										// Action Buttons
										echo "<td>";
										if ($status == 'Pending') {
											echo "
												<button class='btn btn-success btn-sm' onclick=\"approveRequest({$row['id']}, '{$row['username']}', '{$row['bname']}')\">✔ Accept</button>
												<button class='btn btn-danger btn-sm' onclick=\"declineRequest({$row['id']})\">✖ Decline</button>
											";
										} else {
											echo "—";
										}
										echo "</td>";

										echo "</tr>";
									}
									?>
								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<?php include 'inc/footer.php'; ?>

<script>
$(document).ready(() => {
	$('#dtBasicExample').DataTable({
		"order": [[7, "desc"]] // 👉 Auto sort by date column
	});
});

// ACCEPT REQUEST
function approveRequest(id, username, bookname){
	if(confirm("Approve this request?")){
		$.post("request_action.php", {action:'approve', id:id, username:username, bookname:bookname}, function(response){
			alert(response);
			location.reload();
		});
	}
}

// DECLINE REQUEST
function declineRequest(id){
	if(confirm("Decline this request?")){
		$.post("request_action.php", {action:'decline', id:id}, function(response){
			alert(response);
			location.reload();
		});
	}
}
</script>
