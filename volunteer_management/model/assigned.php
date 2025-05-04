<?php
class Assignment {
    private $conn;
    private $table = 'assignment';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createAssignment($reportId, $teamId, $timeStarted) {
        $query = "INSERT INTO " . $this->table . " 
                  (report_id, team_id, time_started, date_assigned) 
                  VALUES (:reportId, :teamId, :timeStarted, CURRENT_TIMESTAMP)";
        
        $stmt = $this->conn->prepare($query);
        
        // Clean data
        $reportId = htmlspecialchars(strip_tags($reportId));
        $teamId = htmlspecialchars(strip_tags($teamId));
        $timeStarted = htmlspecialchars(strip_tags($timeStarted));
        
        // Bind parameters
        $stmt->bindParam(':reportId', $reportId);
        $stmt->bindParam(':teamId', $teamId);
        $stmt->bindParam(':timeStarted', $timeStarted);
        
        // Execute query
        return $stmt->execute();
    }

    public function getAssignmentsByReportId($reportId) {
        $query = "SELECT a.*, t.name as team_name 
                  FROM " . $this->table . " a 
                  JOIN team t ON a.team_id = t.id 
                  WHERE a.report_id = :reportId";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':reportId', $reportId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteAssignment($assignmentId) {
        $query = "DELETE FROM " . $this->table . " WHERE assignment_id = :assignmentId";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':assignmentId', $assignmentId);
        
        return $stmt->execute();
    }
}
?>