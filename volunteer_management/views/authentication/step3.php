<?php
session_start();
// If the form in step3.php is submitted, handle the data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Save step3.php data to the session
    $_SESSION['gender'] = $_POST['gender'];

    // Final Check: Ensure all required session variables are set
    if (!isset($_SESSION['gender'])) {
        die("Missing required session data. Please complete all fields.");
    }

    // Load config.php and controller
    require_once __DIR__ . '/../../config/config.php';
    require_once __DIR__ . '/../../controllers/user.php';

    $controller = new UserController();
    $success = $controller->registerUser();

    if ($success) {
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        echo "Error in registration. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 3</title>
    <link rel="stylesheet" href="../../assets/css/authentication/step3.css">
    <!-- Added reCAPTCHA script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <img src="../../assets/images/Frame 1 (1).svg" alt="">
            <h1>WELCOME!</h1>
            <p class="subtitle">Please Fill Out The Information</p>
            
            <form id="signupForm" method="post" action="step3.php">
                <input type="hidden" name="step" value="3">
                <div class="form-section">
                    <h2>Personal Information</h2>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="gender" value="male" required>
                            Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="female">
                            Female
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <div class="phone-input">
                        <div class="country-code">
                            <img src="../../assets\images\Flag_of_the_Philippines.svg (1).png" alt="">
                            <span>+63</span>
                        </div>
                        <input type="tel" id="phone" pattern="^9[0-9]{9}$" name="phone_number" required>

                    </div>
                </div>
    
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" value="Bacolod City" name="city" required>
                </div>
    
                <div class="form-group">
                    <label for="barangay">Barangay</label>
                    <select id="barangay" name="barangay" required>
                        <option value="" disabled selected>Select Barangay</option>
                        <!-- Barangays will be populated via JavaScript -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="community_role">Community Role</label>
                    <select name="community_role" required>
                        <option value="" disabled selected></option>
                        <option value="resident">Tambay</option>
                        <option value="volunteer">Rescue</option>
                        <option value="coordinator">Medical</option>
                    </select>
                </div>
                <input type="text" name="skills_interest" placeholder="Skills/Interest" required>   
    
                <div class="checkbox-group">
                    <input type="checkbox" id="messages" required>
                    <label for="messages">I agree to receive messages about related news and emergency notifications</label>
                </div>
    
                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">By creating an account, I agree to the Terms and Conditions and Privacy Policy of DRRM</label>
                </div>

                <!-- Added reCAPTCHA-->
                <div class="form-group" style="margin: 20px 0;">
                    <div class="g-recaptcha" data-sitekey="6LeCluwrAAAAAC53xNdrNzAmWnTdj3NWRXW9f12v"></div>
                </div>
    
                <div class="submit">
                    <button type="submit" name="submit" class="submit-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25">
                            <path style="fill:#ffffff" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="right-section">
            <div class="content">
                <img src="../../assets/images/Rectangle 1012.png" alt="">
            </div>
            <h1>Welcome to DRRM</h1>
            <p>This is a place for dedicated volunteers, emergency responders, and community members to connect, coordinate, and respond to disasters efficiently. Stay informed, receive real-time alerts, and be part of a life-saving network.</p>
        </div>
    </div>
</body>
<script src="../../assets\js\create_account.js"></script>
</html>
