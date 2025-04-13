<?php

require_once __DIR__ . '/../config/database.php'; // Make sure $pdo is defined in this file


class UserReportModel {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    // In report_control.php


    public function getAllReports() {
        $stmt = $this->pdo->query("SELECT * FROM user_report ORDER BY Report_Id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReportById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM user_report WHERE Report_Id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createReport($disasterType, $location, $reporter, $contact, $description) {
        $date_reported = date("Y-m-d H:i:s");
        $sql = "INSERT INTO user_report (Disaster_Type, Location, Description, Name_of_Reporter, Contact_Number, Date_Reported) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$disasterType, $location, $description, $reporter, $contact, $date_reported]);
    }

    public function updateReport($id, $disasterType, $location, $reporter, $contact, $description) {
        $sql = "UPDATE user_report SET 
                Disaster_Type = ?, 
                Location = ?, 
                Description = ?, 
                Name_of_Reporter = ?, 
                Contact_Number = ? 
                WHERE Report_Id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$disasterType, $location, $description, $reporter, $contact, $id]);
    }

    public function deleteReport($id) {
        $stmt = $this->pdo->prepare("DELETE FROM user_report WHERE Report_Id = ?");
        $result = $stmt->execute([$id]);

        if ($result) {
            $count = $this->pdo->query("SELECT COUNT(*) as count FROM user_report")->fetch(PDO::FETCH_ASSOC)['count'];
            if ($count > 0) {
                $nextIdQuery = "
                    SELECT MIN(t1.Report_Id + 1) AS next_id
                    FROM user_report t1
                    LEFT JOIN user_report t2 ON t1.Report_Id + 1 = t2.Report_Id
                    WHERE t2.Report_Id IS NULL";
                $nextId = $this->pdo->query($nextIdQuery)->fetch(PDO::FETCH_ASSOC)['next_id'];

                if ($nextId > 1) {
                    $this->pdo->exec("ALTER TABLE user_report AUTO_INCREMENT = $nextId");
                }
            } else {
                $this->pdo->exec("ALTER TABLE user_report AUTO_INCREMENT = 1");
            }
        }

        return $result;
    }

    public function getLocationData() {
        $sql = "SELECT Location, COUNT(*) as count FROM user_report GROUP BY Location ORDER BY count DESC";
        $stmt = $this->pdo->query($sql);

        $locations = [];
        $counts = [];
        $topLocations = 3;
        $i = 0;
        $otherCount = 0;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($i < $topLocations) {
                $locations[] = $row['Location'];
                $counts[] = $row['count'];
            } else {
                $otherCount += $row['count'];
            }
            $i++;
        }

        if ($otherCount > 0) {
            $locations[] = 'Others';
            $counts[] = $otherCount;
        }

        return ['labels' => $locations, 'data' => $counts];
    }

    public function getDisasterTypeData() {
        $typesStmt = $this->pdo->query("SELECT DISTINCT Disaster_Type FROM user_report ORDER BY Disaster_Type");
        $disasterTypes = $typesStmt->fetchAll(PDO::FETCH_COLUMN);

        $years = [
            date('Y'),
            date('Y', strtotime('-1 year')),
            date('Y', strtotime('-2 year'))
        ];

        $colors = [
            ['rgba(54, 162, 235, 0.7)', 'rgba(54, 162, 235, 1)'],
            ['rgba(255, 99, 132, 0.7)', 'rgba(255, 99, 132, 1)'],
            ['rgba(104, 100, 236, 0.7)', 'rgba(104, 100, 236, 1)']
        ];

        $datasets = [];

        foreach ($years as $index => $year) {
            $yearData = array_fill(0, count($disasterTypes), 0);

            $sql = "SELECT Disaster_Type, COUNT(*) as count 
                    FROM user_report 
                    WHERE YEAR(Date_Reported) = ? 
                    GROUP BY Disaster_Type";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$year]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $idx = array_search($row['Disaster_Type'], $disasterTypes);
                if ($idx !== false) {
                    $yearData[$idx] = $row['count'];
                }
            }

            $datasets[] = [
                'label' => $year,
                'data' => $yearData,
                'backgroundColor' => $colors[$index][0],
                'borderColor' => $colors[$index][1],
                'borderWidth' => 1
            ];
        }

        return [
            'labels' => $disasterTypes,
            'datasets' => $datasets
        ];
    }
}
class TeamModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn; // Store the PDO connection
    }

    // Fetch all teams using PDO
    public function getAllTeams() {
        // Prepare the query
        $stmt = $this->conn->prepare("SELECT * FROM teams");
        
        // Execute the query
        $stmt->execute();
        
        // Fetch all results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

