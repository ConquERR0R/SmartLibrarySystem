<?php 
session_start();

// BASIC STUDENT VALIDATION
if (!isset($_SESSION["username"]) || $_SESSION["role"] !== 'student') {
    header("Location: ../../login.php");
    exit();
}

if (!isset($_SESSION["student"])) {
    $_SESSION["student"] = $_SESSION["username"];
}

$page = 'books';

include 'inc/header.php';
include '../../inc/connection.php';

$username = $_SESSION['student'];
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
                        <a href="dashboard.php"><i class="fas fa-home"></i> home</a>
                        <span class="disabled">books</span>
                    </div>
                </div>
            </div>

            <!-- Search + Return button row -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <form action="" method="post">
                        <table class="table">
                            <tr>
                                <td>
                                    <input type="text" name="search" class="form-control" placeholder="Enter book name">
                                </td>
                                <td>
                                    <input type="submit" name="submit1" class="btn btn-info" value="Search Book">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="col-md-4 text-right">
                    <!-- Button to trigger Return Modal -->
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#returnModal">
                        📦 Return Books
                    </button>
                </div>
            </div>

            <div class="books">
                <?php
                // DISPLAY BOOKS
                if (isset($_POST["submit1"]) && !empty($_POST['search'])) {
                    $search = mysqli_real_escape_string($link, $_POST['search']);
                    $res = mysqli_query($link, "SELECT * FROM add_book WHERE books_name LIKE '$search%'");
                    echo "<table class='table control-books'>";
                    echo "<tr>";
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $i++;
                        echo "<td class='text-center'>";
                        echo '<a href="../../'.$row["books_file"].'" target="_blank">
                                <img src="../../'.$row["books_image"].'" alt="" height="200">
                              </a>';
                        echo "<br><br>";
                        echo "<b>".$row["books_name"]."</b><br>";
                        echo "<b>Available: ".$row["books_availability"]."</b><br>";
                        echo "</td>";

                        if ($i == 4) {
                            echo "</tr><tr>";
                            $i = 0;
                        }
                    }
                    echo "</tr></table>";
                } else {
                    $res = mysqli_query($link, "SELECT * FROM add_book WHERE books_availability > 0");
                    echo "<table id='dtBasicExample' class='table control-books'>";
                    echo "<tr>";
                    $i = 0;
                    while ($row = mysqli_fetch_assoc($res)) {
                        $i++;
                        echo "<td class='text-center'>";
                        echo '<a href="../../'.$row["books_file"].'" target="_blank">
                                <img src="../../'.$row["books_image"].'" alt="" height="200">
                              </a>';
                        echo "<br><br>";
                        echo "<b>".$row["books_name"]."</b><br>";
                        echo "<b>Available: ".$row["books_availability"]."</b><br>";
                        echo "</td>";

                        if ($i == 4) {
                            echo "</tr><tr>";
                            $i = 0;
                        }
                    }
                    echo "</tr></table>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- ================= RETURN CONFIRMATION MODAL ================= -->

<?php
// Get currently borrowed books for this student
$borrowed = mysqli_query($link, "
    SELECT id, booksname, booksreturndate 
    FROM issue_book 
    WHERE username='$username' 
      AND status='Borrowed'
    ORDER BY booksreturndate ASC
");
?>

<div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      
      <form id="returnForm">
        <div class="modal-header">
          <h5 class="modal-title" id="returnModalLabel">📦 Return Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <?php if (mysqli_num_rows($borrowed) == 0): ?>
                <p>You currently have no borrowed books.</p>
            <?php else: ?>
                <p><strong>Books currently borrowed:</strong></p>
                <ul class="list-group mb-3">
                <?php 
                $today = strtotime(date("Y-m-d"));
                while ($row = mysqli_fetch_assoc($borrowed)):
                    $due = strtotime($row['booksreturndate']);
                    $isOverdue = $today > $due;
                ?>
                    <li class="list-group-item">
                        <label style="width:100%; cursor:pointer;">
                            <input type="radio" name="issue_id" value="<?php echo $row['id']; ?>" required>
                            <?php echo htmlspecialchars($row['booksname']); ?> 
                            | Due: <?php echo date("M d, Y", $due); ?>
                            <?php if ($isOverdue): ?>
                                <span style="color:#ff4444; font-weight:bold;"> ❌ Overdue (Penalty running)</span>
                            <?php else: ?>
                                <span style="color:#28a745; font-weight:bold;"> ✔ On Time</span>
                            <?php endif; ?>
                        </label>
                    </li>
                <?php endwhile; ?>
                </ul>

                <p><strong>Reason (optional):</strong></p>
                <div class="form-group">
                    <label class="mr-3">
                        <input type="radio" name="reason" value="Normal" checked> Normal Return
                    </label>
                    <label class="mr-3">
                        <input type="radio" name="reason" value="Damaged"> Damaged
                    </label>
                    <label class="mr-3">
                        <input type="radio" name="reason" value="Lost"> Lost
                    </label>
                </div>

                <div id="returnAlert" style="display:none;"></div>

            <?php endif; ?>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <?php if (mysqli_num_rows($borrowed) > 0): ?>
          <button type="submit" class="btn btn-primary">Confirm Return</button>
          <?php endif; ?>
        </div>
      </form>

    </div>
  </div>
</div>

<?php include 'inc/footer.php'; ?>

<!-- DataTables + Return AJAX -->
<script>
$(document).ready(function () {
    $('#dtBasicExample').DataTable();
    $('.dataTables_length').addClass('bs-select');

    // Handle return form submit via AJAX
    $('#returnForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: 'return_handler.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                $('#returnAlert')
                    .removeClass()
                    .show()
                    .addClass('alert ' + (res.success ? 'alert-success' : 'alert-danger'))
                    .html(res.message);

                if (res.success) {
                    // refresh after short delay to update tables
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            },
            error: function() {
                $('#returnAlert')
                    .removeClass()
                    .show()
                    .addClass('alert alert-danger')
                    .html('Something went wrong while processing return. Please try again.');
            }
        });
    });
});
</script>
