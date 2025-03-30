<?php
session_start();

// Prevent caching of the login page
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Check if the user is already logged in
if (isset($_SESSION['admin_id'])) {
    // User is already logged in, redirect to the dashboard
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
</head>
<body>
 
    <div class="wrapper">
        <div class="container">
            <img src="assets\images\Frame 1 (1).svg" alt="">
            <h1>WELCOME!</h1>
            <p class="subtitle"> Login to your account</p>
    
            <form id="loginForm" method="post" action="controllers/admin_control.php">
                <div class="form-group">
                        <input type="hidden" name="step" value="1">
                    <label for="admin_id">Admin User Id</label>
                    <div class="input-wrapper">
                        <input type="number" id="number" name="admin_id" required>
                    </div>
    
                    <label for="password">Password</label>
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
                    <div class="forgot">
                        <a href="#">Forgot Password?</a>
                    </div>
                    <?php 
                        if (isset($_SESSION['error'])) {
                        echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                        unset($_SESSION['error']); 
                        }
                        ?>
                    <div class="login">
                    <button type="submit" class="login-btn"><strong>Login</strong></button>
                    </div>

                    <div class="divider">OR</div>

                    <div class="community">
                        <a href="views\authentication\login_user.php" class="community"> <strong>Community Log In</strong></a>
                     </div>

                    
                </div>
            </form>
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
</body>
<link rel="stylesheet" href="assets\css\authentication\login_user.css">
<script src="assets\js\create_account.js"></script>
</html>
