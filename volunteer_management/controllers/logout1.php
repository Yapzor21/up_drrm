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