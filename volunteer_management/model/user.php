<?php
require_once "../../config/database.php";

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function registerUser($email, $password, $first_name, $middle_name, $last_name,$dob, $phone, $city, $barangay, $gender, $community_role, $skills_interest) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
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
            :firstName,
            :middleName,
            :lastName,
            :dob
        )";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":firstName", $first_name);
        $stmt->bindParam(":middleName", $middle_name);
        $stmt->bindParam(":lastName", $last_name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":city", $city);
        $stmt->bindParam(":barangay", $barangay);
        $stmt->bindParam(":gender", $gender);
        $stmt->bindParam(":community_role", $community_role);
        $stmt->bindParam(":skills_interest", $skills_interest);
        $stmt->bindParam(":dob", $dob);

        return $stmt->execute();
    }
}
?>
