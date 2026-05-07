<?php
session_start();
include 'inc/connection.php';

/* =========================
   BACKEND ACTION HANDLER
========================= */
if (isset($_POST['action'])) {

    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
        echo "Unauthorized";
        exit();
    }

    $username = $_SESSION['username'];
    $action   = $_POST['action'];
    $book_id  = intval($_POST['book_id']);

    $b = mysqli_query($link,"SELECT books_name FROM add_book WHERE id='$book_id'");
    $bk = mysqli_fetch_assoc($b);
    $bookName = $bk['books_name'];

    // prevent duplicate
    $chk = mysqli_query($link,"
        SELECT id FROM reservations
        WHERE username='$username'
        AND book_id='$book_id'
        AND status IN('requested','reserved')
    ");

    if (mysqli_num_rows($chk) > 0 && $action != 'cancel') {
        echo "Already requested or reserved.";
        exit();
    }

    if ($action == 'request') {
        mysqli_query($link,"
            INSERT INTO reservations
            (username,utype,action_type,book_id,book_name,reserved_at,status)
            VALUES
            ('$username','student','request','$book_id','$bookName',NOW(),'requested')
        ");
        echo "📩 Request sent!";
        exit();
    }

    if ($action == 'reserve') {
        mysqli_query($link,"
            INSERT INTO reservations
            (username,utype,action_type,book_id,book_name,reserved_at,status)
            VALUES
            ('$username','student','reserve','$book_id','$bookName',NOW(),'reserved')
        ");
        echo "⭐ Book reserved!";
        exit();
    }

    if ($action == 'cancel') {
        mysqli_query($link,"
            DELETE FROM reservations
            WHERE username='$username'
            AND book_id='$book_id'
            AND status IN('requested','reserved')
        ");
        echo "❌ Cancelled.";
        exit();
    }
}

/* =========================
   PAGE DISPLAY
========================= */
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$page = 'rbook';
include 'inc/header.php';
?>

<style>
.book-container{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    justify-content:center;
}
.book-card{
    width:160px;
    cursor:pointer;
    text-align:center;
    z-index:10;
}
.book-card img{
    width:100%;
    height:190px;
    object-fit:cover;
    border-radius:8px;
}
.book-card:hover{ transform:scale(1.05); }
</style>

<div class="dashboard-content">
<div class="container">

<h4>📚 Request / Reserve Book</h4>

<div class="book-container">
<?php
$books = mysqli_query($link,"SELECT * FROM add_book WHERE status='active'");
while($row=mysqli_fetch_assoc($books)):
?>
    <div class="book-card"
         onclick="openModal(
            '<?= addslashes($row['books_name']) ?>',
            '<?= addslashes($row['books_author_name']) ?>',
            '<?= addslashes($row['genre']) ?>',
            '<?= $row['id'] ?>'
         )">
        <img src="../../<?= $row['books_image'] ?>">
        <b><?= $row['books_name'] ?></b><br>
        <small><?= $row['genre'] ?></small>
    </div>
<?php endwhile; ?>
</div>

<div id="msg" style="margin-top:15px;font-weight:bold;"></div>

</div>
</div>

<?php include 'inc/footer.php'; ?>

<!-- MODAL -->
<div class="modal fade" id="requestModal">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title">Book Options</h5>
    <button class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    <p><b>Book:</b> <span id="bookTitle"></span></p>
    <p><b>Author:</b> <span id="bookAuthor"></span></p>
    <p><b>Genre:</b> <span id="bookGenre"></span></p>
    <input type="hidden" id="bookId">
</div>

<div class="modal-footer">
    <button class="btn btn-danger" onclick="sendAction('cancel')">Cancel</button>
    <button class="btn btn-warning" onclick="sendAction('reserve')">Reserve</button>
    <button class="btn btn-primary" onclick="sendAction('request')">Request</button>
</div>

</div>
</div>
</div>

<script>
function openModal(title, author, genre, id){
    document.getElementById("bookTitle").innerText = title;
    document.getElementById("bookAuthor").innerText = author;
    document.getElementById("bookGenre").innerText = genre;
    document.getElementById("bookId").value = id;
    $('#requestModal').modal('show');
}

function sendAction(act){
    let id = document.getElementById("bookId").value;
    $.post("",{action:act,book_id:id},function(res){
        document.getElementById("msg").innerHTML = res;
        $('#requestModal').modal('hide');
    });
}
</script>
