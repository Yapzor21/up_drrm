<?php

require_once __DIR__ . '/../config/database.php'; // Make sure $pdo is defined in this file


class UserReportModel {
    private $pdo; // Use a single property name consistently
    
    public function __construct($pdo) {
        // Just store the passed PDO connection
        $this->pdo = $pdo;
    }

    public function getAllReports() {
        $stmt = $this->pdo->query("SELECT * FROM user_report ORDER BY Report_Id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function getReportById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM user_report WHERE Report_Id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createReport($disasterType, $location, $city, $reporter, $contact, $description) {
        $date_reported = date("Y-m-d H:i:s");
        $sql = "INSERT INTO user_report (Disaster_Type, Location, City, Description, Name_of_Reporter, Contact_Number, Date_Reported) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$disasterType, $location, $city, $description, $reporter, $contact, $date_reported]);
    }

    public function updateReport($id, $disasterType, $location, $city,  $reporter, $contact, $description) {
        $sql = "UPDATE user_report SET 
                Disaster_Type = ?, 
                Location = ?, 
                City = ?,
                Description = ?, 
                Name_of_Reporter = ?, 
                Contact_Number = ? 
                WHERE Report_Id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$disasterType, $location, $city, $description, $reporter, $contact, $id]);
    }

    public function getCities() {
        $stmt = $this->pdo->query("SELECT DISTINCT City FROM user_report WHERE City IS NOT NULL ORDER BY City");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    

    public function deleteReport($id) {
        $stmt = $this->pdo->prepare("DELETE FROM user_report WHERE Report_Id = ?");
        $result = $stmt->execute([$id]);

        return $result;
    }


    // add limit for top 3 cities and others as ms dairin suggested
    public function getLocationData() {
        $sql = "SELECT City, COUNT(*) as count FROM user_report GROUP BY City ORDER BY count DESC";
        $stmt = $this->pdo->query($sql);

        $city = [];
        $counts = [];
        $topcity = 3;
        $i = 0;
        $otherCount = 0;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($i < $topcity) {
                $city[] = $row['City'];
                $counts[] = $row['count'];
            } else {
                $otherCount += $row['count'];
            }
            $i++;
        }

        if ($otherCount > 0) {
            $city[] = 'Others';
            $counts[] = $otherCount;
        }

        return ['labels' => $city, 'data' => $counts];
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

?>