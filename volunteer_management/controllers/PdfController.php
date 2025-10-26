<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_errors', 1);
require_once '../config/database.php';
require_once '../model/report.php';

class PdfController {
    public function generateReport() {
        $model = new ReportModel();
        $reports = $model->getAllReports();
        $assignments = $model->getAssignments();

        // Convert data to simple HTML table
      $html = '
<html>
<head>
<style>
    body {
        font-family: "Helvetica", Arial, sans-serif;
        margin: 40px;
        color: #333;
    }
    .header {
        text-align: center;
        border-bottom: 2px solid #333;
        padding-bottom: 10px;
        margin-bottom: 30px;
    }
    .header img {
        width: 100px;
        vertical-align: middle;
    }
    .header h1 {
        margin: 10px 0 5px;
        font-size: 20px;
        text-transform: uppercase;
    }
    .header h2 {
        margin: 0;
        font-size: 16px;
        font-weight: normal;
    }
    .header p {
        font-size: 12px;
        color: #666;
    }
    h3 {
        margin-top: 40px;
        color: #004aad;
        text-transform: uppercase;
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        font-size: 12px;
    }
    th {
        background-color: #004aad;
        color: white;
        padding: 8px;
        border: 1px solid #ccc;
    }
    td {
        border: 1px solid #ccc;
        padding: 8px;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    .note {
        text-align: center;
        font-style: italic;
        color: #0066cc;
        font-size: 11px;
        margin-top: 5px;
    }
    .footer {
        font-size: 10px;
        color: #666;
        text-align: center;
        border-top: 1px solid #ccc;
        margin-top: 40px;
        padding-top: 10px;
    }
</style>
</head>
<body>

<div class="header">
    <img src="https://upload.wikimedia.org/wikipedia/commons/5/58/DRRM_logo.png" alt="Logo" />
    <h1>DISASTER RISK REDUCTION MANAGEMENT OFFICE</h1>
    <h2>Incident Report Summary</h2>
    <p>' . date("F j, Y") . '</p>
</div>

<h3>Disaster Report</h3>
<table>
<tr>
<th>Disaster Type</th>
<th>Location</th>
<th>Description</th>
<th>Reporter</th>
<th>Contact</th>
<th>Date</th>
</tr>';
foreach ($reports as $r) {
    $html .= "<tr>
        <td>{$r['Disaster_Type']}</td>
        <td>{$r['Location']}</td>
        <td>{$r['Description']}</td>
        <td>{$r['Name_of_Reporter']}</td>
        <td>{$r['Contact_Number']}</td>
        <td>{$r['Date_Reported']}</td>
    </tr>";
}
$html .= '</table>
<div class="note">* The report above lists all disaster incidents submitted by volunteers over the past week *</div>

<h3>Assigned Team</h3>
<table>
<tr>
<th>Report Id</th>
<th>Disaster Type</th>
<th>Location</th>
<th>City</th>
<th>Assigned Team</th>
<th>Time Started</th>
<th>Date Assigned</th>
</tr>';
foreach ($assignments as $a) {
    $html .= "<tr>
        <td>{$a['report_id']}</td>
        <td>{$a['disaster_type']}</td>
        <td>{$a['location']}</td>
        <td>{$a['city']}</td>
        <td>{$a['team_name']}</td>
        <td>{$a['time_started']}</td>
        <td>{$a['date_assigned']}</td>
    </tr>";
}
$html .= '</table>
<div class="note">* The report above lists all the assigned teams over the past week *</div>

<div class="footer">
    Confidential - DRRM Internal Use Only | Page 1
</div>

</body>
</html>';



        // ---- PDF.co API Integration ----
        $api_key = 'gabcantoss99@gmail.com_SxOReUtryJdeYyHjQl12JovcFEpKTCDQVMBbX8DoUcCQSU8uLX2hLd8yqug20Vyt';
        $url = 'https://api.pdf.co/v1/pdf/convert/from/html';

        $data = [
            "html" => $html,
            "name" => "Disaster_Report.pdf"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "x-api-key: $api_key",
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (!empty($result["url"])) {
            header("Location: " . $result["url"]); // redirect to the PDF
        } else {
            echo "Error: " . $response;
        }
    }
}
// --- Run the report generation when this file is accessed directly ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/database.php';
    require_once '../model/report.php';

    // ✅ Create a Database connection
    $db = new Database();
    $conn = $db->connect();

    // ✅ Pass connection to your model
    $model = new UserReportModel($conn);

    // ✅ Fetch your data
    $reports = $model->getAllReports();

    // (you can skip assignments for now if not yet defined)
    $assignments = [];

    // ✅ Generate your HTML
    $html = "<h1>Disaster Report Summary</h1><table border='1'><tr>
                <th>Disaster Type</th><th>Location</th><th>Description</th><th>Reporter</th><th>Contact</th><th>Date</th></tr>";
    foreach ($reports as $r) {
        $html .= "<tr>
                    <td>{$r['Disaster_Type']}</td>
                    <td>{$r['Location']}</td>
                    <td>{$r['Description']}</td>
                    <td>{$r['Name_of_Reporter']}</td>
                    <td>{$r['Contact_Number']}</td>
                    <td>{$r['Date_Reported']}</td>
                  </tr>";
    }
    $html .= "</table>";

    // ✅ Call PDF.co API
    $api_key = "gabcantoss99@gmail.com_xP9GV7rAiJ5WFtx2bycgjVwS3RIcidxXiYoqKiVVxN4fGWiMpY9IC08EiNsP9I2b";
    $url = "https://api.pdf.co/v1/pdf/convert/from/html";
    $data = [
        "html" => $html,
        "name" => "Disaster_Report.pdf"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "x-api-key: $api_key",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die('Curl error: ' . curl_error($ch));
    }

    curl_close($ch);

    $result = json_decode($response, true);

    if (!empty($result["url"])) {
        header("Location: " . $result["url"]);
        exit;
    } else {
        echo "<pre>";
        print_r($result);
        echo "</pre>";
    }
}

?>
