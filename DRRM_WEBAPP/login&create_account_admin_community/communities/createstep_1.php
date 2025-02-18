<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>step 1</title>
    <link rel="stylesheet" href="/login&create_account_admin_community/communities/createstep_1.html">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <img src="/login&create_account_admin_community/communities/images/Frame 1.svg" alt="">
            <h1>WELCOME!</h1>
            <p class="subtitle">Please Fill Out The Information</p>
    
            <h2>Personal Information</h2>
            <form id="createAccountForm">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" required>
                    </div>
                </div>
    
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
    
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="confirmPassword" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
    
                <div class="submit">
                    <button type="submit" class="submit-btn"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path style="fill:#ffffff" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/></svg></button>
                </div>
                <p class="login-link">Already Have an Account? <a href="#">Log In Here</a></p>
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