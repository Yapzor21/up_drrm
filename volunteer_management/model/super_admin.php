<?php
class Employee{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createEmployee($hashed_password, $role, $first_name, $middle_name, $last_name, $contact_num, $volunteerType) {
        try {
            $team_id = null;

            if ($role === 'volunteer' && !empty($volunteerType)) {
                $stmt = $this->pdo->prepare("SELECT id FROM team WHERE name = ?");
                $stmt->execute([$volunteerType]);
                $team = $stmt->fetch();
                if ($team) {
                    $team_id = $team['id'];
                }
            }

            $stmt = $this->pdo->prepare("INSERT INTO employee (password, role, first_name, middle_name, last_name, contact_num, volunteerType, team_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$hashed_password, $role, $first_name, $middle_name, $last_name, $contact_num, $volunteerType, $team_id]);

            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Database Error: " . $e->getMessage());
        }
    }

    public function getVolunteersByTeam(){
        try {
            $stmt = $this->pdo->query("
                SELECT e.admin_id, e.first_name, e.middle_name, e.last_name, t.name AS team_name
                FROM employee e
                JOIN team t ON e.team_id = t.id
                WHERE e.role = 'volunteer'
                ORDER BY t.name, e.last_name
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Database Error: " . $e->getMessage());
        }
    }
    
    public function getAllTeams()
    {
        try {
            $stmt = $this->pdo->query("SELECT id, name FROM team ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Database Error: " . $e->getMessage());
        }
    }

    public function getTeamById($id) {
        try {
            $query = "SELECT * FROM team WHERE id = :id";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }
}

?>