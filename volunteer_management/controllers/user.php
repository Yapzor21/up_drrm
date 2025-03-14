<?php
// Incorrect path: This is looking in the config folder for the model
// require_once BASE_PATH . 'config/model/user.php'; 

// Corrected path: This should reference the model directory directly in the root
require_once __DIR__ . '/../model/user.php'; // Go up one directory to access model/user.php



class UserController {
    private $userModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new UserModel();
    }


    public function registerUser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $step = $_POST['step'] ?? '';
    
            if ($step == "1") {
                // Handle step 1 data
                $_SESSION['first_name'] = $_POST['first_name'];
                $_SESSION['middle_name'] = $_POST['middle_name'];
                $_SESSION['last_name'] = $_POST['last_name'];
                $_SESSION['dob'] = $_POST['Dob'];
                header("Location: ../views/authentication/step2.php");
                exit();
            } elseif ($step == "2") {
                // Handle step 2 data
                $email = $_POST['email_address'];
    
                // Check for duplicate email
                if ($this->userModel->isEmailExist($email)) {
                    // Set flash message for duplicate email
                    $_SESSION['flash_error'] = "The email address is already registered. Please use a different email.";
                    header("Location: ../views/authentication/step2.php");
                    exit();
                }
    
                // Save step 2 data to session
                $_SESSION['email_address'] = $email;
                $_SESSION['password'] = $_POST['password'];
               
    
                // Redirect to step 3
                header("Location: ../views/authentication/step3.php");
                exit();
            } elseif ($step == "3") {
                // Handle step 3 data
                $_SESSION['gender'] = $_POST['gender'];
                $_SESSION['phone'] = $_POST['phone_number'];
                $_SESSION['city'] = $_POST['city'];
                $_SESSION['barangay'] = $_POST['barangay'];
                $_SESSION['community_role'] = $_POST['community_role'];
                $_SESSION['skills_interest'] = $_POST['skills_interest'];
    
                // Insert user data into the database
                $inserted = $this->userModel->insertUser(
                    $_SESSION['email_address'],
                    $_SESSION['password'],
                    $_SESSION['phone'],
                    $_SESSION['city'],
                    $_SESSION['barangay'],
                    $_SESSION['gender'],
                    $_SESSION['community_role'],
                    $_SESSION['skills_interest'],
                    $_SESSION['first_name'],
                    $_SESSION['middle_name'],
                    $_SESSION['last_name'],
                    $_SESSION['dob']
                );
    
                if ($inserted) {
                    // Registration successful
                    session_destroy();
                    header("Location: ../../views/authentication/login_user.php");
                    exit();
                } else {
                    // Other errors
                    echo "Error inserting user data.";
                }
            }
        }
    }

 
}

$controller = new UserController();
$controller->registerUser();
?>