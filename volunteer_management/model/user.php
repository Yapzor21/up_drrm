<?php
require_once __DIR__ . '/../config/config.php'; // Correct path for the config
require_once __DIR__ . '/../config/database.php';

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Insert user data into the database
    public function insertUser($email, $password, $phone, $city, $barangay, $gender, $community_role, $skills_interest, $first_name, $middle_name, $last_name, $dob) {
        try {
            // Check if the email already exists
            if ($this->isEmailExist($email)) {
                return "duplicate_email"; // Return a specific error for duplicate email
            }
    
            // If email does not exist, proceed with insertion
            $query = "INSERT INTO users (
                email_address, password, phone_number, city, barangay, gender, community_role, skills_interest, 
                firstName, middleName, lastName, dob
            ) VALUES (
                :email, :password, :phone, :city, :barangay, :gender, :community_role, :skills_interest,
                :first_name, :middle_name, :last_name, :dob
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

    // Check if the email already exists in the database
    public function isEmailExist($email) {
        try {
            $query = "SELECT * FROM users WHERE email_address = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Get user details by email for login
    public function getUserByEmail($email) {
        try {
            $query = "SELECT * FROM users WHERE email_address = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>