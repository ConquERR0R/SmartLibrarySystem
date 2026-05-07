<?php
session_start();

// === FIX: Correct role check (student must be logged in) ===
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
	header("Location: ../../login.php");
	exit();
}

// Ensure session index exists
if (!isset($_SESSION["student"])) {
	$_SESSION["student"] = $_SESSION["username"]; // fallback to logged username
}

// === FIX: Correct file paths ===
include '../../inc/connection.php';
include 'inc/header.php';
?>

<!--dashboard area-->
<div class="dashboard-content">
	<div class="dashboard-header">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="left">
						<p><span>dashboard</span> User Panel</p>
					</div>
				</div>
				<div class="col-md-6">
					<div class="right text-right">
						<a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
						<span class="disabled">Profile</span>
					</div>
				</div>
			</div>

			<div class="profile-content">
				<div class="row">

					<!-- LEFT: Profile Image -->
					<div class="col-md-3">
						<div class="photo">
							<?php
								$res = mysqli_query($link, "SELECT * FROM std_registration WHERE username='{$_SESSION['student']}'");
								$row = mysqli_fetch_assoc($res);

								$image = (!empty($row["photo"])) ? $row["photo"] : "uploads/default.png";
							?>
							<img src="<?php echo $image; ?>" height="150" width="150" style="border-radius:50%;">
						</div>

						<!-- Upload -->
						<div class="uploadPhoto">
							<form action="" method="post" enctype="multipart/form-data">
								<input type="file" name="image" class="modal-mt" id="image">
								<br>
								<input type="submit" class="btn btn-info btn-sm" value="Upload Image" name="submit">
							</form>
						</div>

						<?php 
						if (isset($_POST["submit"]) && isset($_FILES['image'])) {
							$newfilename = time() . "_" . $_FILES['image']['name'];
							$imagepath = "upload/" . $newfilename;

							if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagepath)) {
								mysqli_query($link, "UPDATE std_registration SET photo='{$imagepath}' WHERE username='{$_SESSION['student']}'");
							}
							echo "<script>window.location='profile.php';</script>";
						}
						?>
					</div>

					<!-- RIGHT: Details -->
					<div class="col-md-9">
						<div class="details">

							<?php
							$r = mysqli_query($link, "SELECT * FROM std_registration WHERE username='{$_SESSION['student']}'");
							$data = mysqli_fetch_assoc($r);
							?>

							<form method="post">
								<div class="form-group">
									<label>Reg No:</label>
									<input type="text" class="form-control" value="<?php echo $data['regno']; ?>" disabled>
								</div>

								<div class="form-group">
									<label>Username:</label>
									<input type="text" class="form-control" value="<?php echo $data['username']; ?>" disabled>
								</div>

								<div class="form-group">
									<label>Name:</label>
									<input type="text" class="form-control" name="name" value="<?php echo $data['name']; ?>">
								</div>

								<div class="form-group">
									<label>Semester:</label>
									<input type="text" class="form-control" name="sem" value="<?php echo $data['sem']; ?>">
								</div>

								<div class="form-group">
									<label>Session:</label>
									<input type="text" class="form-control" name="session" value="<?php echo $data['session']; ?>">
								</div>

								<div class="form-group">
									<label>Department:</label>
									<input type="text" class="form-control" name="dept" value="<?php echo $data['dept']; ?>">
								</div>

								<div class="form-group">
									<label>Email:</label>
									<input type="text" class="form-control" value="<?php echo $data['email']; ?>" disabled>
								</div>

								<div class="form-group">
									<label>Phone:</label>
									<input type="text" class="form-control" name="phone" value="<?php echo $data['phone']; ?>">
								</div>

								<div class="form-group">
									<label>Address:</label>
									<input type="text" class="form-control" name="address" value="<?php echo $data['address']; ?>">
								</div>

								<div class="form-group">
									<label>User Type:</label>
									<input type="text" class="form-control" value="<?php echo $data['utype']; ?>" disabled>
								</div>

								<div class="text-right mt-3">
									<input type="submit" class="btn btn-info" value="Save" name="update">
								</div>
							</form>

							<?php 
							if (isset($_POST["update"])) {
								mysqli_query($link, "UPDATE std_registration SET 
									name='{$_POST['name']}',
									phone='{$_POST['phone']}',
									address='{$_POST['address']}'
								WHERE username='{$_SESSION['student']}'");
								
								echo "<script>window.location='profile.php';</script>";
							}
							?>
						</div>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>

<?php include 'inc/footer.php'; ?>
