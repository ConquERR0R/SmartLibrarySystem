<?php
session_start();

// === STAFF ACCESS CHECK ===
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../login.php");
    exit();
}

$staff_username = $_SESSION['username']; // correct session index

include '../../inc/connection.php';
include 'inc/header.php';

// ================= GET STAFF DATA ======================
$q = mysqli_query($link, "SELECT * FROM staff_registration WHERE username='$staff_username' LIMIT 1");
$staff = mysqli_fetch_assoc($q);

if (!$staff) {
    die("<h3 style='color:red;'>Staff record not found!</h3>");
}

$photo = !empty($staff['photo']) ? "../../" . $staff['photo'] : "../../books-image/avatar.png";
?>

<div class="staff-content" style="margin-left:130px; padding:20px;">

    <h3><i class="fas fa-user-circle"></i> Staff Profile</h3>
    <hr>

    <div class="row">

        <!-- LEFT SIDE: PROFILE PICTURE -->
        <div class="col-md-3 text-center">

            <img src="<?php echo $photo; ?>" 
                 style="width:150px; height:150px; border-radius:50%; object-fit:cover;">

            <form action="" method="post" enctype="multipart/form-data" class="mt-3">
                <input type="file" name="imgUpload" class="form-control mb-2">
                <button class="btn btn-primary btn-sm" name="upload">Upload Photo</button>
            </form>

            <?php
            // === UPLOAD HANDLER ===
            if (isset($_POST['upload']) && isset($_FILES['imgUpload'])) {

                $newName = time() . "_" . $_FILES['imgUpload']['name'];
                $path = "upload/" . $newName;

                if (move_uploaded_file($_FILES['imgUpload']['tmp_name'], $path)) {
                    mysqli_query($link, "
                        UPDATE staff_registration 
                        SET photo='$path' 
                        WHERE username='$staff_username'
                    ");
                }

                echo "<script>window.location='profile.php';</script>";
            }
            ?>

        </div>

        <!-- RIGHT SIDE: DETAILS -->
        <div class="col-md-9">

            <form method="post" class="card p-3 shadow-sm">

                <div class="form-group">
                    <label>Staff ID</label>
                    <input type="text" class="form-control" value="<?php echo $staff['id']; ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" value="<?php echo $staff['username']; ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $staff['name']; ?>">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" value="<?php echo $staff['email']; ?>" disabled>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $staff['phone']; ?>">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $staff['address']; ?>">
                </div>

                <div class="form-group">
                    <label>User Type</label>
                    <input type="text" class="form-control" value="Staff" disabled>
                </div>

                <button class="btn btn-info" name="save">Save Changes</button>

            </form>

            <?php
            // === SAVE UPDATES ===
            if (isset($_POST['save'])) {

                $name = $_POST['name'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];

                mysqli_query($link, "
                    UPDATE staff_registration SET 
                        name='$name',
                        phone='$phone',
                        address='$address'
                    WHERE username='$staff_username'
                ");

                echo "<script>window.location='profile.php';</script>";
            }
            ?>

        </div>

    </div>
</div>

<?php include 'inc/footer.php'; ?>
