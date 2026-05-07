<?php 
session_start();

if (!isset($_SESSION["student"])) {
	echo "<script>window.location='login.php';</script>";
	exit();
}

$page = 'history';
include 'inc/header.php';
include 'inc/connection.php';

$username = $_SESSION['student'];

?>

<style>
.table-history {
	margin-top: 25px;
	background: #131722;
	color: white;
	border-radius: 10px;
	overflow: hidden;
}
.table-history th, .table-history td {
	padding: 12px;
	text-align: center;
}
.status-badge {
	padding: 6px 12px;
	border-radius: 6px;
	font-weight: bold;
	color: white;
}
.status-borrowed { background: #3498db; }
.status-returned { background: #2ecc71; }
.status-lost { background: #e74c3c; }
.status-damaged { background: #f39c12; }
</style>

<div class="dashboard-content">
	<div class="dashboard-header">
		<div class="container">

			<div class="row">
				<div class="col-md-6">
					<div class="left">
						<p><span>dashboard</span> Borrow History</p>
					</div>
				</div>
				<div class="col-md-6 text-right">
					<a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
					<span class="disabled">History</span>
				</div>
			</div>

			<table id="historyTable" class="table table-dark table-striped table-history">
				<thead>
					<tr>
						<th>Book Title</th>
						<th>Issued</th>
						<th>Due</th>
						<th>Returned</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>

				<?php 
				$res = mysqli_query($link,"
					SELECT booksname, booksissuedate, booksreturndate, actual_return_date, status
					FROM issue_book 
					WHERE username='$username'
					ORDER BY id DESC
				");

				if(mysqli_num_rows($res) == 0){
					echo "<tr><td colspan='5'><strong style='color:#aaa;'>📭 No history available yet.</strong></td></tr>";
				}

				while($row=mysqli_fetch_assoc($res)){
					$status = $row['status'];
					
					$badgeClass = match($status) {
						"Borrowed" => "status-borrowed",
						"Returned" => "status-returned",
						"Lost" => "status-lost",
						"Damaged" => "status-damaged",
						default => "status-borrowed"
					};

					echo "
						<tr>
							<td>{$row['booksname']}</td>
							<td>{$row['booksissuedate']}</td>
							<td>{$row['booksreturndate']}</td>
							<td>".($row['actual_return_date'] ? $row['actual_return_date'] : "-")."</td>
							<td><span class='status-badge {$badgeClass}'>$status</span></td>
						</tr>
					";
				}
				?>

				</tbody>
			</table>

		</div>
	</div>
</div>

<script>
$(document).ready(function () {
	$('#historyTable').DataTable();
});
</script>

<?php include 'inc/footer.php'; ?>
