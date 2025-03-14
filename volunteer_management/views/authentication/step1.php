<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['middle_name'] = $_POST['middle_name'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['dob'] = $_POST['Dob'];
    header("location: step2.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/authentication/step1.css">
    <title>Step 1</title>
</head>
<body>
<div class="wrapper">
        <div class="container">
            <div class="logo">
                <img src="../../assets\images\Frame 1 (1).svg" alt="">
            </div>
            <h1>WELCOME!</h1>
            <p class="subtitle">Please Fill Out The Information</p>
            <input type="hidden" name="step" value="1">
            <form id="registrationForm" method="post" action="">
                <h2 class="section-title">Personal Information</h2>

                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="first_name" required>
                </div>

                <div class="form-group">
                    <label for="middleName">Middle Name</label>
                    <input type="text" id="middleName" name="middle_name" required>
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="last_name" required>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="Dob" required>
                </div>


                
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