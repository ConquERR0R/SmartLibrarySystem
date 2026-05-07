<?php
// penalties.php
$page = 'penalties';
include 'inc/header.php';

// handle add penalty
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_penalty'])) {
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $user_type = mysqli_real_escape_string($link, $_POST['user_type']);
    $amount = floatval($_POST['amount']);
    $reason = mysqli_real_escape_string($link, $_POST['reason']);

    if ($username && $amount > 0) {
        mysqli_query($link, "INSERT INTO penalties (username, user_type, amount, reason) VALUES ('$username', '$user_type', $amount, '$reason')");
        // notify user
        $msg = "❗ A penalty of PHP " . number_format($amount,2) . " was issued. Reason: $reason";
        mysqli_query($link, "INSERT INTO notifications (username, message, type, is_read) VALUES ('$username', '".mysqli_real_escape_string($link,$msg)."','penalty','no')");
        $notice = "Penalty added and user notified.";
    } else {
        $notice = "Please provide valid username and amount.";
    }
}

// handle mark paid/unpaid via GET param action
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] === 'toggle') {
        // toggle paid flag
        $row = mysqli_fetch_assoc(mysqli_query($link, "SELECT paid, username FROM penalties WHERE id=$id LIMIT 1"));
        if ($row) {
            $new = $row['paid'] ? 0 : 1;
            mysqli_query($link, "UPDATE penalties SET paid=$new WHERE id=$id");
            // notify user
            $msg = $new ? "✅ Your penalty has been marked as PAID." : "❗ Your penalty has been marked as UNPAID.";
            mysqli_query($link, "INSERT INTO notifications (username, message, type, is_read) VALUES ('".$row['username']."', '".mysqli_real_escape_string($link,$msg)."','penalty','no')");
            header("Location: penalties.php");
            exit();
        }
    } elseif ($_GET['action'] === 'delete') {
        mysqli_query($link, "DELETE FROM penalties WHERE id=$id");
        header("Location: penalties.php");
        exit();
    }
}

// filters
$filter = $_GET['filter'] ?? 'all';
$where = "1=1";
if ($filter === 'unpaid') $where = "paid=0";
if ($filter === 'paid') $where = "paid=1";

// fetch penalties
$q = mysqli_query($link, "SELECT * FROM penalties WHERE $where ORDER BY created_at DESC");
?>
<div class="container">
    <h3>⚖ Penalties</h3>

    <?php if(!empty($notice)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($notice) ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <h5>Add Penalty</h5>
            <form method="POST" class="mb-3">
                <div class="mb-2">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required placeholder="student or teacher username">
                </div>
                <div class="mb-2">
                    <label>User Type</label>
                    <select name="user_type" class="form-select">
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Amount (PHP)</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Reason</label>
                    <input type="text" name="reason" class="form-control" required>
                </div>
                <button name="add_penalty" class="btn btn-danger">Add Penalty</button>
            </form>
        </div>

        <div class="col-md-6">
            <h5>Filter</h5>
            <div class="mb-3">
                <a href="penalties.php?filter=all" class="btn btn-sm btn-outline-primary">All</a>
                <a href="penalties.php?filter=unpaid" class="btn btn-sm btn-outline-warning">Unpaid</a>
                <a href="penalties.php?filter=paid" class="btn btn-sm btn-outline-success">Paid</a>
            </div>

            <h5>Existing Penalties</h5>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>User Type</th>
                            <th>Amount</th>
                            <th>Reason</th>
                            <th>Created</th>
                            <th>Paid</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (mysqli_num_rows($q) == 0) {
                        echo "<tr><td colspan='8' class='text-center'>No penalties found.</td></tr>";
                    } else {
                        $i=1;
                        while($r = mysqli_fetch_assoc($q)) {
                            echo "<tr>";
                            echo "<td>".$i++."</td>";
                            echo "<td>".htmlspecialchars($r['username'])."</td>";
                            echo "<td>".htmlspecialchars($r['user_type'])."</td>";
                            echo "<td>PHP ".number_format($r['amount'],2)."</td>";
                            echo "<td>".htmlspecialchars($r['reason'])."</td>";
                            echo "<td>".htmlspecialchars($r['created_at'])."</td>";
                            echo "<td>".($r['paid'] ? '<span class=\"text-success\">Paid</span>' : '<span class=\"text-danger\">Unpaid</span>')."</td>";
                            echo "<td>
                                <a class='btn btn-sm btn-outline-success' href='penalties.php?action=toggle&id=".$r['id']."'>Toggle Paid</a>
                                <a class='btn btn-sm btn-outline-danger' href='penalties.php?action=delete&id=".$r['id']."' onclick=\"return confirm('Delete penalty?')\">Delete</a>
                            </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>
