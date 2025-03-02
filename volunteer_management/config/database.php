<?php
class Database {
    private $host = "localhost";
    private $db_name = "s2300587_drrm";
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
    public function testConnection() {
        if ($this->connect()) {
            echo "Connection successful!";
        } else {
            echo "Connection failed!";
        }
    }
    
}
?>
