<?php
// Load database connection
require_once __DIR__ . '/../config/database.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_alert'])) {
    $disasterType = $_POST['disasterType'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $message = "ALERT: $disasterType reported at $location. Details: $description. — DRRM Team";

    $database = new Database();
    $pdo = $database->connect(); 

    // Fetch contact numbers from employee table
    $stmt = $pdo->prepare("SELECT contact_num FROM employee WHERE contact_num IS NOT NULL");
    $stmt->execute();
    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $numbers = [];
    foreach ($contacts as $row) {
        $contact = preg_replace('/\D/', '', $row['contact_num']); // Clean contact number
        if (!empty($contact)) {
            if (str_starts_with($contact, '0')) {
                $contact = '+63' . substr($contact, 1);
            } elseif (!str_starts_with($contact, '+63')) {
                $contact = '+63' . $contact;
            }
            $numbers[] = $contact;
        }
    }

    if (empty($numbers)) {
        die("No valid recipients found.");
    }

    $recipientNumbers = implode(',', $numbers);
    $send_data = [
        'sender_id' => 'PhilSMS',
        'recipient' => $recipientNumbers,
        'message' => $message
    ];

    $token = "1781|MT7curmrYM5STczJ8Y3ISFcbrXKR0JVwl6ka0ICm";
    $parameters = json_encode($send_data);

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
        die("SMS sending failed: " . curl_error($ch));
    }
    curl_close($ch);

    echo "<script>alert('Alert successfully sent!'); 
    window.location.href='../views/admin/main_admin.php';</script>";
    exit;
}
?>
