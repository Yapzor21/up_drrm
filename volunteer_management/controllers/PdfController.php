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
            header("Location: " . $result["url"]); 
        } else {
            echo "Error: " . $response;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/database.php';
    require_once '../model/report.php';

    $db = new Database();
    $conn = $db->connect();

    $model = new UserReportModel($conn);

    $reports = $model->getAllReports();

    $assignments = [];


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