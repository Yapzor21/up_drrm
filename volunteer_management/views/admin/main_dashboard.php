
<?php
require_once '../../controllers/report_control.php';
require_once '../../controllers/assigned_control.php';
require_once '../../controllers/personnel_control.php';
require_once '../../model/assigned.php';
require_once '../../model/teams.php';
require_once '../../config/database.php';
$controller = new UserReportController(null);

// Get chart data
$locationData = $controller->getLocationChartData();
$disasterTypeData = $controller->getDisasterTypeChartData();

// Initialize database connection
$database = new Database();
$db = $database->connect();

// Initialize assignment object
$assignment = new Assignment($db);
// Initialize team model
$teamModel = new Team($db);
// Fetch all teams
$teams = $teamModel->getAllTeams();

$reportIdForAssignment = isset($_GET['report_id']) ? $_GET['report_id'] : '';
$showAssignModal = isset($_GET['assign']) && $_GET['assign'] == 'true';
// Get report ID from URL
$reportId = isset($_GET['report_id']) ? $_GET['report_id'] : null;

// Get assignment details for the specific report (if one is selected)
$assignmentDetails = $reportId ? $assignment->getAssignmentDetailsForReport($reportId) : [];

// Get ALL assignments for ALL reports
$allAssignments = $assignment->getAllAssignments();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOVPH DRRM Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/admin/main_dashboard.css">
    <link rel = "icon" type="image/svg+xml" href="../../assets/images/iconLogo1.svg">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div id="overlay" id="overlay"></div>
    <div id="sidebar" id="sidebar" onclick="stopPropagation()">
        <div class="close">  
            <button class="sidebar-close" onclick="toggleSidebar()">×</button>
        </div>   
        <div class="menu">
        <nav id="nav-menu">
            <ul>
                 <ol><a href="#">Dashboard</a></ol>
                 <ol><a href="teams.php">Teams</a></ol>
                 <ol><a href="main_admin.php">Admin</a></ol>
                 <ol><a href="../../controllers/logout1.php">Logout</a></ol>
            </ul>
        </nav>
        </div>
        <button id="report-btn"  onclick="openModal('reportModal')">REPORT</button>
    </div>

<header id="top-header">
    <div class="logos">
        <a href="#" id="drrm-logo">
            <img src="../../assets\images\Group 2829.png" alt="">
        </a>
        <a href="#" id="govph-logo">
            <img src="../../assets/images/Frame 3 (1).svg" alt="">
        </a>
        </div>
        <button id="menu-toggle" onclick="toggleSidebar()">☰</button>
        <nav id="nav-menu">
            <a href="#" id="community_dashboard">Dashboard</a>
            <a href="main_admin.php" id="admin-link">Admin</a>
            <ol> <a href="teams.php">Teams</a></ol>
            <a href="../../controllers/logout1.php">Logout</a>
        </nav>
    </header>
    <div id="sub-header">
        <div id="drrm-logor">
            <img src="../../assets/images/Frame 1 (1).svg" alt="">
        </div>
        <div id="right-section">
            <button id="report-btn" class="report-btn" onclick="openModal('reportModal')">REPORT</button>
            <div id="time-box">
                <div id="time-label">Philippine Standard Time</div>
                <div id="ph-time" class="time"></div>
                <div id="ph-date" class="date"></div>
            </div>
        </div>
    </div>
    
      <!-- Create Alert Modal -->
<div class="modal" id="reportModal">
    <div class="modal-content" onclick="stopPropagation()">
        <button class="close-button" onclick="closeModal('reportModal')">×</button>
        <h3>Create Alert</h3>
        <form id="reportForm" method="POST" action="../../controllers/sms_control.php">
            <div class="form-group">
                <label for="disasterType">Disaster Type</label>
                <input type="text" id="disasterType" name="disasterType" required>
            </div>
            <div class="form-group">
                <label for="location">Exact Location</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="description">Description of Disaster</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="alert-info">
                <p><strong>Note:</strong> This alert will be sent via SMS to all registered contact numbers.</p>
            </div>
            <button type="submit" name="create_alert" class="submit-button">Create & Send Alert</button>
        </form>
    </div>
</div>

    <div class="main-contents">

   
    <!-- cahart -->
    <div class="chart-container">
        <div class="chart">
            <canvas id="incidentsChart"></canvas>
        </div>
        <div class="chart">
            <canvas id="categoriesChart"></canvas>
        </div>
    </div>

     <!-- All Team Assignments Section -->
            <div class="table-container">
                <div class="search-container">
                    <div class="title-header"><h3>on going operations</h3></div>
                    <div class="const">
                        <input type="text" id="searchInput" placeholder="Search reports..." autocomplete="off">
                        <button id="searchButton">Search</button>
                    </div>
                </div>
                <?php if (!empty($allAssignments)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Report ID</th>
                                <th>Disaster Type</th>
                                <th>Location</th>
                                <th>City</th>
                                <th>Assigned Teams</th>
                                <th>Time Started</th>
                                <th>Date Assigned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allAssignments as $assignment): ?>
                            <tr class="<?php echo ($reportId && $assignment['report_id'] == $reportId) ? 'highlight' : ''; ?>">
                                <td><?php echo htmlspecialchars($assignment['report_id']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['Disaster_Type']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['Location']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['City']); ?></td>
                                <td><?php echo htmlspecialchars($assignment['team_names']); ?></td>
                                <td><?php echo htmlspecialchars(date('h:i A', strtotime($assignment['time_started']))); ?></td>
                                <td><?php echo htmlspecialchars(date('M d, Y', strtotime($assignment['date_assigned']))); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">No team assignments found.</div>
                <?php endif; ?>
            </div>
     </div>
  <!--footer sheeshh-->
  <?php
  include '../../partials/footer.php';
  ?>
</body>

<script>

const locationData = {
labels: <?php echo json_encode($locationData['labels']); ?>,
data: <?php echo json_encode($locationData['data']); ?>
};

// Disaster type data for bar chart from PHP
const disasterTypeData = <?php echo json_encode($disasterTypeData); ?>;

</script>
<script src="../../assets/js/timelynews.js"></script>
<script src="../../assets/js/charts.js"></script>
<script src="../../assets/js/header.js"></script>
<script src="../../assets/js/modal.js"></script>
    
</html>
