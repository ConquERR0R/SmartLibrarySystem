<?php
session_start();

if (!isset($_SESSION["username"]) || $_SESSION["role"] != "librarian") {
    header("location: login.php");
    exit;
}

$page = "userinfo";

include 'inc/header.php';
include 'inc/connection.php';
?>

<style>
.badge { padding:5px 10px; border-radius:6px; font-weight:600; }
.badge-active { background:#2ecc71; }
.badge-archived { background:#e67e22; }
.badge-pending { background:#3498db; }

.action-btn { margin: 3px; }
.modal-bg {
    display:none; position:fixed; left:0; top:0;
    width:100%; height:100%; background:#00000070;
    justify-content:center; align-items:center;
}
.modal-box {
    background:white; padding:20px; width:320px;
    border-radius:10px;
}
</style>

<div class="dashboard-content">
    <div class="dashboard-header">
        <div class="container">

            <h3 class="text-center mb-4">All Users</h3>

            <input type="text" id="searchInput" class="form-control mb-3"
                   placeholder="Search by name, username, email, or type...">

            <table class="table table-dark table-striped text-center" id="userTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Status</th>
                        <th width="200">Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $data = mysqli_query($link, "
                    SELECT id, name, username, email, status, 'Student' AS type FROM std_registration
                    UNION ALL
                    SELECT id, name, username, email, status, 'Teacher' AS type FROM t_registration
                    ORDER BY name ASC
                ");

                while ($row = mysqli_fetch_assoc($data)) {

                    $status = strtolower($row['status']);

                    if ($status == "pending") $badge = "<span class='badge badge-pending'>Pending</span>";
                    elseif ($status == "archived") $badge = "<span class='badge badge-archived'>Archived</span>";
                    else $badge = "<span class='badge badge-active'>Active</span>";

                    echo "
                    <tr>
                        <td>{$row['name']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['type']}</td>
                        <td>$badge</td>
                        <td>
                            <button class='btn btn-info btn-sm action-btn'
                                onclick=\"editUser(
                                    '{$row['id']}',
                                    '{$row['name']}',
                                    '{$row['email']}',
                                    '{$row['type']}'
                                )\">
                                Edit
                            </button>

                            <button class='btn btn-danger btn-sm action-btn'
                                onclick=\"openDelete(
                                    '{$row['id']}',
                                    '{$row['username']}',
                                    '{$row['type']}'
                                )\">
                                Delete
                            </button>
                        </td>
                    </tr>";
                }
                ?>

                </tbody>
            </table>

        </div>
    </div>
</div>


<!-- ======================= EDIT MODAL ======================= -->
<div id="editModal" class="modal-bg">
    <div class="modal-box">
        <h4>Edit User</h4>

        <form method="post" action="update-user.php">
            <input type="hidden" id="editID" name="id">
            <input type="hidden" id="editType" name="type">

            <label>Name</label>
            <input type="text" id="editName" name="name" class="form-control" required>

            <label class="mt-2">Email</label>
            <input type="email" id="editEmail" name="email" class="form-control" required>

            <button class="btn btn-success w-100 mt-3">Save</button>
            <button class="btn btn-secondary w-100 mt-2" type="button" onclick="closeEdit()">Cancel</button>
        </form>
    </div>
</div>


<!-- ======================= DELETE MODAL ======================= -->
<div id="deleteModal" class="modal-bg">
    <div class="modal-box">
        <h4 class="text-danger"><i class="fa fa-trash"></i> Confirm Delete</h4>
        <p>Type the username to delete:</p>

        <b id="deleteUserPreview" style="color:red;"></b>

        <input type="text" id="deleteConfirm" class="form-control mt-2">

        <form action="delete-user.php" method="post" id="deleteForm">
            <input type="hidden" name="id" id="deleteID">
            <input type="hidden" name="type" id="deleteType">

            <button id="deleteBtn" class="btn btn-danger w-100 mt-3" disabled>
                Delete User
            </button>
        </form>

        <button class="btn btn-secondary w-100 mt-2" onclick="closeDelete()">Cancel</button>
    </div>
</div>


<script>
// --------- SEARCH FILTER ----------
document.getElementById("searchInput").addEventListener("keyup", function(){
    let value = this.value.toLowerCase();

    document.querySelectorAll("#userTable tbody tr").forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
    });
});


// ---------- EDIT ----------
function editUser(id, name, email, type){
    document.getElementById("editID").value = id;
    document.getElementById("editName").value = name;
    document.getElementById("editEmail").value = email;
    document.getElementById("editType").value = type;

    document.getElementById("editModal").style.display = "flex";
}

function closeEdit(){
    document.getElementById("editModal").style.display = "none";
}


// ---------- DELETE ----------
let expectedName = "";

function openDelete(id, username, type){
    expectedName = username;

    document.getElementById("deleteUserPreview").innerText = username;
    document.getElementById("deleteID").value = id;
    document.getElementById("deleteType").value = type;

    document.getElementById("deleteConfirm").value = "";
    document.getElementById("deleteBtn").disabled = true;

    document.getElementById("deleteModal").style.display = "flex";
}

function closeDelete(){
    document.getElementById("deleteModal").style.display = "none";
}

// ENABLE DELETE WHEN MATCH
document.getElementById("deleteConfirm").addEventListener("keyup", function(){
    document.getElementById("deleteBtn").disabled = (this.value !== expectedName);
});
</script>

<?php include 'inc/footer.php'; ?>
