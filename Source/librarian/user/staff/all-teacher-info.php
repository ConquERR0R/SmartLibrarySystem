<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] !== "staff") {
    header("Location: ../../login.php");
    exit;
}

$page = "teachers";

include "inc/header.php";
include "inc/connection.php";
?>

<style>
.staff-content {
    margin-left: 130px !important; /* Align with sidebar */
    padding: 20px;
    background: #f5f7fb;
}
</style>

<div class="staff-content">

    <div class="container-fluid">
        <h3 class="mb-4"><i class="fas fa-chalkboard-teacher"></i> Teacher Information</h3>
        <div class="card shadow-sm">
            <div class="card-body">

                <table id="teachersTable" class="table table-striped table-bordered text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>ID No</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Lecturer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th width="160px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $res = mysqli_query($link, "SELECT * FROM t_registration");

                    while ($row = mysqli_fetch_assoc($res)) {
                        echo "<tr>";
                        echo "<td>{$row['idno']}</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['username']}</td>";
                        echo "<td>{$row['lecturer']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['phone']}</td>";
                        echo "<td>{$row['address']}</td>";

                        echo "<td>
                                <a href='edit_teacher.php?id={$row['id']}' class='btn btn-primary btn-sm'>
                                    <i class='fas fa-edit'></i> Edit
                                </a>
                                <a href='delete_teacher.php?id={$row['id']}'
                                   onclick=\"return confirm('Delete this teacher?');\"
                                   class='btn btn-danger btn-sm'>
                                   <i class='fas fa-trash'></i> Delete
                                </a>
                              </td>";

                        echo "</tr>";
                    }
                    ?>
                    </tbody>

                </table>

            </div>
        </div>

    </div>

</div>

<?php include "inc/footer.php"; ?>

<script>
$(document).ready(function () {
    $('#teachersTable').DataTable();
});
</script>
