<?php
require_once __DIR__ . '/../model/report.php';
require_once __DIR__ . '/../config/database.php';

if (isset($_POST['submit_report'])) {
    // Create controller instance
    $controller = new UserReportController($conn);
    if (!isset($_POST['action'])) {
        $_POST['action'] = 'create';
    }
    
    // Handle the request
    $controller->handleRequest();
}

if (isset($_POST['update_submit'])) {
    // Create controller instance
    $controller = new UserReportController($conn);
    if (!isset($_POST['action'])) {
        $_POST['action'] = 'update';
    }
    
    // Handle the request
    $controller->handleRequest();
}

if (isset($_POST['delete'])) {
    // Create controller instance
    $controller = new UserReportController($conn);
    if (!isset($_POST['action'])) {
        $_POST['action'] = 'delete';
    }
    
    // Handle the request
    $controller->handleRequest();
}

class UserReportController {
    private $model;
    private $message = "";
    
    public function __construct($conn) {
        $this->model = new UserReportModel($conn);
    }

    public function getMessage() {
        return $this->message;
    }
    
    public function handleRequest() {
        $action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

        switch($action) {
            case 'create':
                $this->createReport();
                break;
            case 'update':
                $this->updateReport();
                break;
            case 'delete':
                $this->deleteReport();
                break;
            default:
                // Default action or view all reports
                return $this->model->getAllReports();
        }
    }
    
    private function createReport() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $disasterType = ucwords($_POST['disasterType']);
            $location = ucwords($_POST['location']);
            $reporter = ucwords($_POST['reporter']);
            $contact = ucwords($_POST['contact']);
            $description = ucwords($_POST['description']);
            
            if ($this->model->createReport($disasterType, $location, $reporter, $contact, $description)) {
                $this->message = "Report submitted successfully";
                header("Location: ../views/user/community_report.php");
                exit();
            } else {
                $this->message = "Error submitting report";
            }
        }
    }
    
    private function updateReport() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get data from form
            $id = $_POST['report_id'];
            $disasterType = ucwords($_POST['disasterType']);
            $location = ucwords($_POST['location']);
            $reporter = ucwords($_POST['reporter']);
            $contact = $_POST['contact'];
            $description = ucwords($_POST['description']);
            
            if ($this->model->updateReport($id, $disasterType, $location, $reporter, $contact, $description)) {
                $this->message = "Report updated successfully";
                header("Location: ../views/admin/main_admin.php");
                exit();
            } else {
                $this->message = "Error updating report";
            }
        }
    }
    
    private function deleteReport() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['report_id'];
            
            if ($this->model->deleteReport($id)) {
                $this->message = "Report deleted successfully";
                header("Location: ../views/admin/main_admin.php");
                exit();
            } else {
                $this->message = "Error deleting report";
            }
        }
    }
    
        // Method to get location data for pie chart
    public function getLocationChartData() {
        return $this->model->getLocationData();
    }
    
    // Method to get disaster type data for bar chart
    public function getDisasterTypeChartData() {
        return $this->model->getDisasterTypeData();
    }
    
    
}
?>

