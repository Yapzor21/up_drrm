<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/personnel.php';

class PersonnelController {
    private $personnel;
    
    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $this->personnel = new Personnel($db);
    }
    
    public function getPersonnelByStatus($status) {
        return $this->personnel->getPersonnelByStatus($status);
    }
    
    public function updateStatus($id, $status) {
        return $this->personnel->updateStatus($id, $status);
    }
    
    public function getAllPersonnel() {
        return $this->personnel->getAllPersonnel();
    }
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new PersonnelController();
    
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'updateStatus' && isset($_POST['id']) && isset($_POST['status'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            
            $result = $controller->updateStatus($id, $status);
            
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'Status updated successfully' : 'Failed to update status'
            ]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new PersonnelController();
    
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        
        if ($action === 'getByStatus' && isset($_GET['status'])) {
            $status = $_GET['status'];
            $personnel = $controller->getPersonnelByStatus($status);
            
            echo json_encode($personnel);
        } elseif ($action === 'getAll') {
            $personnel = $controller->getAllPersonnel();
            
            echo json_encode($personnel);
        }
    }
}
?>
