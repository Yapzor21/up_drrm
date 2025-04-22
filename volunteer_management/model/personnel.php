<?php

class Personnel {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getPersonnelByStatus($status) {
        $query = "SELECT * FROM personnel WHERE status = ? ORDER BY name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status, PDO::PARAM_STR);
        $stmt->execute();
        
        $personnel = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $personnel[] = $row;
        }
        
        return $personnel;
    }
    
    public function updateStatus($id, $status) {
        $query = "UPDATE personnel SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $status, PDO::PARAM_STR);
        $stmt->bindParam(2, $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    public function getAllPersonnel() {
        $query = "SELECT * FROM personnel ORDER BY name";
        $stmt = $this->conn->query($query);
        
        $personnel = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $personnel[] = $row;
        }
        
        return $personnel;
    }
}
?>
