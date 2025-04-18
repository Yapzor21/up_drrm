<?php
session_start();

// Prevent caching of the login page
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// Check if the user is already logged in
if (isset($_SESSION['user'])) {
    // User is already logged in, redirect to the dashboard
    header("Location: ../views/user/community_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../assets/css/authentication/login_user.css">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <img src="../../assets/images/Frame 1 (1).svg" alt="">
            <h1>WELCOME!</h1>
            <p class="subtitle"> Login to your account</p>
    
            <form id="loginForm" method="post" action="../../controllers/user.php">
                <input type="hidden" name="action" value="login">
                <div class="form-group">
                    <label for="email_address">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" id="email_address" name="email_address" required>
                    </div>
                
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" required>
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
                    // Display error message if set
                    if (isset($_SESSION['flash_error'])) {
                        echo "<div class='flash-error'>" . $_SESSION['flash_error'] . "</div>";
                        unset($_SESSION['flash_error']); // Clear the flash message after displaying it
                        }
                    ?>
                    <div class="login">
                        <button type="submit" class="login-btn"><strong>Login</strong></button>
                    </div>
                    <p class="login-link">Don't Have an Account Yet? <a href="step1.php">Create Your Account</a></p>
                </div>
            </form>
        </div>

        <div class="right-section">
            <div class="content">
                <img src="../../assets/images/Rectangle 1012.png" alt="">
            </div>
            <h1>Welcome to DRRM</h1>
            <p>This is a place for dedicated volunteers, emergency responders, and community 
                members to connect, coordinate, and respond to disasters efficiently. Stay 
                informed, receive real-time alerts, and be part of a life-saving network.</p>
        </div>
    </div>
</body>
<link rel="stylesheet" href="../../assets/css/authentication/login_user.css">
<script src="../../assets/js/create_account.js"></script>
</html>