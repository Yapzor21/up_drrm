<?php
require_once __DIR__ . '/../model/assigned.php';
require_once __DIR__ . '/../model/teams.php';
require_once __DIR__ . '/../config/database.php';

class TeamAssignmentController {
    private $assignment;
    private $team;
    
    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->assignment = new Assignment($db);
        $this->team = new Team($db);
    }
    
    public function getAllTeams() {
        return $this->team->getAllTeams();
    }
    
    public function getAssignmentsByReportId($reportId) {
        return $this->assignment->getAssignmentsByReportId($reportId);
    }
    
    public function getAssignmentDetailsForReport($reportId) {
        return $this->assignment->getAssignmentDetailsForReport($reportId);
    }
    
    public function getAllAssignments() {
        return $this->assignment->getAllAssignments();
    }
    
    public function isTeamAssignedToReport($reportId, $teamId) {
        return $this->assignment->isTeamAssignedToReport($reportId, $teamId);
    }
    
    public function createAssignment($reportId, $teamId, $timeStarted) {
        return $this->assignment->createAssignment($reportId, $teamId, $timeStarted);
    }
    
    public function updateAssignments($reportId, $selectedTeams, $timeStarted) {
        return $this->assignment->updateAssignments($reportId, $selectedTeams, $timeStarted);
    }
    
    public function deleteAssignment($assignmentId) {
        return $this->assignment->deleteAssignment($assignmentId);
    }
}
?>
