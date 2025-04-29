<?php
session_start();
include '../config/database.php';
include '../model/UserModel.php';
include '../model/AdminModel.php';

$database = new Database();
$conn = $database->connect(); 

$userModel = new UserModel($conn); 
$adminModel = new AdminModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_id = $_POST['login_id'];
    $password = $_POST['password'];

    // Check if it's a user (email)
    if (filter_var($login_id, FILTER_VALIDATE_EMAIL)) {
        $isValid = $userModel->verifyUser($login_id, $password);
        if ($isValid) {
            $_SESSION['user_email'] = $login_id;
            header("Location: ../views/user/community_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid user credentials.";
            header("Location: ../index.php");
            exit();
        }
    } else {
        // It's an admin
        $adminData = $adminModel->verifyAdmin($login_id, $password);
        if ($adminData) {
            $_SESSION['admin_id'] = $adminData['admin_id'];
            $_SESSION['admin_role'] = $adminData['role'];

            // Role-based redirection
            switch ($adminData['role']) {
                case 'admin':
                    header("Location: ../views/admin/main_dashboard.php");
                    break;
                case 'volunteer':
                    header("Location: ../views/admin/volunteer_portal.php");
                    break;
                case 'super_admin':
                    header("Location: ../views/admin/super_admin.php");
                    break;
                default:
                    $_SESSION['error'] = "Unrecognized role.";
                    header("Location: ../index.php");
                    exit();
            }
            exit();
        } else {
            $_SESSION['error'] = "Invalid admin credentials.";
            header("Location: ../index.php");
            exit();
        }
    }
}
?>
