<?php 
session_start();

// Role Protection
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'librarian') {
	header("Location: ../../login.php");
	exit();
}

$page = 'displaybooks';

include 'inc/header.php';
include 'inc/connection.php';
?>
	
<div class="dashboard-content">
	<div class="dashboard-header">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="left">
						<p><span>Dashboard</span> Control Panel</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="right text-right">
						<a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
						<span class="disabled">Display Books</span>
					</div>
				</div>
			</div>				
		</div>	

		<div class="container mt-3">
			<table id="dtBasicExample" class="table table-striped table-dark text-center">
				<thead>
					<tr>
						<th>Cover</th>
						<th>Book Name</th>
						<th>Author</th>
						<th>Publication</th>
						<th>Purchase Date</th>
						<th>Price</th>
						<th>Qty</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
				<?php
				$res = mysqli_query($link, "SELECT * FROM add_book");

				if(mysqli_num_rows($res) == 0){
					echo "<tr><td colspan='9'>📭 No books found in the system.</td></tr>";
				}

				while ($row = mysqli_fetch_assoc($res)) {

					// Get full correct path of image
					$imagePath = "/webdev2/SmartLibrarySystem/Source/librarian/" . $row["books_image"];

					// Handle missing status
					$status = isset($row["status"]) ? $row["status"] : "available";

					echo "<tr>";

					// FIXED IMAGE DISPLAY
					echo "<td>
						<img src='$imagePath' height='100' width='100' 
							style='object-fit:cover;border-radius:5px;'>
						</td>";

					echo "<td>{$row["books_name"]}</td>";
					echo "<td>{$row["books_author_name"]}</td>";
					echo "<td>{$row["books_publication_name"]}</td>";
					echo "<td>{$row["books_purchase_date"]}</td>";
					echo "<td>{$row["books_price"]}</td>";
					echo "<td>{$row["books_quantity"]}</td>";

					echo "<td>";
						if($status == "archived"){
							echo "<span class='badge badge-warning'>Archived</span>";
						} else {
							echo "<span class='badge badge-success'>Available</span>";
						}
					echo "</td>";

					echo "<td>";
					if ($status == "archived") {
						echo "<a href='restore-book.php?id={$row['id']}' class='btn btn-success btn-sm'>Restore</a> ";
						echo "<a href='delete-book.php?id={$row['id']}' onclick=\"return confirm('Delete permanently?');\" class='btn btn-danger btn-sm'>Delete</a>";
					} else {
						echo "<a href='archive-book.php?id={$row['id']}' class='btn btn-warning btn-sm'>Archive</a>";
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

<?php include 'inc/footer.php'; ?>

<script>
$(document).ready(function () {
	$('#dtBasicExample').DataTable();
});
</script>
