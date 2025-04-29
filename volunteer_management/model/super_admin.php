<?php
class Employee
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createEmployee($hashed_password, $role, $first_name, $middle_name, $last_name,$contact_num)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO employee (password, role, first_name, middle_name, last_name, contact_num) 
            VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$hashed_password, $role, $first_name, $middle_name, $last_name, $contact_num]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Database Error: " . $e->getMessage());
        }
    }
}
?>
