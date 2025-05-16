
<?php
require_once '../../controllers/report_control.php';
$controller = new UserReportController(null);

// Get chart data
$locationData = $controller->getLocationChartData();
$disasterTypeData = $controller->getDisasterTypeChartData();
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
                 <ol><a href="#">Account</a></ol>
                 <ol><a href="main_admin.php">Admin</a></ol>
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
            <a href="community_dashboard.php" id="community_dashboard">Dashboard</a>
            <a href="../views/user/community_report.php" id="admin-link">Account</a>
            <a href="main_admin.php" id="admin-link">Admin</a>
            <ol> <a href="community.php">About us</a></ol>
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
    
    <!-- Alert modal -->
    <div class="modal" id="reportModal" >
        <div class="modal-content" onclick="stopPropagation()" >
            <button class="close-button" onclick="closeModal('reportModal')">×</button>
            <h3>Create Alert</h3>
            <form id="reportForm">
                <div class="form-group">
                    <label for="disasterType">Disaster Type</label>
                    <input type="text" id="disasterType" required>
                </div>

                <div class="form-group">
                    <label for="location"> Exact Location</label>
                    <input type="text" id="location" required>
                </div>

                <div class="form-group">
                    <label for="description">Description of Disaster</label>
                    <textarea id="description" required></textarea>
                </div>
                <button type="submit" class="submit-button">Create</button>
            </form>
        </div>
    </div>


    <!-- cahart -->
    <div class="chart-container">
        <div class="chart">
            <canvas id="incidentsChart"></canvas>
        </div>
        <div class="chart">
            <canvas id="categoriesChart"></canvas>
        </div>
    </div>

<div id="content">
    <div class="title"><h3 style="margin-left: 5.5px;"> ON-GOING OPERATION <h3></div>
        <div id="sub-content">
            <div class="table-container"> <!-- Added div for responsive scrolling -->
                <table id="data-list">
                    <tbody>
                        <tr>
                            <th>Disaster Type</th>
                            <th>Time Started</th>
                            <th>Assigned Team</th>
                            <th>Affected Areas</th>
                        </tr>
                        <tr>
                            <td>Earthquake</td>
                            <td>10:00am</td>
                            <td>Rescue Team</td>
                            <td>Manila</td>
                        </tr>
                        <tr>
                            <td>Earthquake</td>
                            <td>10:00am</td>
                            <td>Rescue Team</td>
                            <td>Manila</td>
                        </tr>
                        <tr>
                            <td>Earthquake</td>
                            <td>10:00am</td>
                            <td>Rescue Team</td>
                            <td>Manila</td>
                        </tr>
                        <tr>
                            <td>Earthquake</td>
                            <td>10:00am</td>
                            <td>Rescue Team</td>
                            <td>Manila</td>
                        </tr>

                    </tbody>
                </table>
            </div>
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
