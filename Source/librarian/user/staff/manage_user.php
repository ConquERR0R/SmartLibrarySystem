<?php
session_start();

// STAFF ONLY
if (!isset($_SESSION["staff"]) || $_SESSION["role"] !== "staff") {
    header("Location: ../../login.php");
    exit;
}

$page = "manage_users";

include 'inc/header.php';
include '../../inc/connection.php';
?>

<style>
.badge {
    padding: 5px 10px;
    border-radius: 6px;
    font-weight: bold;
}
.badge-active { background: #2ecc71; color:white; }
.badge-archived { background: #e67e22; color:white; }
.badge-pending { background: #3498db; color:white; }

.search-box {
    width: 300px;
    margin-bottom: 15px;
    border-radius: 6px;
}

.modal-bg {
    display:none; 
    position:fixed; 
    left:0; top:0; width:100%; height:100%;
    background:#00000080; 
    justify-content:center; 
    align-items:center;
}

.modal-box {
    background:white; 
    padding:20px; 
    width:330px; 
    border-radius:10px;
}
.btn-sm { margin: 3px; }
</style>

<div class="container">

    <h3 class="mb-4"><i class="fas fa-users"></i> Manage Users</h3>

    <!-- SEARCH -->
    <input type="text" id="searchInput" class="form-control search-box"
        placeholder="Search name, username, or email…">

    <table class="table table-bordered table-striped text-center" id="userTable">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Status</th>
                <th width="320">Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php

        // Students + Teachers only
        $data = mysqli_query($link, "
            SELECT id, name, username, email, status, 'Student' AS type 
            FROM std_registration

            UNION ALL

            SELECT id, name, username, email, status, 'Teacher' AS type 
            FROM t_registration

            ORDER BY type ASC, name ASC
        ");

        while ($row = mysqli_fetch_assoc($data)) {

            $status = strtolower(trim($row["status"]));

            // STATUS BADGES
            if ($status == "pending") {
                $badge = "<span class='badge badge-pending'>Pending</span>";
            } elseif ($status == "archived") {
                $badge = "<span class='badge badge-archived'>Archived</span>";
            } else {
                $badge = "<span class='badge badge-active'>Active</span>";
            }

            echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['username']}</td>
                <td>{$row['email']}</td>
                <td>{$row['type']}</td>
                <td>$badge</td>
                <td>";

            // PENDING USERS
            if ($status == "pending") {
                echo "
                    <a href='user_actions/approve.php?id={$row['id']}&type={$row['type']}'
                        class='btn btn-success btn-sm'>
                        Approve
                    </a>

                    <a href='user_actions/decline.php?id={$row['id']}&type={$row['type']}'
                        class='btn btn-danger btn-sm'>
                        Decline
                    </a>
                ";
            }

            // ACTIVE USERS
            if ($status == "active") {
                echo "
                    <button class='btn btn-info btn-sm'
                        onclick=\"editUser('{$row['id']}', '{$row['name']}', '{$row['email']}')\">
                        Edit
                    </button>

                    <a href='user_actions/archive.php?id={$row['id']}&type={$row['type']}'
                       class='btn btn-warning btn-sm'
                       onclick=\"return confirm('Archive this account?');\">
                       Archive
                    </a>
                ";
            }

            // ARCHIVED USERS
            if ($status == "archived") {
                echo "
                    <a href='user_actions/restore.php?id={$row['id']}&type={$row['type']}'
                       class='btn btn-success btn-sm'>
                       Restore
                    </a>

                    <button class='btn btn-danger btn-sm'
                        onclick=\"openDeleteModal('{$row['id']}', '{$row['username']}', '{$row['type']}')\">
                        Delete
                    </button>
                ";
            }

            echo "</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>


<!-- EDIT MODAL -->
<div id="editModal" class="modal-bg">
    <div class="modal-box">
        <h4>Edit User</h4>

        <form method="post" action="user_actions/update.php">
            <input type="hidden" id="editID" name="id">

            <label>Name</label>
            <input type="text" id="editName" name="name" class="form-control">

            <label class="mt-2">Email</label>
            <input type="email" id="editEmail" name="email" class="form-control">

            <button class="btn btn-success w-100 mt-3">Save Changes</button>
            <button type="button" class="btn btn-secondary w-100 mt-2" onclick="closeModal()">Cancel</button>
        </form>
    </div>
</div>


<!-- DELETE MODAL -->
<div id="deleteModal" class="modal-bg">
    <div class="modal-box">
        <h4 class="text-danger"><i class="fa fa-trash"></i> Confirm Delete</h4>

        <p>Type username to confirm:</p>
        <b id="delUserPreview" style="color:#c0392b;"></b>

        <input type="text" id="confirmInput" class="form-control mt-2">

        <form action="user_actions/delete.php" method="get" id="deleteForm">
            <input type="hidden" name="id" id="deleteID">
            <input type="hidden" name="type" id="deleteType">

            <button class="btn btn-danger w-100 mt-3" id="deleteBtn" disabled>
                Delete Permanently
            </button>
        </form>

        <button onclick="closeDeleteModal()" class="btn btn-secondary w-100 mt-2">Cancel</button>
    </div>
</div>


<script>
let expectedUsername = "";

// Open EDIT modal
function editUser(id, name, email){
    document.getElementById("editID").value = id;
    document.getElementById("editName").value = name;
    document.getElementById("editEmail").value = email;

    document.getElementById("editModal").style.display = "flex";
}

// Close EDIT modal
function closeModal(){
    document.getElementById("editModal").style.display = "none";
}


// Open DELETE modal
function openDeleteModal(id, username, type){
    expectedUsername = username;
    document.getElementById("delUserPreview").innerText = username;

    document.getElementById("deleteID").value = id;
    document.getElementById("deleteType").value = type;

    document.getElementById("confirmInput").value = "";
    document.getElementById("deleteBtn").disabled = true;

    document.getElementById("deleteModal").style.display = "flex";
}

// Close DELETE modal
function closeDeleteModal(){
    document.getElementById("deleteModal").style.display = "none";
}

// Validate delete confirmation
document.getElementById("confirmInput").addEventListener("keyup", function () {
    document.getElementById("deleteBtn").disabled = (this.value !== expectedUsername);
});

// SEARCH FUNCTION
document.getElementById("searchInput").addEventListener("keyup", function(){
    let search = this.value.toLowerCase();

    document.querySelectorAll("#userTable tbody tr").forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(search) ? "" : "none";
    });
});
</script>

<?php include 'inc/footer.php'; ?>
