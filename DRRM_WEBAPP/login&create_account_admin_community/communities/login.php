<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/login&create_account_admin_community/communities/css/login.css">
</head>
<body>

    <div class="wrapper">
        <div class="container">
            <img src="/login&create_account_admin_community/communities/images/Frame 1.svg" alt="">
            <h1>WELCOME!</h1>
            <p class="subtitle"> Login to your account</p>
    
            <form id="loginForm">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" required>
                    </div>
    
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">
                            <svg class="pass" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <div class="forgot">
                        <a href="#">Forgot Password?</a>
                    </div>
    
                    <div class="login">
                       
                        <button type="submit" class="login-btn"><strong>Login</strong></button>
                    </div>
    
                    <div class="link">
                        <p class="login-link">Don't Have an Account Yet? <a href="#">Create Your Account</a></p>
                    </div>
                </div>
            </form>
        </div>

        <div class="right-section">
            <div class="content">
                <img src="/login&create_account_admin_community/communities/images/Rectangle 1012.png" alt="">
            </div>
            <h1>Welcome to DRRM</h1>
            <p>This is a place for dedicated volunteers, emergency responders, and community members to connect, coordinate, and respond to disasters efficiently. Stay informed, receive real-time alerts, and be part of a life-saving network.</p>
        </div>
    </div>
    
</body>
<script src="/login&create_account_admin_community/communities/js/create.js"></script>
</html>