<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

if (isset($_SESSION['user_email'])) {
    header("Location: views/user/community_dashboard.php");
    exit();
} elseif (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] == 'super_admin') {
    header("Location: views/admin/super_admin.php");
    exit();
} elseif (isset($_SESSION['admin_id'])) {
    header("Location: views/admin/main_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets\css\authentication\login_user.css">
    <link rel = "icon" type="image/svg+xml" href="assets/images/iconLogo1.svg">
</head>
<body>
    <?php
    if(isset($_GET['success']) && $_GET['success'] == 1){
        echo "<script>alert('Registration Successful!);</script>";
    }
    ?>
    <div class="wrapper">
        <div class="container">
            <img src="assets\images\Frame 1 (1).svg" alt="">
            <h1>WELCOME!</h1>
            <p class="subtitle"> Login to your account</p>
    

    <form method="POST" action="controllers/login_controller.php" id="loginForm">
            <input type="hidden" name="step" value="1">
            <label>Email or ID Number:</label>
            <input type="text" name="login_id" required>

            <label>Password:</label>
        <div class="input-wrapper">
            <input type="password" id="password" name ="password" required>
            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                <svg class="pass" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </button>
                        
        </div>
        <?php 
            if (isset($_SESSION['error'])) {
                echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']); 
            }
        ?>
        <div class="forgot">
            <a href="#">Forgot Password?</a>
        </div>
        <div class="login">
            <button type="submit" class="login-btn"><strong>Login</strong></button>
        </div>
    </form>
    <div class="link">
        <p class="login-link">Don't Have an Account Yet? <a href="views/authentication/step1.php">Create Your Account</a></p>
    </div>
                    
        </div>

        <div class="right-section">
            <div class="content">
                <img src="assets\images\Rectangle 1012.png" alt="">
            </div>
            <h1>Welcome to DRRM</h1>
            <p>This is a place for dedicated volunteers, emergency responders, and community 
                members to connect, coordinate, and respond to disasters efficiently. Stay 
                informed, receive real-time alerts, and be part of a life-saving network.</p>
        </div>
    </div>
    <script>
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>

</body>
<script src="assets\js\create_account.js"></script>
</html>
