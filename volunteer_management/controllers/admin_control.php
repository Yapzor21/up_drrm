<?php
session_start();


require_once __DIR__ . '/../model/admin.php';


$admin_id = $_POST['admin_id'];
$password = $_POST['password'];

$adminModel = new AdminModel();
$admin = $adminModel->getAdminById($admin_id);

if ($admin) {
    // Verify the password
    if (password_verify($password, $admin['password'])) {
     
        $_SESSION['admin_id'] = $admin['admin_id'];
        header("Location: ../views/admin/main_dashboard.php");
        exit();
    } else {
      
        $_SESSION['error'] = "Invalid Password";
        header("Location: ../index.php");
        exit();
    }
} else {
 
    $_SESSION['error'] = "Admin ID not found.";
    header("Location: ../index.php"); 
    exit();
}
?>