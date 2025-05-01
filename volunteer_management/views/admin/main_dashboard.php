
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


  <?php
  include '../../partials/header.php';
  ?>
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
