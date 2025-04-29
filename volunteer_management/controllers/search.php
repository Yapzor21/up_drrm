<?php
require_once __DIR__ . '../model/search.php'; // Include the model for search functionality

class SearchController {

    private $searchModel;

    public function __construct($pdo) {
        $this->searchModel = new searchModel($pdo);
    }

    public function searchAction($query) {
        return $this->searchModel->search($query);
    }

    public function closeConnection() {
        $this->searchModel->close();
    }
}
?>

