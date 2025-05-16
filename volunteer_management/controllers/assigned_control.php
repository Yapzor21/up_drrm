<?php
require_once __DIR__ . '/../model/assigned.php';
require_once __DIR__ . '/../model/teams.php';
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->connect();

$assignment = new Assignment($db);
$team = new Team($db);

// Handle form submission
if (isset($_POST['assign_submit'])) {
    // Get form data
    $reportId = $_POST['report_id'];
    $timeStarted = $_POST['timeStarted'];
    
    // Format the time_started as a datetime
    $timeStarted = date('Y-m-d') . ' ' . $timeStarted . ':00';
    
    // Check which teams were selected
    $selectedTeams = [];
    
    if (isset($_POST['medical'])) {
        $medicalTeam = $team->getTeamByName('medical');
        if ($medicalTeam) {
            $selectedTeams[] = $medicalTeam['id'];
        }
    }
    
    if (isset($_POST['rescue'])) {
        $rescueTeam = $team->getTeamByName('rescue');
        if ($rescueTeam) {
            $selectedTeams[] = $rescueTeam['id'];
        }
    }
    
    if (isset($_POST['logistics'])) {
        $logisticsTeam = $team->getTeamByName('logistics');
        if ($logisticsTeam) {
            $selectedTeams[] = $logisticsTeam['id'];
        }
    }
    
    if (isset($_POST['fire'])) {
        $fireTeam = $team->getTeamByName('fire');
        if ($fireTeam) {
            $selectedTeams[] = $fireTeam['id'];
        }
    }
    
    // Create assignments for each selected team
    $success = true;
    foreach ($selectedTeams as $teamId) {
        // Check if this team is already assigned to this report
        if (!$assignment->isTeamAssignedToReport($reportId, $teamId)) {
            $result = $assignment->createAssignment($reportId, $teamId, $timeStarted);
            if (!$result) {
                $success = false;
            }
        }
    }
    
    if ($success && !empty($selectedTeams)) {
        // Redirect with success message AND report_id
        header("Location: ../views/admin/main_admin.php?success=assigned&report_id=" . $reportId);
        exit();
    } else {
        // Redirect with error message
        header("Location: ../views/admin/main_admin.php?error=assignment_failed&report_id=" . $reportId);
        exit();
    }
}
?>