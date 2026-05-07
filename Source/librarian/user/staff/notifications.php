<?php
session_start();
include 'inc/connection.php';

$username = $_SESSION['username'];

// Mark all as read
mysqli_query($link, "UPDATE notifications SET is_read='yes' WHERE username='$username'");

$notif = mysqli_query($link, "
    SELECT * FROM notifications 
    WHERE username='$username' 
    ORDER BY id DESC
");
?>

<div class="container mt-4">
    <h3>Notifications</h3>
    <ul class="list-group">

    <?php while($n = mysqli_fetch_assoc($notif)): ?>
        <li class="list-group-item">
            <div><?= $n['message'] ?></div>
            <small class="text-muted"><?= $n['created_at'] ?></small>
        </li>
    <?php endwhile; ?>

    </ul>
</div>
