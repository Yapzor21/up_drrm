<?php
class UserReportModel {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function getAllReports() {
        $sql = "SELECT * FROM user_report ORDER BY Report_Id ASC";
        return $this->conn->query($sql);
    }
    
    public function getReportById($id) {
        $sql = "SELECT * FROM user_report WHERE Report_Id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function createReport($disasterType, $location, $reporter, $contact, $description) {
        $date_reported = date("Y-m-d H:i:s");
        
        $stmt = $this->conn->prepare("INSERT INTO user_report (Disaster_Type, Location, Description, Name_of_Reporter, Contact_Number, Date_Reported) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $disasterType, $location, $description, $reporter, $contact, $date_reported);
        
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    public function updateReport($id, $disasterType, $location, $reporter, $contact, $description) {
        $update_sql = "UPDATE user_report SET 
            Disaster_Type = ?, 
            Location = ?,
            Description = ?, 
            Name_of_Reporter = ?,
            Contact_Number = ? 
            WHERE Report_Id = ?";
        
        $stmt = $this->conn->prepare($update_sql);
        $stmt->bind_param("sssssi", $disasterType, $location, $description, $reporter, $contact, $id);
        
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    public function deleteReport($id) {
        $delete_sql = "DELETE FROM user_report WHERE Report_Id = ?";
        $stmt = $this->conn->prepare($delete_sql);
        $stmt->bind_param("i", $id);
        
        $result = $stmt->execute();
        $stmt->close();
        
        if($result) {
            // Check if there are any records left
            $check_empty = "SELECT COUNT(*) as count FROM user_report";
            $result_check = $this->conn->query($check_empty);
            $row_count = $result_check->fetch_assoc();
            
            if ($row_count['count'] > 0) {
                // If there are records, find the minimum ID to use
                $min_id_sql = "SELECT MIN(t1.Report_Id + 1) AS next_id
                               FROM user_report t1
                               LEFT JOIN user_report t2 ON t1.Report_Id + 1 = t2.Report_Id
                               WHERE t2.Report_Id IS NULL";
                $min_id_result = $this->conn->query($min_id_sql);
                
                if ($min_id_result && $min_id_row = $min_id_result->fetch_assoc()) {
                    $next_id = $min_id_row['next_id'];

                    // If there's a gap, reset auto_increment to fill it
                    if ($next_id > 1) {
                        $reset_sql = "ALTER TABLE user_report AUTO_INCREMENT = " . $next_id;
                        $this->conn->query($reset_sql);
                    }
                }
            } else {
                // Reset to first ID
                $reset_sql = "ALTER TABLE user_report AUTO_INCREMENT = 1";
                $this->conn->query($reset_sql);
            }
        }
        return $result;
    }   
    
   // pie and bar chart data for location and disaster type

   //pie chart for location
    public function getLocationData() {
        $sql = "SELECT Location, COUNT(*) as count FROM user_report GROUP BY Location ORDER BY count DESC";
        $result = $this->conn->query($sql);

        $locations = [];
        $counts = [];
        
        if ($result->num_rows > 0) {
            $topLocations = 3; // Show top 3 locations, the rest ma display sa others :)
            $i = 0;
            $otherCount = 0;
            
            while ($row = $result->fetch_assoc()) {
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
        }
        
        return ['labels' => $locations, 'data' => $counts];
    }
    /*
    // New method to get disaster type data for bar chart
    public function getDisasterTypeData() {
        // Get unique disaster types
        $sql = "SELECT DISTINCT Disaster_Type FROM user_report ORDER BY Disaster_Type";
        $result = $this->conn->query($sql);
        
        $disasterTypes = [];

        while ($row = $result->fetch_assoc()) {
            $disasterTypes[] = $row['Disaster_Type'];
        }
        
        // Get data for each year (assuming you have a Date_Reported field)
        $years = [date('Y'), date('Y', strtotime('-1 year')), date('Y', strtotime('-2 year'))];
        $datasets = [];
        
        $colors = [
            ['rgba(54, 162, 235, 0.7)', 'rgba(54, 162, 235, 1)'],  // Blue
            ['rgba(255, 99, 132, 0.7)', 'rgba(255, 99, 132, 1)'],  // Red
            ['rgba(104, 100, 236, 0.7)', 'rgba(104, 100, 236, 1)'] // Purple
        ];
        
        foreach ($years as $index => $year) {
            $yearData = [];
            
            foreach ($disasterTypes as $type) {
                $sql = "SELECT COUNT(*) as count FROM user_report 
                        WHERE Disaster_Type = ? AND YEAR(Date_Reported) = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("si", $type, $year);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $yearData[] = $row['count'];
                $stmt->close();
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
        */

        /*
                          ***REPORTING***
         - fetch all unique values in the Disaster_Type column from the user_report table.
         - building an array $disasterTypes that holds these unique disaster type values.
         - 

        */
        public function getDisasterTypeData() {
            // Retrieve unique disaster types
            $sql = "SELECT DISTINCT Disaster_Type FROM user_report ORDER BY Disaster_Type";
            $result = $this->conn->query($sql);
            
            $disasterTypes = [];
            while ($row = $result->fetch_assoc()) {
                $disasterTypes[] = $row['Disaster_Type'];
            }
            
            /*
                        ***REPORTING***
            -  creates an array of three years
            - The current year and the two previous years
            - Function and the strtotime() function to subtract one and two years
            
            */ 
            $years = [
                date('Y'),
                date('Y', strtotime('-1 year')),
                date('Y', strtotime('-2 year'))
            ];
            
            $datasets = [];
            $colors = [
                ['rgba(54, 162, 235, 0.7)', 'rgba(54, 162, 235, 1)'],  // Blue
                ['rgba(255, 99, 132, 0.7)', 'rgba(255, 99, 132, 1)'],  // Red
                ['rgba(104, 100, 236, 0.7)', 'rgba(104, 100, 236, 1)']   // Purple
            ];
            
            // Loop through each year and fetch counts grouped by disaster type
            foreach ($years as $index => $year) {
                // Initialize counts for all disaster types to zero
                $yearData = array_fill(0, count($disasterTypes), 0);
                
                // Query to get count for each disaster type for the current year
                $sql = "SELECT Disaster_Type, COUNT(*) as count 
                        FROM user_report 
                        WHERE YEAR(Date_Reported) = ? 
                        GROUP BY Disaster_Type";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("i", $year);
                $stmt->execute();
                $result = $stmt->get_result();
                
                while ($row = $result->fetch_assoc()) {
                    // Find the index for the disaster type
                    $displays = array_search($row['Disaster_Type'], $disasterTypes);
                    if ($displays !== false) {
                        $yearData[$displays] = $row['count'];
                    }
                    else{
                        echo ' no records found';
                    }
                }
                $stmt->close();
                
                // Build dataset for the current year
                $datasets[] = [
                    'label' => $year,
                    'data' => $yearData,
                    'backgroundColor' => $colors[$index][0],
                    'borderColor' => $colors[$index][1],
                    'borderWidth' => 1
                ];
            }
            
            /* 
             - returns an associative array where
             - labels = list of disaster types.
             - Contains the datasets for each year, include the counts for each disaster type AND ALSO THEIR SYTLES (COLORS & BG COLORS)
            */
            return [
                'labels' => $disasterTypes,
                'datasets' => $datasets
            ];
        }
        
}
?>

