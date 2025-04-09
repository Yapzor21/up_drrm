<?php
session_start();

// Include the model
require_once __DIR__ . '/../model/admin.php';

// Get form data
$admin_id = $_POST['admin_id'];
$password = $_POST['password'];

// Create an instance of the AdminModel
$adminModel = new AdminModel();

// Fetch admin data from the model
$admin = $adminModel->getAdminById($admin_id);

if ($admin) {
    // Verify the password
    if (password_verify($password, $admin['password'])) {
        // Password is correct, log in the admin
        $_SESSION['admin_id'] = $admin['admin_id'];
        header("Location: ../views/admin/main_dashboard.php"); // Redirect to the dashboard
        exit();
    } else {
        // Invalid password
        $_SESSION['error'] = "Invalid Password";
        header("Location: ../index.php");
        exit();
    }
} else {
    // Admin ID not found
    $_SESSION['error'] = "Admin ID not found.";
    header("Location: ../index.php"); // Redirect back to the login page
    exit();
}
?>