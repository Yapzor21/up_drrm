Try AI directly in your favorite apps … Use Gemini to generate drafts and refine content, plus get Gemini Advanced with access to Google’s next-gen AI for ₱1,100.00 ₱0 for 1 month
<?php
session_start();

// Unset the user session variable
unset($_SESSION['user']);

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ../views/authentication/login_user.php");
exit();
?>