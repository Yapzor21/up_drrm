<?php
require_once __DIR__ . '/../model/assigned.php';
require_once __DIR__ . '/../model/teams.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/teamassignment.php';

// Create an instance of the TeamAssignmentController
$teamAssignmentController = new TeamAssignmentController();

// Handle form submission
if (isset($_POST['assign_submit'])) {
    // Get form data
    $reportId = $_POST['report_id'];
    $timeStarted = $_POST['timeStarted'];
    
    // Format the time_started as a datetime
    $timeStarted = date('Y-m-d') . ' ' . $timeStarted . ':00';
    
    // Get all available teams
    $allTeams = $teamAssignmentController->getAllTeams();
    $selectedTeams = [];
    
    // Check which teams were selected
    foreach ($allTeams as $teamItem) {
        $teamName = strtolower($teamItem['name']);
        if (isset($_POST[$teamName])) {
            $selectedTeams[] = $teamItem['id'];
        }
    }
    
    // Check if this is an update operation
    $isUpdate = isset($_POST['is_update']) || isset($_POST['update_team_id']) || 
                strpos($_SERVER['HTTP_REFERER'], 'updateTeamModal') !== false;
    
    $success = false;
    
    if ($isUpdate) {
        // Use the update method for updates - this will handle removing unchecked teams
        $success = $teamAssignmentController->updateAssignments($reportId, $selectedTeams, $timeStarted);
    } else {
        // For new assignments, create each one individually
        $success = true;
        foreach ($selectedTeams as $teamId) {
            // Check if this team is already assigned to this report
            if (!$teamAssignmentController->isTeamAssignedToReport($reportId, $teamId)) {
                $result = $teamAssignmentController->createAssignment($reportId, $teamId, $timeStarted);
                if (!$result) {
                    $success = false;
                }
            }
        }
    }
    
    if ($success) {
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
