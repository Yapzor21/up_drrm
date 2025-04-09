<?php
require_once __DIR__ . '/../model/user.php'; // Correct path for the model

class UserController {
    private $userModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new UserModel();
    }

    // Registration Method
    public function registerUser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $step = $_POST['step'] ?? '';
    
            if ($step == "1") {
                // Handle Step 1 data
                $_SESSION['first_name'] = $_POST['first_name'];
                $_SESSION['middle_name'] = $_POST['middle_name'];
                $_SESSION['last_name'] = $_POST['last_name'];
                $_SESSION['dob'] = $_POST['Dob'];
                header("Location: ../views/authentication/step2.php");
                exit();
            } elseif ($step == "2") {
                // Handle Step 2 data
                $email = $_POST['email_address'];

                // Check for duplicate email
                if ($this->userModel->isEmailExist($email)) {
                    $_SESSION['flash_error'] = "The email address is already registered. Please use a different email.";
                    header("Location: ../views/authentication/step2.php");
                    exit();
                }

                // Save Step 2 data to session
                $_SESSION['email_address'] = $email;
                $_SESSION['password'] = $_POST['password'];
    
                // Redirect to Step 3
                header("Location: ../views/authentication/step3.php");
                exit();
            } elseif ($step == "3") {
                // Handle Step 3 data
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
                    // Insertion failed
                    echo "Error inserting user data.";
                }
            }
        }
    }

    // Login Method
    public function loginUser() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email_address'];
            $password = $_POST['password'];

            // Check if the user exists and verify password
            $user = $this->userModel->getUserByEmail($email);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // Store user session
                    $_SESSION['user'] = $user;
                    header("Location: ../views/user/community_dashboard.php"); // Redirect to the dashboard
                    exit();
                } else {
                    $_SESSION['flash_error'] = "Invalid password.";
                }
            } else {
                $_SESSION['flash_error'] = "Invalid email.";
            }

            header("Location: ../views/authentication/login_user.php"); // Redirect back to login page
            exit();
        }
    }
}

// Instantiate and execute based on the request action
$controller = new UserController();
if (isset($_POST['action']) && $_POST['action'] == 'login') {
    $controller->loginUser();
} else {
    $controller->registerUser(); // Default action is to register the user
}
?>