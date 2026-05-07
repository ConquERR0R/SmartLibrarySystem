<?php
session_start();
include "inc/connection.php";

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "staff") {
    header("Location: ../../login.php");
    exit;
}

// CHECK IF ID EXIST
if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid request!'); window.location='all-student-info.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// GET CURRENT STUDENT INFO
$res = mysqli_query($link, "SELECT * FROM std_registration WHERE id='$id'");
$student = mysqli_fetch_assoc($res);

if (!$student) {
    echo "<script>alert('Student not found!'); window.location='all-student-info.php';</script>";
    exit;
}

// HANDLE FORM SUBMIT
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $regno = $_POST['regno'];
    $username = $_POST['username'];
    $sem = $_POST['sem'];
    $dept = $_POST['dept'];
    $session = $_POST['session'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    mysqli_query($link, "
        UPDATE std_registration 
        SET 
            name='$name',
            regno='$regno',
            username='$username',
            sem='$sem',
            dept='$dept',
            session='$session',
            email='$email',
            phone='$phone',
            address='$address'
        WHERE id='$id'
    ");

    echo "<script>alert('Student updated successfully!'); window.location='all-student-info.php';</script>";
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

        <h3 class="mb-4"><i class="fas fa-edit"></i> Edit Student</h3>

        <div class="card shadow-sm">
            <div class="card-body">

                <form method="POST">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Reg No</label>
                            <input type="text" name="regno" class="form-control" value="<?= $student['regno']; ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?= $student['name']; ?>" required>
                        </div>

                        <div class="col-md-4">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?= $student['username']; ?>" required>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Semester</label>
                            <input type="text" name="sem" class="form-control" value="<?= $student['sem']; ?>" required>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Department</label>
                            <input type="text" name="dept" class="form-control" value="<?= $student['dept']; ?>" required>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Session</label>
                            <input type="text" name="session" class="form-control" value="<?= $student['session']; ?>" required>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="<?= $student['email']; ?>" required>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= $student['phone']; ?>" required>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control" value="<?= $student['address']; ?>" required>
                        </div>

                    </div>

                    <button type="submit" name="update" class="btn btn-primary mt-4">
                        <i class="fas fa-save"></i> Update Student
                    </button>

                    <a href="all-student-info.php" class="btn btn-secondary mt-4">Cancel</a>

                </form>

            </div>
        </div>

    </div>
</div>

<?php include "inc/footer.php"; ?>
