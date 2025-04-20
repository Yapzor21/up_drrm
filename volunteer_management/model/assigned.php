
<?php
require_once __DIR__ . '/../config/database.php';

class TeamModel {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function assignTeam($reportId, $disasterType, $timeStarted, $assignedTeam) {
        // First check if the report exists
        $checkStmt = $this->pdo->prepare("SELECT Report_Id FROM user_report WHERE Report_Id = ?");
        $checkStmt->execute([$reportId]);
        
        if (!$checkStmt->fetch()) {
            return false; // Report doesn't exist
        }
        
        // Update the report with team assignment information
        // Removed the status column from the update statement
        $sql = "UPDATE user_report SET 
                Disaster_Type = ?, 
                time_started = ?, 
                assigned_team = ?
                WHERE Report_Id = ?";
                
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$disasterType, $timeStarted, $assignedTeam, $reportId]);
    }
    
    public function updateTeamAssignment($reportId, $disasterType, $timeStarted, $assignedTeam) {
        $sql = "UPDATE user_report SET 
                Disaster_Type = ?, 
                time_started = ?, 
                assigned_team = ?
                WHERE Report_Id = ?";
                
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$disasterType, $timeStarted, $assignedTeam, $reportId]);
    }
    
    public function getTeamAssignment($reportId) {
        $stmt = $this->pdo->prepare("SELECT Report_Id, Disaster_Type, time_started, assigned_team FROM user_report WHERE Report_Id = ?");
        $stmt->execute([$reportId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getAllTeamAssignments() {
        $stmt = $this->pdo->query("SELECT Report_Id, Disaster_Type, time_started, Date_Reported, assigned_team, Location, City FROM user_report WHERE assigned_team IS NOT NULL ORDER BY Report_Id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>