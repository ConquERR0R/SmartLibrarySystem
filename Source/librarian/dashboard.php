<?php 
session_start();

// ========== ROLE VALIDATION ==========
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'librarian') {
	header("Location: /webdev2/SmartLibrarySystem/login.php");
	exit();
}

$page = 'home';

include 'inc/header.php';
include 'inc/connection.php';

// ===================== NOTIFICATION COUNTS =====================
$pendingStudents  = mysqli_num_rows(mysqli_query($link, "SELECT id FROM std_registration WHERE status='pending'"));
$pendingTeachers  = mysqli_num_rows(mysqli_query($link, "SELECT id FROM t_registration WHERE status='pending'"));
$pendingStaff     = mysqli_num_rows(mysqli_query($link, "SELECT id FROM staff_registration WHERE status='pending'"));
$bookRequests     = mysqli_num_rows(mysqli_query($link, "SELECT id FROM request_books WHERE read1='no'"));

$totalNotifications = $pendingStudents + $pendingTeachers + $pendingStaff + $bookRequests;
?>
	
<!--dashboard area-->
<div class="dashboard-content">
	<div class="dashboard-header">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="left">
						<p><span>dashboard</span> Control Panel</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="right text-right">
						<a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
						<span class="disabled">Dashboard</span>

						<!-- 🔔 NOTIFICATION BADGE -->
						<!-- <?php if ($totalNotifications > 0): ?>
							<a href="requested-books.php" class="ml-3" style="color:#ff4444;font-weight:bold;">
								<i class="fas fa-bell"></i> Notifications 
								<span style="background:red;color:white;padding:3px 7px;border-radius:10px;font-size:13px;">
									<?= $totalNotifications ?>
								</span>
							</a>
						<?php endif; ?> -->

					</div>
				</div>
			</div>

			<!-- STAT CARDS -->
			<div class="row counterup">


				<?php
				$countStudents = mysqli_num_rows(mysqli_query($link, "SELECT id FROM std_registration WHERE status='yes' OR status='approved'"));
				$countTeachers = mysqli_num_rows(mysqli_query($link, "SELECT id FROM t_registration WHERE status='yes' OR status='approved'"));
				echo $countStudents + $countTeachers;
				?>


				<!-- Issued Books -->
				<div class="col-md-3 col-sm-3 col-xs-12 control">
					<div class="box box2">
						<div class="icon"><i class="fa fa-rocket"></i></div>
						<div class="text">
							<h3><span class="counter">
								<?php
								$sBooks = mysqli_num_rows(mysqli_query($link, "SELECT * FROM issue_book"));
								$tBooks = mysqli_num_rows(mysqli_query($link, "SELECT * FROM t_issuebook"));
								echo $sBooks + $tBooks;
								?>
							</span></h3>
							<h4><a href="issued-books.php">Issued Books</a></h4>
						</div>
					</div>
				</div>

				<!-- Total Books -->
				<div class="col-md-3 col-sm-3 col-xs-12 control">
					<div class="box box3">
						<div class="icon"><i class="fa fa-book"></i></div>
						<div class="text">
							<h3>
								<span class="counter">
									<?= mysqli_num_rows(mysqli_query($link, "SELECT id FROM add_book")); ?>
								</span>
							</h3>
							<h4><a href="display-books.php">Books</a></h4>
						</div>
					</div>
				</div>

				<!-- Fines -->
				<div class="col-md-3 col-sm-3 col-xs-12 control">
					<div class="box box4">
						<div class="icon"><i class="fas fa-dollar-sign"></i></div>
						<div class="text">
							<h3>
								<span class="counter">
									<?php
									$findata = mysqli_query($link, "SELECT fine FROM finezone");
									$totalFine = 0;
									while ($f = mysqli_fetch_assoc($findata)) {
										$totalFine += (float)$f['fine'];
									}
									echo $totalFine;
									?>
								</span>
							</h3>
							<h4><a href="fine.php">Fines</a></h4>
						</div>
					</div>
				</div>

				<!-- Manage Books -->
				<!-- <div class="col-md-3 col-sm-3 col-xs-12 control">
					<div class="box box3">
						<div class="icon"><i class="fas fa-book"></i></div>
						<div class="text"><h4><a href="display-books.php">Manage Books</a></h4></div>
					</div>
				</div> -->

				<!-- Manage Users -->
				<!-- <div class="col-md-3 col-sm-3 col-xs-12 control">
					<div class="box box4">
						<div class="icon"><i class="fas fa-user"></i></div>
						<div class="text"><h4><a href="manage_user.php">Manage Users</a></h4></div>
					</div>
				</div> -->

				<!-- Status -->
				<div class="col-md-3 col-sm-3 col-xs-12 control">
					<div class="box">
						<div class="icon"><i class="fab fa-staylinked"></i></div>
						<div class="text"><h4><a href="status.php">Status</a></h4></div>
					</div>
				</div>

				<!-- Requests -->
				<!-- <div class="col-md-3 col-sm-3 col-xs-12 control">
					<div class="box box2">
						<div class="icon"><i class="fas fa-book"></i></div>
						<div class="text"><h4><a href="requested-books.php">Requests</a></h4></div>
					</div>
				</div> -->

			</div> <!-- END ROW -->

		</div>
	</div>
</div>

<?php include 'inc/footer.php'; ?>
