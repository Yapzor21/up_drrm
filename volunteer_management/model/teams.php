<?php
class Team {
    private $conn;
    private $table = 'team';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllTeams() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY name";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTeamByName($name) {
        $query = "SELECT * FROM " . $this->table . " WHERE name = :name";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $row : false;
    }

    public function getTeamById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row ? $row : false;
    }
}
?>