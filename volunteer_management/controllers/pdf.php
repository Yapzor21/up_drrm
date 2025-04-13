<?php
define('FPDF_FONTPATH', __DIR__ . '/../pdf/font/');

/* Verify path exists (temporary debug)
if (!is_dir(FPDF_FONTPATH)) {
    die("Font directory missing: " . FPDF_FONTPATH);
}
*/

require_once __DIR__ . '/../pdf/fpdf.php';
require_once('../pdf/fpdf.php'); 
require_once '../config/database.php'; 


$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("SELECT * FROM user_report ORDER BY Date_Reported DESC");
$stmt->execute();
$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);


class DisasterPDF extends FPDF {
 // Header
 function Header() {
    $this->Image('../assets/images/Frame 1 (1).png', 10, 8, 35); 
    $this->SetFont('Helvetica', 'B', 14);
    $this->SetXY(0, 12); 
    $this->Cell(0, 6, 'DISASTER RISK REDUCTION MANAGEMENT OFFICE', 0, 1, 'C');
    $this->SetFont('Helvetica', 'B', 12);
    $this->Cell(0, 6, 'Incident Report Summary', 0, 1, 'C');
    $this->SetFont('Helvetica', '', 10);
    $this->Cell(0, 6, date('F j, Y'), 0, 1, 'C');
    $this->Line(10, 40, $this->w - 10, 40);
    $this->Ln(15);
}
function Footer() {
 
    $this->SetY(-15);
    $this->SetFont('Helvetica', 'I', 8);
    $this->Cell(90, 10, 'Confidential - DRRM Internal Use Only', 0, 0, 'L');
    $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'R');
    $this->Line(10, $this->GetY() - 5, 287, $this->GetY() - 5);
}

    function BuildTable($header, $data) {
        
        $this->SetFont('helvetica', 'B', 10);
        foreach($header as $col) {
            $this->Cell(40, 7, $col, 1);
        }
        $this->Ln();

        // Data
        $this->SetFont('helvetica', '', 9);
        foreach($data as $row) {
            $this->Cell(40, 6, $row['Disaster_Type'], 1);
            $this->Cell(40, 6, $row['Location'], 1);
            $this->Cell(40, 6, substr($row['Description'], 0, 15), 1);
            $this->Cell(40, 6, $row['Name_of_Reporter'], 1);
            $this->Cell(40, 6, $row['Contact_Number'], 1);
            $this->Cell(40, 6, $row['Date_Reported'], 1);
            $this->Ln();
        }
    }
}

// Generate PDF
$pdf = new DisasterPDF('L');
$pdf->AddPage();
$pdf -> Cell(28, 10, 'Disaster Report', 0, 1, 'C');
$pdf->BuildTable(
    ['Disaster Type', 'Location', 'Description', 'Reporter', 'Contact', 'Date'],
    $reports
);
$pdf->SetTextColor(0, 102, 204);
$pdf -> Cell(0, 10, ' * The above report lists all disaster incidents submitted by volunteers within the past week.', 0, 1, 'C');
$pdf->SetTextColor(0, 0, 0);
$pdf->Output('I', 'Disaster_Report.pdf');
?>