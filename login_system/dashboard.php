<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

?>
<div class="container">
    <h4>
        <a href="login_system/logout.php">تسجيل الخروج</a> 
        <?php echo $_SESSION['username']; ?> 
        مرحبا
    </h4>
</div>
