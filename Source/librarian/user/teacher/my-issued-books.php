<?php 
session_start();

if (!isset($_SESSION["teacher"])) {
	echo "<script>window.location='login.php';</script>";
	exit();
}

$page = 'ibook';
include 'inc/header.php';
include 'inc/connection.php';

$username = $_SESSION['teacher'];
?>

<style>
.book-container{display:flex;flex-wrap:wrap;gap:20px;justify-content:center;margin-top:25px;}
.book-card{width:180px;padding:10px;text-align:center;border-radius:8px;background:#111;color:white;cursor:pointer;transition:.2s;box-shadow:0 0 8px rgba(255,255,255,0.1);}
.book-card:hover{transform:scale(1.05);}
.book-card img{width:100%;height:220px;object-fit:cover;border-radius:5px;}
.tag{font-size:14px;margin-top:5px;padding:3px 8px;border-radius:5px;display:inline-block;}
.btn-read{margin-top:8px;background:#27ae60;border:none;padding:8px;width:100%;color:white;font-weight:bold;border-radius:5px;}
.btn-return{margin-top:5px;background:#eb9534;border:none;padding:8px;width:100%;color:white;font-weight:bold;border-radius:5px;}
</style>

<div class="dashboard-content">
	<div class="dashboard-header">
		<div class="container">

			<div class="row">
				<div class="col-md-6"><div class="left"><p><span>dashboard</span> My Borrowed Books</p></div></div>
				<div class="col-md-6 text-right">
					<a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
					<span class="disabled">Issued Books</span>
				</div>
			</div>

			<div class="book-container">

				<?php 
				$res = mysqli_query($link,"
					SELECT issue_book.*, add_book.books_image, add_book.books_file 
					FROM issue_book
					INNER JOIN add_book ON issue_book.booksname = add_book.books_name
					WHERE issue_book.username='$username' 
					AND issue_book.status='borrowed'
				");

				if(mysqli_num_rows($res) == 0){
					echo "<p style='color:#aaa;font-size:18px;margin-top:30px;'>📭 You have no active borrowed books.</p>";
				}

				while($row=mysqli_fetch_assoc($res)){ 
					$due = strtotime($row['booksreturndate']);
					$today = strtotime(date("Y-m-d"));
					$isLate = $today > $due;
				?>
				
				<div class="book-card">
					<img src="../../<?= $row['books_image']; ?>">
					<h5><?= $row['booksname']; ?></h5>

					<span class="tag" style="background:<?= $isLate ? '#c0392b' : '#27ae60'; ?>">
						<?= $isLate ? "Overdue ❌" : "On Time ✔" ?>
					</span>

					<p style="font-size:13px;">Due: <?= $row['booksreturndate']; ?></p>

					<button class="btn-read" onclick="readBook('<?= $row['books_file']; ?>')">📖 Read</button>
					<button class="btn-return" onclick="returnBook(<?= $row['id']; ?>)">↩ Return</button>
				</div>

				<?php } ?>

			</div>

			<div id="message" style="text-align:center;margin-top:10px;"></div>

		</div>
	</div>
</div>

<script>
function readBook(file){ 
	window.open("../../"+file, "_blank"); 
}

function returnBook(id){
	if(confirm("Are you sure you want to return this book?")){
		$.post("return_handler.php", {issue_id:id, reason:"Normal"}, function(response){
			document.getElementById("message").innerHTML =
				"<p style='color:green;font-weight:bold'>✔ " + response + "</p>";
			setTimeout(() => location.reload(), 1200);
		});
	}
}
</script>

<?php include 'inc/footer.php'; ?>
