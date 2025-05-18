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

    public function getAssignmentDetailsForReport($reportId) {
        $query = "SELECT ur.Disaster_Type, ur.Location, ur.City, 
                         GROUP_CONCAT(DISTINCT t.name ORDER BY t.name SEPARATOR ', ') as team_names, 
                         MIN(a.time_started) as time_started, 
                         MAX(a.date_assigned) as date_assigned
                  FROM " . $this->table . " a 
                  JOIN user_report ur ON a.report_id = ur.Report_Id
                  JOIN team t ON a.team_id = t.id 
                  WHERE a.report_id = :reportId
                  GROUP BY ur.Disaster_Type, ur.Location, ur.City";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':reportId', $reportId);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAssignments() {
        $query = "SELECT a.report_id, ur.Disaster_Type, ur.Location, ur.City, 
                         GROUP_CONCAT(DISTINCT t.name ORDER BY t.name SEPARATOR ', ') as team_names,
                         MIN(a.time_started) as time_started, 
                         MAX(a.date_assigned) as date_assigned
                  FROM " . $this->table . " a 
                  JOIN user_report ur ON a.report_id = ur.Report_Id
                  JOIN team t ON a.team_id = t.id 
                  GROUP BY a.report_id, ur.Disaster_Type, ur.Location, ur.City
                  ORDER BY MAX(a.date_assigned) DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isTeamAssignedToReport($reportId, $teamId) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " 
                  WHERE report_id = :reportId AND team_id = :teamId";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':reportId', $reportId);
        $stmt->bindParam(':teamId', $teamId);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function deleteAssignment($assignmentId) {
        $query = "DELETE FROM " . $this->table . " WHERE assignment_id = :assignmentId";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':assignmentId', $assignmentId);
        
        return $stmt->execute();
    }
    
    // New method for updating team assignments
    public function updateAssignments($reportId, $selectedTeams, $timeStarted) {
        try {
            // Start transaction
            $this->conn->beginTransaction();
            
            // Get current assignments
            $currentAssignments = $this->getAssignmentsByReportId($reportId);
            $currentTeamIds = array_column($currentAssignments, 'team_id');
            
            // Teams to remove (in current but not in selected)
            $teamsToRemove = array_diff($currentTeamIds, $selectedTeams);
            
            // Teams to add (in selected but not in current)
            $teamsToAdd = array_diff($selectedTeams, $currentTeamIds);
            
            // Remove teams no longer selected
            foreach ($currentAssignments as $assignment) {
                if (in_array($assignment['team_id'], $teamsToRemove)) {
                    $this->deleteAssignment($assignment['assignment_id']);
                }
            }
            
            // Add newly selected teams
            foreach ($teamsToAdd as $teamId) {
                $this->createAssignment($reportId, $teamId, $timeStarted);
            }
            
            // Update time_started for existing assignments that remain
            if (!empty(array_intersect($currentTeamIds, $selectedTeams))) {
                $query = "UPDATE " . $this->table . " 
                          SET time_started = :timeStarted 
                          WHERE report_id = :reportId 
                          AND team_id IN (" . implode(',', array_intersect($currentTeamIds, $selectedTeams)) . ")";
                
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':timeStarted', $timeStarted);
                $stmt->bindParam(':reportId', $reportId);
                $stmt->execute();
            }
            
            // Commit transaction
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->conn->rollBack();
            return false;
        }
    }
}
?>