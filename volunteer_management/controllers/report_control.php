<?php
// Include database connection
require_once '../config/database.php';

$message = "";
// create fields 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_report'])) {
        // Get form data
        $disasterType = ucwords($_POST['disasterType']);
        $location = ucwords($_POST['location']);
        $reporter = ucwords($_POST['reporter']);
        $contact = ucwords($_POST['contact']);
        $description = ucwords($_POST['description']);
        $date_reported = date("Y-m-d H:i:s");
        
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO user_report (Disaster_Type,Location,Description,Name_of_Reporter,Contact_Number,Date_Reported) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $disasterType, $location, $description, $reporter, $contact, $date_reported);
        
        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../views/user/community_report.php");
            $message = "Report submitted successfully";
        } else {
            $message = "Error submitting report: " . $stmt->error;
        }
        $stmt->close();
    }
}

$sql = "SELECT * FROM user_report";
$result = $conn->query($sql);

// delete
if(isset($_POST['delete'])) {
    $id = $_POST['report_id'];
    $delete_sql = "DELETE FROM user_report WHERE Report_Id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
     
        // First, check if there are any records left 
        $check_empty = "SELECT COUNT(*) as count FROM user_report";
        $result_check = $conn->query($check_empty);
        $row_count = $result_check->fetch_assoc();
        
        if ($row_count['count'] > 0) {
            // If there are records, find the minimum ID to use
            $min_id_sql = "SELECT MIN(t1.Report_Id + 1) AS next_id
                           FROM user_report t1
                           LEFT JOIN user_report t2 ON t1.Report_Id + 1 = t2.Report_Id
                           WHERE t2.Report_Id IS NULL";
            $min_id_result = $conn->query($min_id_sql);
            
            if ($min_id_result && $min_id_row = $min_id_result->fetch_assoc()) {
                $next_id = $min_id_row['next_id'];

                // If there's a gap, reset auto_increment to fill it
                if ($next_id > 1) {
                    $reset_sql = "ALTER TABLE user_report AUTO_INCREMENT = " . $next_id;
                    $conn->query($reset_sql);
                }
            }
        } else {
          // para mag balik sa una nga id (reset)
            $reset_sql = "ALTER TABLE user_report AUTO_INCREMENT = 1";
            $conn->query($reset_sql);
        }
        
        $message = "Report deleted successfully";
        header("Location: ../views/admin/main_admin.php");
        exit();
    } else {
        $message = "Error deleting report: " . $stmt->error;
    }
    $stmt->close();
}

// update
if(isset($_POST['update_submit'])) {
    // Get data from form
    $id = $_POST['report_id'];
    $disasterType = ucwords($_POST['disasterType']);
    $location = ucwords($_POST['location']);
    $reporter = ucwords($_POST['reporter']);
    $contact = $_POST['contact'];
    $description = ucwords($_POST['description']);  
    
    // Update using report_id as the identifier
    $update_sql = "UPDATE user_report SET
    Disaster_Type = ?, 
    Location = ?,
    Description = ?, 
    Name_of_Reporter = ?,
    Contact_Number = ? 
    WHERE Report_Id = ?";
    
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssi", $disasterType, $location, $description, $reporter, $contact, $id);
    
    if($stmt->execute()) {
        $message = "Report updated successfully";
        // Refresh the page to show updated data
        header("Location: ../views/admin/main_admin.php");
        exit();
    } else {
        $message = "Error updating report: " . $stmt->error;
    }
    $stmt->close();
}
?>



