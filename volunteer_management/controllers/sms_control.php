<?php

require_once __DIR__ . '/../config/database.php'; 


$database = new Database();
$conn = $database->connect();

// Check 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_alert'])) {
    
    // Get form data
    $disasterType = $_POST['disasterType'] ?? '';
    $location = $_POST['location'] ?? '';
    $description = $_POST['description'] ?? '';
    
    $query = "SELECT contact_num FROM employee WHERE status = 'standby' AND contact_num IS NOT NULL";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($employees) > 0) {
        // PhilSMS API credentials
        $sender_id = "PhilSMS";
        $token = "3392|GZKHRdfziTh9KuMwqHqt3jNC9M5pSfLYndr4OzHk";
        
        // Prepare message
        $message = "DISASTER ALERT: $disasterType\nLocation: $location\nDetails: $description";
        
        $successful_sends = 0;
        $failed_sends = 0;
        
        foreach ($employees as $employee) {
            $contact_num = $employee['contact_num'];
            
            if (substr($contact_num, 0, 1) === '0') {
                $formatted_number = '+63' . substr($contact_num, 1);
            } else {
                $formatted_number = $contact_num;
            }
            
            
            $send_data = [
                'sender_id' => $sender_id,
                'recipient' => $formatted_number,
                'message' => $message
            ];
            
            $parameters = json_encode($send_data);
            
            // Send SMS via PhilSMS API
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $headers = [
                "Content-Type: application/json",
                "Authorization: Bearer $token"
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            
            if ($http_code === 200 || $http_code === 201) {
                $successful_sends++;
            } else {
                $failed_sends++;
            }
        }
        
        // Return success response
        $_SESSION['alert_message'] = "Alert sent successfully to $successful_sends standby employees.";
        if ($failed_sends > 0) {
            $_SESSION['alert_message'] .= " ($failed_sends failed)";
        }
        $_SESSION['alert_type'] = 'success';
        
    } else {
        $_SESSION['alert_message'] = "No standby employees found to alert.";
        $_SESSION['alert_type'] = 'warning';
    }
    

    echo "<script>alert('Alert successfully sent to " . " standby employees!'); 
    window.location.href='../views/admin/main_admin.php';</script>";
    exit;
}
?>
