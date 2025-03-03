<?php
session_start();
require_once "../../model/user.php";
require_once "../../helpers/session.php";

class userController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Step 1: Store email and password
    public function process1() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['first_name'] = $_POST['first_name'];
            $_SESSION['middle_name'] = $_POST['middle_name'];
            $_SESSION['last_name'] = $_POST['last_name'];
            $_SESSION['Dob'] = $_POST['Dob'];
            header("location: ../../views/authentication/step2.php");
            exit();
        }
    }

    // Step 2: Store Address & Phone Number
    public function process2() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['email'] = $_POST['email_address'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['confirmPassword'] = $_POST['confirmPassword'];
            if ($_SESSION['password'] !== $_SESSION['confirmPassword']) {
                $_SESSION['error'] = "Passwords do not match!";
                return;
            }else{

            exit();
            }
        }
    }

    public function process3() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $_SESSION['phone_number'] = $_POST['phone_number'];
            $_SESSION['city'] = $_POST['city'];
            $_SESSION['barangay'] = $_POST['barangay'];
            $_SESSION['gender'] = $_POST['gender'];
            $_SESSION['community_role'] = $_POST['community_role'];
            $_SESSION['skills_interest'] = $_POST['skills_interest'];
            $success = $this->userModel->registerUser(
                $_SESSION['email'],
                $_SESSION['password'],
                $_SESSION['first_name'],
                $_SESSION['middle_name'],
                $_SESSION['last_name'],
                $_SESSION['Dob'],
                $_SESSION['phone_number'],
                $_SESSION['city'],
                $_SESSION['barangay'],
                $_SESSION['gender'],
                $_SESSION['community_role'],
                $_SESSION['skills_interest'],



            );
            if ($success) {
                // Destroy session data after successful registration
                session_unset();
                session_destroy();
                // Redirect to login page
                header("Location: ../../views/authentication/login_user.php");
                exit();
            } else {
                echo "Error in registration. Please try again.";
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $controller = new userController();
    if ($_POST['step'] == '1') {
        $controller->process1();
    } elseif ($_POST['step'] == '2') {
        $controller->process2();
    } elseif ($_POST['step'] == '3') {
        $controller->process3();
    }
}
?>