<?php 
session_start();
include 'inc/connection.php';

// ========== ROLE CHECK FIXED ==========
if (!isset($_SESSION["student"])) {
	echo "<script>window.location='../login.php';</script>";
	exit();
}

$page = 'rbook';

// GET student DATA (FIXED SESSION)
$user = mysqli_query($link, "
    SELECT * FROM t_registration 
    WHERE username='{$_SESSION['student']}' LIMIT 1
");
$data = mysqli_fetch_assoc($user);

$username = $data['username'];
$name     = $data['name'];
$email    = $data['email'];
$utype    = 'student';

include 'inc/header.php';
?>

<style>
.book-container{display:flex;flex-wrap:wrap;gap:20px;justify-content:center;margin-top:25px;}
.book-card{width:160px;text-align:center;cursor:pointer;transition:.2s;}
.book-card:hover{transform:scale(1.06);}
.book-card img{width:100%;height:200px;object-fit:cover;border-radius:8px;}
.search-box{width:60%;margin:10px auto;}
.genre-filter{text-align:center;margin-bottom:10px;}
.genre-filter button{
	padding:6px 12px;margin:3px;
	background:#eee;border:none;cursor:pointer;
	border-radius:5px;transition:.2s;
}
.genre-filter button:hover{background:#ccc;}
</style>

<div class="dashboard-content">
	<div class="dashboard-header">
		<div class="container">

			<div class="row">
				<div class="col-md-6">
					<div class="left"><p><span>dashboard</span> student Panel</p></div>
				</div>

				<div class="col-md-6 text-right">
					<a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
					<span class="disabled">Request a Book</span>
				</div>
			</div>

			<!-- SEARCH FIELD -->
			<div class="search-box">
				<input id="searchInput" class="form-control" placeholder="🔍 Search books...">
			</div>

			<!-- GENRE FILTER -->
			<div class="genre-filter">
				<button onclick="filterGenre('all')">All</button>
				<?php 
				$genres = mysqli_query($link,"SELECT DISTINCT genre FROM add_book WHERE genre!=''");
				while($g=mysqli_fetch_assoc($genres)){
					echo "<button onclick=\"filterGenre('".$g['genre']."')\">".$g['genre']."</button>";
				}
				?>
			</div>

			<!-- BOOK GRID -->
			<div class="book-container" id="bookList">
				<?php 
				$books = mysqli_query($link,"SELECT * FROM add_book ORDER BY books_name ASC");
				while($row=mysqli_fetch_assoc($books)): ?>
				
				<div class="book-card"
					data-name="<?= strtolower($row['books_name']); ?>" 
					data-genre="<?= strtolower($row['genre']); ?>"
					onclick="openModal(
						'<?= $row['books_name']; ?>',
						'<?= $row['books_author_name']; ?>',
						'<?= $row['genre']; ?>',
						'<?= $row['id']; ?>'
					)">
					
					<img src="../../<?= $row['books_image']; ?>">
					<p><b><?= $row['books_name']; ?></b></p>
					<small><?= $row['genre']; ?></small>
				</div>
				
				<?php endwhile; ?>
			</div>

			<div id="msg" style="text-align:center;margin-top:10px;"></div>

		</div>
	</div>
</div>

<?php include 'inc/footer.php'; ?>

<!-- REQUEST MODAL -->
<div class="modal fade" id="requestModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h5>Request This Book</h5>
				<button class="close" data-dismiss="modal">&times;</button>
			</div>

			<div class="modal-body">
				<p><b>Book:</b> <span id="bookTitle"></span></p>
				<p><b>Author:</b> <span id="bookAuthor"></span></p>
				<p><b>Genre:</b> <span id="bookGenre"></span></p>
				<input type="hidden" id="bookId">
			</div>

			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button class="btn btn-primary" onclick="sendRequest()">📩 Send Request</button>
			</div>

		</div>
	</div>
</div>

<script>
function openModal(title,author,genre,id){
	document.getElementById("bookTitle").innerText = title;
	document.getElementById("bookAuthor").innerText = author;
	document.getElementById("bookGenre").innerText = genre;
	document.getElementById("bookId").value = id;
	$("#requestModal").modal("show");
}

function sendRequest(){
	let id = document.getElementById("bookId").value;

	$.post("send_request.php",{ book_id:id }, function(response){
		document.getElementById("msg").innerHTML = "<b style='color:green'>✔ "+response+"</b>";
		$("#requestModal").modal("hide");
	});
}

// SEARCH FILTER
document.getElementById("searchInput").addEventListener("keyup",()=>{
	let v = searchInput.value.toLowerCase();
	document.querySelectorAll(".book-card").forEach(c=>{
		c.style.display = c.dataset.name.includes(v) ? "block" : "none";
	});
});

// GENRE FILTER
function filterGenre(g){
	document.querySelectorAll(".book-card").forEach(c=>{
		c.style.display = (g=="all" || c.dataset.genre===g.toLowerCase()) ? "block":"none";
	});
}
</script>
