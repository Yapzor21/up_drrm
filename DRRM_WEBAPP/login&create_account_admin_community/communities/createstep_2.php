<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>step 2</title>
    <link rel="stylesheet" href="/login&create_account_admin_community/communities/css/step2.css">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="logo">
                <img src="/login&create_account_admin_community/communities/images/Frame 1.svg" alt="">
            </div>
    
            <h1>WELCOME!</h1>
            <p class="subtitle">Please Fill Out The Information</p>
    
            <form id="registrationForm">
                <h2 class="section-title">Personal Information</h2>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <div class="phone-input">
                        <div class="country-code">
                            <img src="/login&create_account_admin_community/communities/images/640px-Flag_of_the_Philippines.svg.png" alt="ph" class="flag">
                            <span>+63</span>
                        </div>
                        <input type="tel" id="phone" pattern="[0-10]*" required>
                    </div>
                </div>
    
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" value="Bacolod City" required>
                </div>
    
                <div class="form-group">
                    <label for="barangay">Barangay</label>
                    <select id="barangay" required>
                        <option value="" disabled selected>Select Barangay</option>
                        <!-- Barangays will be populated via JavaScript -->
                    </select>
                </div>
    
                <div class="submit">
                    <button type="submit" class="submit-btn"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path style="fill:#ffffff" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/></svg></button>
                </div>
    
                <p class="login-link">
                    Already Have an Account? <a href="#">Log In Here</a>
                </p>
    
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