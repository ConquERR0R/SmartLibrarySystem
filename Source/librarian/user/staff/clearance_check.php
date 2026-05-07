<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../login.php");
    exit();
}

include '../../inc/connection.php';
include 'inc/header.php';

$current_semester = "2024-2025-1st";
?>

<div class="container mt-4">
    <h3>📋 Student / Teacher Clearance Check</h3>

    <table class="table table-bordered text-center">
        <thead class="table-dark">
            <tr>
                <th>Username</th>
                <th>User Type</th>
                <th>Unreturned Books</th>
                <th>Clearance</th>
            </tr>
        </thead>

        <tbody>
        <?php
        $users = mysqli_query($link,"
            SELECT username, utype
            FROM t_registration
        ");

        while ($u = mysqli_fetch_assoc($users)) {

            $username = $u['username'];
            $utype    = ucfirst($u['utype']);

            $q = mysqli_query($link,"
                SELECT COUNT(*) AS total
                FROM issue_book
                WHERE username='$username'
                AND status='Borrowed'
                AND semester='$current_semester'
            ");

            $count = mysqli_fetch_assoc($q)['total'];
        ?>
            <tr>
                <td><?= $username ?></td>
                <td><?= $utype ?></td>
                <td><?= $count ?></td>
                <td>
                    <?php if ($count > 0): ?>
                        <span class="badge bg-danger">NOT CLEARED</span>
                    <?php else: ?>
                        <span class="badge bg-success">CLEARED</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'inc/footer.php'; ?>
