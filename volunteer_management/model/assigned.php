<?php
require_once __DIR__ . '/../config/database.php';

class TeamModel {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function assignTeam($reportId, $timeStarted, $assignedTeam) {
        // First check if the report exists
        $checkStmt = $this->pdo->prepare("SELECT Report_Id FROM user_report WHERE Report_Id = ?");
        $checkStmt->execute([$reportId]);
        
        if (!$checkStmt->fetch()) {
            return false; // Report doesn't exist
        }
        
        // Remove Disaster_Type from the update
        $sql = "UPDATE user_report SET 
                time_started = ?, 
                assigned_team = ?
                WHERE Report_Id = ?";
                
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$timeStarted, $assignedTeam, $reportId]);
    }
    
    public function updateTeamAssignment($reportId, $timeStarted, $assignedTeam) {
        // Remove Disaster_Type from the update
        $sql = "UPDATE user_report SET 
                time_started = ?, 
                assigned_team = ?
                WHERE Report_Id = ?";
                
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$timeStarted, $assignedTeam, $reportId]);
    }
    
    public function getTeamAssignment($reportId) {
        $stmt = $this->pdo->prepare("SELECT Report_Id, Disaster_Type, time_started, assigned_team FROM user_report WHERE Report_Id = ?");
        $stmt->execute([$reportId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllTeamAssignments() {
        $stmt = $this->pdo->query("SELECT Report_Id, Disaster_Type, time_started, Date_Reported, assigned_team, Location, City 
        FROM user_report WHERE assigned_team IS NOT NULL ORDER BY Report_Id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>