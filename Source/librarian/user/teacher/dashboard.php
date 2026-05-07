<?php 
session_start();

// ================= ROLE VALIDATION =================
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] != 'teacher') {
    header("Location: ../../login.php");
    exit();
}

// FIX: Ensure teacher session index exists
if (!isset($_SESSION['teacher'])) {
    $_SESSION['teacher'] = $_SESSION['username']; 
}

$page = 'home';

include 'inc/connection.php'; 
include 'inc/header.php';

$username = $_SESSION['username']; 
?>

<!-- dashboard area -->
<div class="dashboard-content">
    <div class="dashboard-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="left">
                        <p><span>dashboard</span> teacher Panel</p>
                    </div>
                </div>
                <div class="col-md-6 text-right">
                    <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
                    <span class="disabled">Dashboard</span>
                </div>
            </div>
        </div>  
    </div>

    <div class="container">

        <!-- ========================================================= -->
        <!--       RECENTLY ACCESSED BOOKS (WORKING & CLEAN)         -->
        <!-- ========================================================= -->
        <h4 class="mt-4">📌 Recently Accessed Books</h4>
        <div class="row">

        <?php 
        $recent = mysqli_query($link,"
            SELECT issue_book.*, add_book.books_image, add_book.books_file 
            FROM issue_book 
            INNER JOIN add_book 
                ON issue_book.booksname = add_book.books_name
            WHERE username='$username' 
            AND issue_book.status='Borrowed'
            ORDER BY issue_book.id DESC
            LIMIT 3
        ");

        if(mysqli_num_rows($recent) == 0){
            echo "<p class='ml-3' style='color:#aaa;'>No recent activity yet.</p>";
        }

        while($rec = mysqli_fetch_assoc($recent)) { ?>
            <div class="col-md-3" style="margin:10px;">
                <div style="background:#111;border-radius:8px;padding:10px;text-align:center;
                            box-shadow:0 0 8px rgba(255,255,255,0.09);">

                    <img src="../../<?= $rec['books_image']; ?>" 
                         style="width:100%;height:200px;object-fit:cover;border-radius:6px;">

                    <h6 style="margin-top:10px;"><?= $rec['booksname']; ?></h6>

                    <button onclick="window.open('../../<?= $rec['books_file']; ?>','_blank')" 
                            class="btn btn-primary btn-sm mt-2">
                        📖 Continue Reading
                    </button>
                </div>
            </div>
        <?php } ?>
        </div>




        <!-- ========================================================= -->
        <!--           BOOKS FOR RESERVATION SECTION                 -->
        <!-- ========================================================= -->
        <h4 class="mt-5">📘 Books For Reservation</h4>
        <div class="row">

        <?php
        $reservations = mysqli_query($link,"
            SELECT reservations.*, add_book.books_image 
            FROM reservations 
            INNER JOIN add_book ON reservations.book_id = add_book.id
            WHERE reservations.username='$username'
            ORDER BY reservations.id DESC
            LIMIT 3
        ");

        if (mysqli_num_rows($reservations) == 0) {
            echo "<p class='ml-3' style='color:#aaa;'>No books reserved.</p>";
        }

        while($r = mysqli_fetch_assoc($reservations)) { ?>
            <div class="col-md-3" style="margin:10px;">
                <div style="background:#222;border-radius:10px;padding:15px;text-align:center;
                            box-shadow:0 0 10px rgba(255,255,255,0.08);color:white;">

                    <img src="../../<?= $r['books_image']; ?>" 
                         style="width:100%;height:200px;object-fit:cover;border-radius:6px;">

                    <h5 class="mt-2"><?= $r['book_name']; ?></h5>

                    <span class="badge bg-warning text-dark" 
                          style="padding:6px 12px;border-radius:20px;font-size:14px;">
                        FOR RESERVATION
                    </span>

                    <p class="mt-2" style="font-size:13px;color:#bbb;">
                        Requested: <?= $r['reserved_at']; ?>
                    </p>
                </div>
            </div>
        <?php } ?>

        </div>




        <!-- ========================================================= -->
        <!--               BORROWED BOOKS TABLE                      -->
        <!-- ========================================================= -->
        <div class="mt-5">
            <h4 class="text-center mb-3">Borrowed Books</h4>

            <table id="dtBasicExample" class="table table-dark table-striped text-center">
                <thead>
                    <tr>
                        <th>Reg No</th>
                        <th>Username</th>
                        <th>Book Name</th>
                        <th>Issued</th>
                        <th>Return Date</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                <?php 
                $borrowed = mysqli_query($link,"
                    SELECT * FROM t_issuebook 
                    WHERE username='$username'
                    ORDER BY id DESC
                ");

                if(mysqli_num_rows($borrowed) == 0){
                    echo "<tr><td colspan='6'>No Borrowed Books Found</td></tr>";
                }

                while ($row = mysqli_fetch_assoc($borrowed)) {

                    $returnDate = strtotime($row['booksreturndate']);
                    $today      = strtotime(date("Y-m-d"));

                    $statusTxt = ($today > $returnDate)
                        ? "<span style='color:#ff4444;font-weight:bold;'>Overdue</span>"
                        : "<span style='color:#4cd137;font-weight:bold;'>On Time</span>";

                    echo "<tr>";
                    echo "<td>{$row['idno']}</td>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['booksname']}</td>";
                    echo "<td>{$row['booksissuedate']}</td>";
                    echo "<td>{$row['booksreturndate']}</td>";
                    echo "<td>$statusTxt</td>";
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
