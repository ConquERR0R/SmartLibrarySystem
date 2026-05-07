<?php
session_start();
include "inc/connection.php";

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "staff") {
    header("Location: ../../login.php");
    exit;
}

// CHECK IF ID IS PROVIDED
if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location='all-teacher-info.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// GET CURRENT TEACHER DATA
$res = mysqli_query($link, "SELECT * FROM t_registration WHERE id='$id'");
$teacher = mysqli_fetch_assoc($res);

if (!$teacher) {
    echo "<script>alert('Teacher not found!'); window.location='all-teacher-info.php';</script>";
    exit;
}

// ==================== UPDATE DATA ====================
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $idno = $_POST['idno'];
    $username = $_POST['username'];
    $lecturer = $_POST['lecturer'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    mysqli_query($link, "
        UPDATE t_registration SET
            idno='$idno',
            name='$name',
            username='$username',
            lecturer='$lecturer',
            email='$email',
            phone='$phone',
            address='$address'
        WHERE id='$id'
    ");

    echo "<script>alert('Teacher updated successfully!'); window.location='all-teacher-info.php';</script>";
    exit;
}

include "inc/header.php";
?>

<style>
.staff-content {
    margin-left: 250px !important;
    padding: 20px;
}
</style>

<div class="staff-content">
    <div class="container">

        <h3 class="mb-4"><i class="fas fa-edit"></i> Edit Teacher</h3>

        <div class="card shadow-sm">
            <div class="card-body">

                <form method="POST">

                    <div class="row">

                        <div class="col-md-4">
                            <label>ID No</label>
                            <input type="text" name="idno" class="form-control" value="<?= $teacher['idno']; ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?= $teacher['name']; ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?= $teacher['username']; ?>" required>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Lecturer</label>
                            <input type="text" name="lecturer" class="form-control" value="<?= $teacher['lecturer']; ?>" required>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $teacher['email']; ?>" required>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= $teacher['phone']; ?>" required>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="<?= $teacher['address']; ?>" required>
                        </div>

                    </div>

                    <button type="submit" name="update" class="btn btn-primary mt-4">
                        <i class="fas fa-save"></i> Update Teacher
                    </button>

                    <a href="all-teacher-info.php" class="btn btn-secondary mt-4">Cancel</a>

                </form>

            </div>
        </div>

    </div>
</div>

<?php include "inc/footer.php"; ?>
