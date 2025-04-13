<?php
require_once __DIR__ . '/../config/config.php';  // Correct path to config
require_once '../config/database.php'; // Correct path to Database




class adminModel{
private $conn;

public function __construct(){
    $database = new Database();
    $this->conn = $database->connect();
}

public function getAdminById($admin_id)  {  
     $query = "SELECT * FROM admin WHERE admin_id = :admin_id";
     $stmt = $this->conn->prepare($query);
     $stmt->bindParam(":admin_id", $admin_id);
     $stmt->execute();

    if ($stmt -> rowCount() > 0){
                return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
                return false;
            
    }
}
}
?>