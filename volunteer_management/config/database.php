
<?php
/* mark database connection ( DO NOT REMOVE !!!! )
  private $host = "localhost";
    private $db_name = "s2300587_drrm";
    private $username = "root";
    private $password = "";
    public $conn;

    adrian database connection ( DO NOT REMOVE !!!! )
    private $host = "localhost";
    private $db_name = "drrm";
    private $username = "root";
    private $password = "";
    public $conn;


---------------------------------------


       HELIO DATABASE CONNECTION

    private $host = "localhost";
    private $db_name = "s2300587_new";
    private $username = "s2300587_new";
    private $password = "group1*";
    public $conn;

   
*/

class Database {
    private $host = "localhost";
    private $db_name = "drrm";
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