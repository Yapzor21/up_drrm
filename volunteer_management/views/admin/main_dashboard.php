
<?php
require_once '../../controllers/report_control.php';
require_once '../../config/database.php';
require_once '../../model/report.php';
// instanciate class
$db = new Database();
$conn = $db->connect(); // ✅ get the PDO connection

$controller = new UserReportController($conn);


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
            <a href="#" id="dashboard-link">Dashboard</a>
            <a href="#" id="dashboard-link">Account</a>
            <a href="../../views\user\community_dashboard.php" id="community-link">Community</a>
            <a href="main_admin.php" id="admin-link">Admin</a>
            <a href="../../controllers/logout.php" style="float: right;">Logout</a>
        </nav>
    </header>

    <div id="sub-header">
        <div id="drrm-logor">
            <img src="../../assets/images/Frame 1 (1).svg" alt="">
        </div>
        <div id="right-section">
            <div id="time-box">
                <div id="time-label">Philippine Standard Time</div>
                <div id="ph-time" class="time"></div>
                <div id="ph-date" class="date"></div>
            </div>
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

  <footer class="footer">
    <div class="footer-content">
        <div class="footer-grid">
            <div class="footer-logo">
                <div class="logo_1"> <img src="../../assets/images/Rectangle 1079.png" alt=""></div>

                <div class="logo_2"> <img src="../../assets/images/Group 2829.png" alt=""></div>
               
            </div>

            <!-- About Section -->
            <div class="footer-about">
                <h2>ABOUT DRRM</h2>
                <p>
                    The DRRM Volunteer Management System is a platform designed to streamline volunteer coordination and management. The system enables real-time volunteer deployment, emergency tracking, and resource management to enhance community preparedness and resilience.
                </p>
            </div>

            <!-- Contact Section -->
            <div class="footer-contact">
                <h2>CONTACT US</h2>
                <div class="contact-info">
                    <div>
                        <div class="contacts">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><g data-name="7-Email-Arrow up"><path d="M29 4H3a3 3 0 0 0-3 3v18a3 3 0 0 0 3 3h13v-2H3a1 1 0 0 1-1-1V7.23l13.42 9.58a1 1 0 0 0 1.16 0L30 7.23V17h2V7a3 3 0 0 0-3-3zM16 14.77 3.72 6h24.56z"/><path d="m24.29 18.29-4 4 1.41 1.41 2.3-2.29V29h2v-7.59l2.29 2.29 1.41-1.41-4-4a1 1 0 0 0-1.41 0z"/></g></svg>
                            <strong>Email Address:</strong>
                        </div>
                        <p>info@drrm.example.com</p>
                    </div>
                    <div>
                        <div class="contacts">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" xml:space="preserve"><path fill="#282828" d="M100.232 149.198c-2.8 0-5.4-1.8-7.2-5.2-22.2-41-22.4-41.4-22.4-41.6-3.2-5.1-4.9-11.3-4.9-17.6 0-19.1 15.5-34.6 34.6-34.6s34.6 15.5 34.6 34.6c0 6.5-1.8 12.8-5.2 18.2 0 0-1.2 2.4-22.2 41-1.9 3.4-4.4 5.2-7.3 5.2zm.1-95c-16.9 0-30.6 13.7-30.6 30.6 0 5.6 1.5 11.1 4.5 15.9.6 1.3 16.4 30.4 22.4 41.5 2.1 3.9 5.2 3.9 7.4 0 7.5-13.8 21.7-40.1 22.2-41 3.1-5 4.7-10.6 4.7-16.3-.1-17-13.8-30.7-30.6-30.7z"/><path fill="#282828" d="M100.332 105.598c-10.6 0-19.1-8.6-19.1-19.1s8.5-19.2 19.1-19.2c10.6 0 19.1 8.6 19.1 19.1s-8.6 19.2-19.1 19.2zm0-34.3c-8.3 0-15.1 6.8-15.1 15.1s6.8 15.1 15.1 15.1 15.1-6.8 15.1-15.1-6.8-15.1-15.1-15.1z"/></svg>
                            <strong>Address:</strong>
                        </div>
                        <p>123 Emergency Response St., Resilience City</p>
                    </div>
                    <div>
                        <div class="contacts">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px}</style></defs><path class="cls-1" d="m35.51 4.19.85.26a7.67 7.67 0 0 1 5 4.72h0a10.46 10.46 0 0 1 .18 6.61L35 37.12a10.46 10.46 0 0 1-3.82 5.4h0a7.67 7.67 0 0 1-6.76 1.15l-.85-.26A4.47 4.47 0 0 1 21 37l.86-1.56a3.92 3.92 0 0 1 4.57-1.85l1-.54a4.41 4.41 0 0 0 2.1-2.62l3.56-12.07a4.41 4.41 0 0 0-.1-2.79L32.38 14a3.92 3.92 0 0 1-2.77-4.08l.15-1.78a4.47 4.47 0 0 1 5.75-3.95z"/><circle class="cls-1" cx="15" cy="23" r="10"/><path class="cls-1" d="M9 19h4v4H9v4h4M17 19v4h4M21 19v8"/><path class="cls-1" d="M-632-224H68v700h-700z"/></svg>
                            <strong>Hotline:</strong>
                        </div>
                        <p>1-800-DRRM-HELP</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright">
        <p>Copyright © Disaster Risk Reduction Management</p>
        <p>All Rights Reserved</p>
    </div>
</footer>
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
</html>
