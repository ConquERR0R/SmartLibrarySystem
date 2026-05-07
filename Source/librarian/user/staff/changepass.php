<?php 
     session_start();
    if (!isset($_SESSION["student"])) {
        ?>
            <script type="text/javascript">
                window.location="login.php";
            </script>
        <?php
    }
    include 'inc/header.php';
    include 'inc/connection.php';
 ?>
	<!--dashboard area-->
	<div class="dashboard-content">
		<div class="dashboard-header">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="left">
							<p><span>dashboard</span>User panel</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="right text-right">
							<a href="dashboard.php"><i class="fas fa-home"></i>home</a>
							<span class="disabled">change password</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<form action="" class="pass-content" method="post">
						
							<b>Current Password:</b>
							<input type="password" class="form-control mt-10" name="cpassword" placeholder="Current password">
							<br>
							<b>New Password:</b>
							<input type="password" class="form-control mt-10" name="npassword" placeholder="New password">
							<br>
							<b>Conform Password:</b>
							<input type="password" class="form-control mt-10" name="conpass" placeholder="Conform password">
							<br>
							<input type="submit" name="submit" class="btn" value="Change Password">
						</form>
						  <?php
							if (isset($_POST["submit"])){
							
								$cpass   = $_POST['cpassword'];
$npass   = $_POST['npassword'];
$conpass = $_POST['conpass'];

$res = mysqli_query($link, "SELECT password FROM std_registration WHERE username='{$_SESSION['student']}'");

$pass = ""; // prevent undefined variable

if ($row = mysqli_fetch_assoc($res)) {
    $pass = $row['password'];
}

if ($pass === "") {
    echo "<div class='alert alert-danger'>User not found!</div>";
} 
elseif ($cpass != $pass) {
    echo "<div class='alert alert-warning'><strong>Invalid!</strong> Wrong current password.</div>";
} 
else {
    if ($npass == $conpass) {
        mysqli_query($link, "UPDATE std_registration SET password='$npass' WHERE username='{$_SESSION['student']}'");
        echo "<div class='alert alert-success'><strong>Success!</strong> Password changed.</div>";
    } else {
        echo "<div class='alert alert-warning'><strong>Error!</strong> New passwords do not match.</div>";
    }
}
	
							}
						?>
					</div>
				</div>
			</div>					
		</div>
	</div>
	<?php 
		include 'inc/footer.php';
	 ?>