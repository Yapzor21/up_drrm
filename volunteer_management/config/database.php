
<?php
/* mark database connection ( DO NOT REMOVE !!!! )
  private $host = "localhost";
    private $db_name = "s2300587_drrm";
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

   /* function connectDB() {
        $servername = "localhost";
        $username = "root";
        $password = "group1*";
        $dbname = "";
        
        $conn = new mysqli($servername, $username, $password,  $dbname);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        return $conn;
    }*/

}


// akon ni local host na database ( isli lang ang name sang database) simo nga part para mag work simo  
/*
$servername = "localhost:3306";
$username = "s2300587_new"; 
$password = "group1*"; 
$dbname = "s2300587_new"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
*/
?>