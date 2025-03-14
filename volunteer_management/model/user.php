<?php


// Correct path:
require_once __DIR__ . '/../config/config.php';  // Go up one level and access the config folder
require_once __DIR__ . '/../config/Database.php';



class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function insertUser($email, $password, $phone, $city, $barangay, $gender, $community_role, $skills_interest, $first_name, $middle_name, $last_name, $dob) {
        try {
            // Check if the email already exists
            if ($this->isEmailExist($email)) {
                return "duplicate_email"; // Return a specific error code for duplicate email
            }
    
            // If the email does not exist, proceed with insertion
            $query = "INSERT INTO users (
                email_address,
                password,
                phone_number,
                city,
                barangay,
                gender,
                community_role,
                skills_interest, 
                firstName,
                middleName,
                lastName,
                dob
            ) VALUES (
                :email,
                :password, 
                :phone, 
                :city, 
                :barangay, 
                :gender,
                :community_role,
                :skills_interest,
                :first_name,
                :middle_name,
                :last_name,
                :dob
            )";
    
            $stmt = $this->conn->prepare($query);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashed_password);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":city", $city);
            $stmt->bindParam(":barangay", $barangay);
            $stmt->bindParam(":gender", $gender);
            $stmt->bindParam(":community_role", $community_role);
            $stmt->bindParam(":skills_interest", $skills_interest);
            $stmt->bindParam(":first_name", $first_name);
            $stmt->bindParam(":middle_name", $middle_name);
            $stmt->bindParam(":last_name", $last_name);
            $stmt->bindParam(":dob", $dob);
    
            if ($stmt->execute()) {
                return true; // User inserted successfully
            } else {
                return false; // Insertion failed
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function isEmailExist($email){
        try{
            $query = "SELECT * FROM users WHERE email_address = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            //If a row is found, the email already exists
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function login($email, $password) {
    try {
        $query = "SELECT * FROM users WHERE email_address = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        // Fetch the user
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            return $user;
        } else {
            // Login failed
            return false;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

    public function userLogin(){
        if ($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['action']) && $_POST ['action'] == 'login'){
            $email = $_POST[email];
            $password = $_POST[password];

            $user = this -> userModel -> login($email, $password);
            
        if($user){
            $_SESSION['user'] = $user;
            header("location : ../views/dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header("location : ../views/login.php");
            exit();
        }
        }
    }
}
?>