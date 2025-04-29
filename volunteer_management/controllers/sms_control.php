<?php
// Load database connection
require_once __DIR__ . '/../config/database.php'; 
require_once __DIR__ . '/../model/report.php';  

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_alert'])) {
    // Get form inputs
    $disasterType = $_POST['disasterType'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Compose the SMS message
    $message = "ALERT: $disasterType reported at $location. Details: $description. — DRRM Team";

 
     $database = new Database();
     $pdo = $database->connect(); 


    // Load all contact numbers
    $model = new UserReportModel($pdo);
    $reports = $model->getAllReports();

    $numbers = [];
    foreach ($reports as $report) {
        $contact = preg_replace('/\D/', '', $report['Contact_Number']); // Remove non-digits
        if (!empty($contact)) {
            // Ensure country code prefix
            if (str_starts_with($contact, '0')) {
                $contact = '+63' . substr($contact, 1);
            } elseif (!str_starts_with($contact, '+63')) {
                $contact = '+63' . $contact;
            }
            $numbers[] = $contact;
        }
    }

    if (empty($numbers)) {
        die(" No valid recipients found.");
    }

    // Prepare data for SMS API
    $recipientNumbers = implode(',', $numbers);
    $send_data = [
        'sender_id' => 'PhilSMS',
        'recipient' => $recipientNumbers,
        'message' => $message
    ];

    $token = "1781|MT7curmrYM5STczJ8Y3ISFcbrXKR0JVwl6ka0ICm";
    $parameters = json_encode($send_data);

    // Send SMS via PhilSMS API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://app.philsms.com/api/v3/sms/send");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = "SMS sending failed: " . curl_error($ch);
        curl_close($ch);
        die($error);
    }

    curl_close($ch);

    echo "<script>alert(' Alert successfully sent!'); window.location.href='../../../views/admin/main_admin.php';</script>";
   
    header("Location: ../../../views/admin/main_admin.php?status=success");
exit;

}
?>
