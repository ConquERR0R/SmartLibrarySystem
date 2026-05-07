<?php
session_start();
include "inc/connection.php"; 

// Redirect if already logged in
if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'student') {
        header("Location: user/student/dashboard.php"); exit;

    } elseif ($_SESSION['role'] === 'staff') {
        header("Location: user/staff/dashboard.php"); exit;

    } elseif ($_SESSION['role'] === 'teacher') {
        header("Location: user/teacher/dashboard.php"); exit;


    } elseif ($_SESSION['role'] === 'librarian') {
        header("Location: dashboard.php"); exit;
    } 
}

// SEARCH handling
$search = "";
if (isset($_GET['search']) && trim($_GET['search']) !== "") {
    $search = mysqli_real_escape_string($link, trim($_GET['search']));
    $books_q = "SELECT * FROM add_book 
                WHERE (books_name LIKE '%$search%' OR books_author_name LIKE '%$search%')
                ORDER BY books_name ASC";
} else {
    $books_q = "SELECT * FROM add_book ORDER BY books_name ASC";
}
$books = mysqli_query($link, $books_q);

// category list
$categories = mysqli_query($link, "SELECT DISTINCT genre FROM add_book ORDER BY genre ASC");

// recommended
$recommended = mysqli_query($link, "SELECT * FROM add_book ORDER BY books_name ASC LIMIT 12");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Smart Library</title>

<!-- Bootstrap -->
<link href="inc/css/bootstrap.min.css" rel="stylesheet">

<!-- Swiper -->
<link rel="stylesheet" href="inc/css/swiper-bundle.min.css">

<style>

/* BACKGROUND SLIDESHOW */
.bg-slideshow{
    position: fixed; top:0; left:0; width:100%; height:100vh;
    overflow:hidden; z-index:-1;
}
.bg-slideshow img{
    position:absolute; width:100%; height:100%; object-fit:cover;
    opacity:0; animation: slideShow 30s infinite;
}
.bg-slideshow img:nth-child(1){animation-delay:0s}
.bg-slideshow img:nth-child(2){animation-delay:6s}
.bg-slideshow img:nth-child(3){animation-delay:12s}
.bg-slideshow img:nth-child(4){animation-delay:18s}
.bg-slideshow img:nth-child(5){animation-delay:24s}

@keyframes slideShow {
    0% {opacity:0; transform:scale(1.05) translateX(-20px);}
    8% {opacity:1; transform:scale(1.02) translateX(0);}
    40% {opacity:1; transform:scale(1.02) translateX(10px);}
    50% {opacity:0; transform:scale(1.05) translateX(30px);}
    100% {opacity:0;}
}

/* OVERLAYS */
#popupOverlay, #loginOverlay {
    position: fixed; top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.55); backdrop-filter: blur(6px);
    display:none; z-index:900;
}

/* BOOK POPUP */
#bookPopup{
    position:fixed; top:50%; left:50%;
    transform:translate(-50%,-50%) scale(0.9);
    width:760px; max-width:95%;
    background:rgba(255,255,255,0.95);
    padding:20px; border-radius:12px;
    box-shadow:0 12px 40px rgba(0,0,0,0.45);
    display:none; z-index:1000; transition:0.22s;
}
#bookPopup.show{ transform:translate(-50%,-50%) scale(1); }
#bookPopup .close-btn{
    position:absolute; top:10px; right:14px;
    font-size:26px; cursor:pointer;
}

/* LOGIN PANEL */
#loginPanel{
    position:fixed; top:50%; left:50%;
    transform:translate(-50%,-50%) scale(0.9);
    width:380px; max-width:95%;
    background:rgba(255,255,255,0.96);
    padding:20px; border-radius:10px;
    box-shadow:0 8px 28px rgba(0,0,0,0.3);
    display:none; z-index:1001; transition:0.22s;
}
#loginPanel.show{ transform:translate(-50%,-50%) scale(1); }

/* SWIPER */
.swiper{ width:100%; padding:18px 0; }
.swiper-slide{
    width:160px !important;
    display:flex; justify-content:center;
}
.slide-card{
    position:relative;
}
.slide-card img{
    width:100%; height:240px; object-fit:cover;
    border-radius:10px;
    box-shadow:0 6px 18px rgba(0,0,0,0.25);
}

/* BOOK GRID */
.book-img{
    width:100%; height:260px;
    object-fit:cover; border-radius:10px;
}
.book-card{
    position:relative;
}
.book-card:hover{
    transform:translateY(-6px);
    transition:0.2s;
}

/* GENRE LABEL */
.genre-label{
    position:absolute;
    bottom:8px;
    left:8px;
    background:rgba(255,255,255,0.92);
    padding:4px 10px;
    font-size:12px;
    font-weight:600;
    color:#000;
    border-radius:20px;
    box-shadow:0 2px 6px rgba(0,0,0,0.3);
}

/* RECOMMENDED LABEL FIX */
.recommended-title {
    display: inline-block;
    background: #1a73e8;
    color: white;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 6px;
    margin-bottom: 10px;
    font-size: 17px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.25);
}
</style>
</head>
<body>

<!-- BACKGROUND -->
<div class="bg-slideshow">
    <img src="styles/ctu.jpg">
    <img src="styles/ctu1.jpg">
    <img src="styles/ctu2.jpg">
    <img src="styles/ctu3.jpg">
    <img src="styles/ctu4.jpg">
</div>
<!-- POPUP OVERLAYS -->
<div id="popupOverlay" onclick="closeBookPopup()"></div>
<div id="loginOverlay" onclick="closeLoginPanel()"></div>

<!-- BOOK POPUP -->
<div id="bookPopup">
    <span class="close-btn" onclick="closeBookPopup()">×</span>
    <div id="popupContent">Loading…</div>
</div>

<!-- LOGIN PANEL -->
<div id="loginPanel">
    <span class="close-btn" onclick="closeLoginPanel()">×</span>
    <h4 class="text-center fw-bold mb-3">Log In</h4>

    <form method="POST" action="login_process.php">
        <label>Username</label>
        <input type="text" id="username" name="username"
               class="form-control mb-2" required>

        <div id="role_box"
             style="display:none; background:#eef5ff; padding:6px; border-radius:6px; margin-bottom:10px; border:1px solid #bcd1ff;">
        </div>

        <label>Password</label>
        <input type="password" name="password"
               class="form-control mb-2" required>

        <button class="btn btn-primary w-100 mt-2" name="login">Log In</button>

        <div class="text-center mt-3">
            Don't have an account?  
            <a href="registration.php" style="font-weight:bold;">Sign up here</a>
        </div>
    </form>
</div>

<!-- NAVBAR -->
<nav class="navbar bg-white px-4 shadow-sm">
    <span class="fs-4 fw-bold">📚 Smart Library</span>

    <button onclick="openLoginPanel()" class="btn btn-outline-primary">
        Log In
    </button>
</nav>

<div class="container py-4">

<!-- SEARCH -->
<form method="GET">
    <input type="text" name="search" class="form-control form-control-lg mb-3"
           value="<?php echo htmlspecialchars($search); ?>"
           placeholder="🔍 Search book title or author...">
</form>

<!-- RECOMMENDED LABEL -->
<div class="recommended-title">Recommended</div>

<!-- RECOMMENDED SWIPER -->
<div class="swiper recommended-swiper mb-3">
    <div class="swiper-wrapper">

        <?php while($r = mysqli_fetch_assoc($recommended)): ?>
            <div class="swiper-slide">
                <div class="slide-card"
                     onclick="openBookPopup(<?php echo $r['id']; ?>, this)"
                     data-id="<?= $r['id']; ?>"
                     data-title="<?= htmlspecialchars($r['books_name']); ?>"
                     data-author="<?= htmlspecialchars($r['books_author_name']); ?>"
                     data-desc="<?= htmlspecialchars($r['genre']); ?>"
                >
                    <img src="<?= $r['books_image']; ?>">
                    <span class="genre-label"><?= $r['genre'] ?: 'Unknown'; ?></span>
                </div>
            </div>
        <?php endwhile; ?>

    </div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<!-- BOOK GRID -->
<div class="row g-4">
<?php while($b = mysqli_fetch_assoc($books)): ?>
    <div class="col-6 col-md-2">
        <div class="book-card"
             onclick="openBookPopup(<?= $b['id']; ?>, this)"
             data-id="<?= $b['id']; ?>"
             data-title="<?= htmlspecialchars($b['books_name']); ?>"
             data-author="<?= htmlspecialchars($b['books_author_name']); ?>"
             data-desc="<?= htmlspecialchars($b['genre']); ?>"
        >
            <img src="<?= $b['books_image']; ?>" class="book-img">
            <span class="genre-label"><?= $b['genre'] ?: 'Unknown'; ?></span>
        </div>
    </div>
<?php endwhile; ?>
</div>

</div> <!-- END CONTAINER -->

<!-- Swiper JS -->
<script src="inc/js/swiper-bundle.min.js"></script>

<script>
// SWIPER
const recSwiper = new Swiper('.recommended-swiper', {
    slidesPerView:'auto',
    spaceBetween:18,
    loop:true,
    autoplay:{ delay:2200, disableOnInteraction:false },
    navigation:{ nextEl:'.swiper-button-next', prevEl:'.swiper-button-prev' }
});

// OPEN LOGIN PANEL
function openLoginPanel(){
    closeBookPopup();
    document.getElementById('loginOverlay').style.display='block';
    const p=document.getElementById('loginPanel');
    p.style.display='block';
    setTimeout(()=>p.classList.add('show'),10);
}

// CLOSE LOGIN PANEL
function closeLoginPanel(){
    document.getElementById('loginOverlay').style.display='none';
    const p=document.getElementById('loginPanel');
    p.classList.remove('show');
    setTimeout(()=>p.style.display='none',200);
}

// OPEN BOOK POPUP
function openBookPopup(bookId, el){
    document.getElementById('popupOverlay').style.display='block';
    const pop=document.getElementById('bookPopup');
    pop.style.display='block';
    setTimeout(()=>pop.classList.add('show'),10);

    document.getElementById("popupContent").innerHTML = `
        <div style="padding:10px;">
            <h4>${el.dataset.title}</h4>
            <p><b>Author:</b> ${el.dataset.author}</p>
            <p><b>Genre:</b> ${el.dataset.desc}</p>

            <button class="btn btn-primary w-100 mt-2"
                    onclick="openLoginPanel(); closeBookPopup();">
                Login to Borrow
            </button>

            <div class="text-center mt-3">
                If you don't have an account, <br>
                <a href="registration.php" onclick="closeBookPopup();" style="font-weight:bold;">
                    Sign up here
                </a>
            </div>
        </div>
    `;
}

// CLOSE BOOK POPUP
function closeBookPopup(){
    document.getElementById('popupOverlay').style.display='none';
    const pop=document.getElementById('bookPopup');
    pop.classList.remove('show');
    setTimeout(()=>pop.style.display='none',200);
}

// AUTO ROLE DETECT (username typing)
document.getElementById("username").addEventListener("keyup", function(){
    fetch("roleChecker.php", {
        method:"POST",
        headers:{ "Content-Type":"application/x-www-form-urlencoded" },
        body:"username="+this.value
    })
    .then(res=>res.text())
    .then(role=>{
        const box=document.getElementById("role_box");

        if(this.value===""){
            box.style.display="none";
            return;
        }

        box.style.display="block";
        box.innerHTML = role !== "" ? "Role: " + role : "Unknown ❓";
    });
});
</script>

</body>
</html>
