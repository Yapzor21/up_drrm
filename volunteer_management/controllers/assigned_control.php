<?php
require_once __DIR__ . '/../model/assigned.php';
require_once __DIR__ . '/../config/database.php';

// Handle form submissions
if (isset($_POST['assign_submit'])) {
    // Create controller instance
    $db = new Database();
    $conn = $db->connect();
    $controller = new TeamController($conn);
    
    // Set the action to assign if not already set
    if (!isset($_POST['action'])) {
        $_POST['action'] = 'assign';
    }
    
    // Handle the request
    $controller->handleRequest();
}

if (isset($_POST['update_team_submit'])) {
    // Create controller instance
    $db = new Database();
    $conn = $db->connect();
    $controller = new TeamController($conn);
    
    // Set the action to update if not already set
    if (!isset($_POST['action'])) {
        $_POST['action'] = 'update';
    }
    
    // Handle the request
    $controller->handleRequest();
}

class TeamController {
    private $model;
    private $message = "";

    public function __construct($conn = null) {
        if ($conn === null) {
            // Create database connection if not provided
            $db = new Database();
            $conn = $db->connect();
        }
        
        // Create model with connection
        $this->model = new TeamModel($conn);
    }
    
    public function getMessage() {
        return $this->message;
    }
    
    public function handleRequest() {
        $action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

        switch($action) {
            case 'assign':
                $this->assignTeam();
                break;
            case 'update':
                $this->updateTeamAssignment();
                break;
            default:
                // Default action or view all team assignments
                return $this->model->getAllTeamAssignments();
        }
    }
    
    private function assignTeam() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $reportId = $_POST['report_id'];
            $timeStarted = $_POST['timeStarted'];
            $assignedTeam = ucwords($_POST['assignedTeam']);
            
            // Don't pass the disaster type to the model
            if ($this->model->assignTeam($reportId, $timeStarted, $assignedTeam)) {
                $this->message = "Team assigned successfully";
                header("Location: ../views/admin/main_admin.php");
                exit();
            } else {
                $this->message = "Error assigning team";
            }
        }
    }
    
    private function updateTeamAssignment() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get data from form
            $reportId = $_POST['report_id'];
            $timeStarted = $_POST['timeStarted'];
            $assignedTeam = ucwords($_POST['assignedTeam']);
            
            // Don't pass the disaster type to the model
            if ($this->model->updateTeamAssignment($reportId, $timeStarted, $assignedTeam)) {
                $this->message = "Team assignment updated successfully";
                header("Location: ../views/admin/main_admin.php");
                exit();
            } else {
                $this->message = "Error updating team assignment";
            }
        }
    }
    
    public function getTeamAssignment($reportId) {
        return $this->model->getTeamAssignment($reportId);
    }
}
?>
