<?php
require_once "../../config/database.php";

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function insertUser($email, $password, $phone, $city, $barangay, $gender) {
        try {
            $query = "INSERT INTO create_account_users (email_address, password, phone_number, city, barangay, gender) VALUES (:email, :password, :phone, :city, :barangay, :gender)";
            $stmt = $this->conn->prepare($query);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashed_password);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":city", $city);
            $stmt->bindParam(":barangay", $barangay);
            $stmt->bindParam(":gender", $gender);
            
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
