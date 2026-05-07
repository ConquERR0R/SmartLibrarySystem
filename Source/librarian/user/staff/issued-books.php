<?php 
session_start();

// ================= ROLE VALIDATION =================
if (!isset($_SESSION["staff"])) {
    header("Location: ../../login.php");
    exit();
}

$page = 'ibook';

include 'inc/header.php';
include 'inc/connection.php';

$username = $_SESSION["staff"];

// ================ GET STUDENT ISSUED BOOKS ===================
$res = mysqli_query($link, 
    "SELECT * FROM issue_book 
     WHERE username='$username'
     ORDER BY id DESC"
);
?>

<div class="dashboard-content">
    <div class="dashboard-header">
        <div class="container">
            <div class="row">
                
                <div class="col-md-6">
                    <div class="left">
                        <p><span>dashboard</span> My Issued Books</p>
                    </div>
                </div>

                <div class="col-md-6 text-right">
                    <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
                    <span class="disabled">Issued Books</span>
                </div>

            </div>

            <div class="issued-content mt-3">
                <div class="row">
                    <div class="col-md-12">

                        <table id="issuedBooks" class="table table-dark table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Book Name</th>
                                    <th>Issue Date</th>
                                    <th>Return Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php 
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<tr>";

                                    echo "<td>{$row['booksname']}</td>";
                                    echo "<td>{$row['booksissuedate']}</td>";
                                    echo "<td>{$row['booksreturndate']}</td>";

                                    // STATUS BADGE
                                    $status = $row["status"];
                                    if ($status == "Borrowed") {
                                        echo "<td><span class='badge badge-warning'>Borrowed</span></td>";
                                    } elseif ($status == "Returned") {
                                        echo "<td><span class='badge badge-success'>Returned</span></td>";
                                    } else {
                                        echo "<td><span class='badge badge-info'>$status</span></td>";
                                    }

                                    // ACTION BUTTONS
                                    echo "<td>";

                                    if ($status == "Borrowed") {
                                        echo "<a href='return.php?id={$row['id']}' 
                                                  class='btn btn-sm btn-primary'>
                                                  <i class='fas fa-undo'></i> Return
                                                </a>";
                                    } else {
                                        echo "<span class='text-muted'>No Action</span>";
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

<?php include 'inc/footer.php'; ?>

<script>
$(document).ready(function() {
    $('#issuedBooks').DataTable();
});
</script>
