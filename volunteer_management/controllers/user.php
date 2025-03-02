<?php
require_once "../../model/user.php";

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
                $_SESSION['email'] = $_POST['email_address'];
                $_SESSION['password'] = $_POST['password'];
                header("Location: ../views/authentication/step2.php");
                exit();
            } elseif ($step == "2") {
                $_SESSION['phone'] = $_POST['phone_number'];
                $_SESSION['city'] = $_POST['city'];
                $_SESSION['barangay'] = $_POST['barangay'];
                header("Location: ../views/authentication/step3.php");
                exit();
            } elseif ($step == "3") {
                $email = $_SESSION['email'] ?? '';
                $password = $_SESSION['password'] ?? '';
                $phone = $_SESSION['phone'] ?? '';
                $city = $_SESSION['city'] ?? '';
                $barangay = $_SESSION['barangay'] ?? '';
                $gender = $_POST['gender'] ?? '';

                $inserted = $this->userModel->insertUser($email, $password, $phone, $city, $barangay, $gender);

                if ($inserted) {
                    session_destroy();
                    header("Location: ../views/authentication/success.php");
                    exit();
                } else {
                    echo "Error inserting user data.";
                }
            }
        }
    }
}

$controller = new UserController();
$controller->registerUser();
?>
