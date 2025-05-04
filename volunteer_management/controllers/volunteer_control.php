<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/super_admin.php';


class VolunteerTeamsController{
    private $employee;
    
    public function __construct()
    {
        $database = new Database();
        $pdo = $database->connect();
        $this->employee = new Employee($pdo);
    }
    
    public function getVolunteersByTeam()
    {
        try {
            // Get all volunteers grouped by team
            $volunteers = $this->employee->getVolunteersByTeam();
            
            // Group volunteers by team for easier display
            $teamVolunteers = [];
            foreach ($volunteers as $volunteer) {
                $teamName = $volunteer['team_name'] ?? 'Unassigned';
                if (!isset($teamVolunteers[$teamName])) {
                    $teamVolunteers[$teamName] = [];
                }
                $teamVolunteers[$teamName][] = $volunteer;
            }
            
            return $teamVolunteers;
        } catch (Exception $e) {
            // Log error and return empty array
            error_log("Error getting volunteers by team: " . $e->getMessage());
            return [];
        }
    }
    
    public function getAllTeams() {
        try {
            return $this->employee->getAllTeams();
        } catch (Exception $e) {
            error_log("Error getting teams: " . $e->getMessage());
            return [];
        }
    }

    
}

?>