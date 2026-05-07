<?php
// borrower_status.php
$page = 'borrower_status';
include 'inc/header.php'; // header includes connection & session check

// handle quick reminder send (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_reminder'])) {
    $target_user = mysqli_real_escape_string($link, $_POST['target_user']);
    $msg = mysqli_real_escape_string($link, $_POST['reminder_message']);
    if ($target_user && $msg) {
        mysqli_query($link, "INSERT INTO notifications (username, message, type, is_read) VALUES ('$target_user', '$msg', 'reminder', 'no')");
        $notice = "Reminder sent to {$target_user}.";
    } else {
        $notice = "Failed to send reminder.";
    }
}

// filters
$filter_type = $_GET['type'] ?? 'all'; // 'student' | 'teacher' | 'all'
$search = trim($_GET['search'] ?? '');

// Build queries: we will union student and teacher issued books
$where_student = "issue_book.status IN ('Borrowed','Pending Return','Borrowed')";
$where_teacher = "t_issuebook.status IN ('Borrowed')";

// search clause
$search_sql = "";
if ($search !== "") {
    $s = mysqli_real_escape_string($link, $search);
    $search_sql = " AND (add_book.books_name LIKE '%$s%' OR issue_book.username LIKE '%$s%' OR t_issuebook.username LIKE '%$s%')";
}

// type filter
$type_clause_student = ($filter_type == 'teacher') ? " AND 1=0 " : ""; // hide students if only teacher
$type_clause_teacher = ($filter_type == 'student') ? " AND 1=0 " : ""; // hide teachers if only student

// Student borrow records
$student_q = "
SELECT 
  issue_book.id, issue_book.username, issue_book.booksname, issue_book.booksissuedate, issue_book.booksreturndate, issue_book.status,
  add_book.books_image, add_book.books_file, 'student' AS utype
FROM issue_book
LEFT JOIN add_book ON issue_book.booksname = add_book.books_name
WHERE $where_student $type_clause_student
";

// Teacher borrow records
$teacher_q = "
SELECT 
  t_issuebook.id, t_issuebook.username, t_issuebook.booksname, t_issuebook.booksissuedate, t_issuebook.booksreturndate, t_issuebook.status,
  add_book.books_image, add_book.books_file, 'teacher' AS utype
FROM t_issuebook
LEFT JOIN add_book ON t_issuebook.booksname = add_book.books_name
WHERE $where_teacher $type_clause_teacher
";

// combine with union and apply search if any
$union_q = "($student_q) UNION ALL ($teacher_q) ORDER BY booksissuedate DESC, id DESC";
$result = mysqli_query($link, $union_q);
?>
<div class="container">
    <h3>📋 Borrower Status</h3>

    <?php if(!empty($notice)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($notice) ?></div>
    <?php endif; ?>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <select name="type" class="form-select">
                <option value="all" <?= $filter_type=='all'?'selected':''; ?>>All</option>
                <option value="student" <?= $filter_type=='student'?'selected':''; ?>>Students</option>
                <option value="teacher" <?= $filter_type=='teacher'?'selected':''; ?>>Teachers</option>
            </select>
        </div>
        <div class="col">
            <input type="text" name="search" placeholder="Search username or book title" class="form-control" value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Filter</button>
            <a href="borrower_status.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>User</th>
                <th>User Type</th>
                <th>Book</th>
                <th>Issued</th>
                <th>Due</th>
                <th>Status</th>
                <th>Overdue</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($result) == 0) {
            echo "<tr><td colspan='9' class='text-center'>No active borrowed records found.</td></tr>";
        } else {
            $i=1;
            while($row = mysqli_fetch_assoc($result)) {
                // normalize dates
                $issued = $row['booksissuedate'];
                $due = $row['booksreturndate'];
                $status = $row['status'];
                $utype = $row['utype'];
                $username = $row['username'];
                $book = $row['booksname'];

                // calculate overdue
                $overdue_days = 0;
                $overdue_text = '-';
                if (!empty($due) && $due != '0000-00-00' && strtotime($due)) {
                    $today = strtotime(date('Y-m-d'));
                    $due_ts = strtotime($due);
                    if ($today > $due_ts) {
                        $overdue_days = floor(($today - $due_ts) / (60*60*24));
                        $overdue_text = $overdue_days . " day(s)";
                    }
                }

                $row_class = ($overdue_days>0) ? 'table-overdue' : '';
                echo "<tr class='{$row_class}'>";
                echo "<td>" . $i++ . "</td>";
                echo "<td>" . htmlspecialchars($username) . "</td>";
                echo "<td>" . htmlspecialchars(ucfirst($utype)) . "</td>";
                echo "<td>" . htmlspecialchars($book) . "</td>";
                echo "<td>" . htmlspecialchars($issued) . "</td>";
                echo "<td>" . htmlspecialchars($due) . "</td>";
                echo "<td>" . htmlspecialchars($status) . "</td>";
                echo "<td>" . ($overdue_text) . "</td>";
                echo "<td>
                    <button class='btn btn-sm btn-info' data-user='".htmlspecialchars($username)."' data-book='".htmlspecialchars($book)."' onclick='openHistory(this)'>View History</button>
                    <button class='btn btn-sm btn-warning' onclick='openReminderModal(\"".htmlspecialchars($username)."\",\"Please return the book: ".htmlspecialchars($book)."\")'>Send Reminder</button>
                </td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>
    </div>
</div>

<!-- History Modal (simple) -->
<div id="historyModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Borrower History</h5>
        <button type="button" class="btn-close" onclick="closeHistory()" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="historyContent">
        Loading...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeHistory()">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Reminder Modal -->
<div id="reminderModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Send Reminder</h5>
        <button type="button" class="btn-close" onclick="closeReminder()" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="target_user" id="rem_target">
        <div class="mb-2">
            <label>Message</label>
            <textarea name="reminder_message" id="rem_msg" class="form-control" rows="4"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="send_reminder" class="btn btn-primary">Send</button>
        <button type="button" class="btn btn-secondary" onclick="closeReminder()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
// open history via AJAX call to load last 10 actions for the user
function openHistory(btn){
    var user = btn.getAttribute('data-user');
    var book = btn.getAttribute('data-book');
    var modal = document.getElementById('historyModal');
    var content = document.getElementById('historyContent');
    content.innerHTML = 'Loading history for ' + user + '...';

    // fetch using AJAX (simple)
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'ajax_borrower_history.php?user=' + encodeURIComponent(user) + '&book=' + encodeURIComponent(book), true);
    xhr.onload = function(){
        if (xhr.status === 200) {
            content.innerHTML = xhr.responseText;
            modal.style.display = 'block';
        } else {
            content.innerHTML = 'Failed to load history.';
            modal.style.display = 'block';
        }
    };
    xhr.send();
}

function closeHistory(){
    document.getElementById('historyModal').style.display = 'none';
}

function openReminderModal(user, defaultMsg){
    document.getElementById('rem_target').value = user;
    document.getElementById('rem_msg').value = defaultMsg;
    document.getElementById('reminderModal').style.display = 'block';
}

function closeReminder(){
    document.getElementById('reminderModal').style.display = 'none';
}
</script>

<style>
/* very small modal fallback styles if bootstrap modal isn't loaded */
.modal{ display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:2000; }
.modal-dialog{ margin:80px auto; }
.btn-close{ background:transparent; border:none; font-size:20px; }
</style>

<?php include 'inc/footer.php'; ?>
