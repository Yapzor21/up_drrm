
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>step 2</title>
    <link rel="stylesheet" href="../../assets/css/authentication/step2.css">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="logo">
                <img src="../../assets\images\Frame 1 (1).svg" alt="">
            </div>
            <h1>WELCOME!</h1>
           
            <p class="subtitle">Please Fill Out The Information</p>
            <form id="registrationForm" method="post" action="../../controllers/user.php">
            <input type="hidden" name="step" value="2">
                <h2 class="section-title">Personal Information</h2>
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email_address" required>
                    </div>
                </div>
    
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
    
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="confirmPassword" name="confirmPassword" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <?php
            if (isset($_SESSION['flash_error'])) {
                echo "<div class='flash-error'>" . $_SESSION['flash_error'] . "</div>";
                unset($_SESSION['flash_error']); // Clear the flash message after displaying it
            }
            ?>
                <div class="submit">

        <button type="submit" class="submit-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25">
                <path style="fill:#ffffff" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/>
            </svg>
        </button>
</div>

        </form>
        </div>
        <div class="right-section">
            <div class="content">
                <img src="../../assets\images\Rectangle 1012.png" alt="">
            </div>
            <h1>Welcome to DRRM</h1>
            <p>This is a place for dedicated volunteers, emergency responders, and community members to connect, coordinate, and respond to disasters efficiently. Stay informed, receive real-time alerts, and be part of a life-saving network.</p>
        </div>
    </div>
   
</body>
<script src="../../assets/js/create_account.js"></script> 
</html>