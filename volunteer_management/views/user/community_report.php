<?php
require_once '../../controllers/report_control.php';

// instanciate a class to access the methods and properties of the class
$controller = new UserReportController(null);

// ga based sa actions sang user so ang deafult action is to view all reports
$result = $controller->handleRequest();

$message = $controller->getMessage();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOVPH DRRM Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/admin/main_dashboard.css">
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
                 <ol><a href="community_dashboard.php">Dashboard</a></ol>
                 <ol><a href="#">Account</a></ol>
                 <ol><a href="../../controllers/logout1.php">Logout</a></ol>
            </ul>
        </nav>
        </div>
        <button id="report-btn"  onclick="openModal('reportModal')">REPORT</button>
    </div>

    <?php
    include '../../partials/header.php';
    ?>
    
     <!-- modal of report-->
     <div class="modal" id="reportModal" >
        <div class="modal-content" onclick="stopPropagation()" >
            <button class="close-button" onclick="closeModal('reportModal')">×</button>
            <h3>Report Disaster</h3>
            <form id="reportForm" method="POST" action="../../controllers/report_control.php" >
               
                <input type="hidden" id="edit_report_id" name="report_id">
                <div class="form-group">
                    <label for="disasterType">Disaster Type:</label>
                    <input type="text" name="disasterType" id="disasterType" required>
                </div>

           <div class="form-group">
            <label for="location">Address:</label>
            <input type="text" name="location" id="address" required>
    
            <label for="city" style="margin-top: 8px;">City:</label>
            <select id="city" name="city" required>
            <option value="" disabled selected>Select City</option>
                <!-- Cities will be populated via JavaScript -->
            </select>
            </div>
    
                <div class="form-group">
                    <label for="Reporter">Name of Reporter:</label>
                    <input type="text" name="reporter" id="Reporter" required>
                </div>

                <div class="form-group">
                    <label for="contact">Contact No.:</label>
                    <input type="tel" name="contact" id="contact">
                </div>

                <div class="form-group">
                    <label for="description">Description of Disaster:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <button type="submit" name="submit_report" class="submit-button" onclick="clicks()">Report</button>
            </form>
        </div>
    </div>
    
  
    <div class="main-contents">
        
            <!-- Reports Table -->
            <div class="table-container">
                <div class="search-container">
                    <div class="title-header"><h3>Reports</h3></div>
                    <div class="const">
                        <input type="text" id="searchInput" placeholder="Search reports..." autocomplete="off">
                        <button id="searchButton">Search</button>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Report_Id</th>
                            <th>Disaster Type</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Description</th>
                            <th>Name of Reporter</th>
                            <th>Contact Number</th>
                            <th>Date_Reported</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && is_array($result) && count($result) > 0) {
                            foreach($result as $row) { 
                                echo "<tr>";
                                echo "<td>" . $row["Report_Id"] . "</td>";
                                echo "<td>" . $row["Disaster_Type"] . "</td>";
                                echo "<td>" . $row["Location"] . "</td>";
                                echo "<td>" . $row["City"] . "</td>";
                                echo "<td>" . $row["Description"] . "</td>";
                                echo "<td>" . $row["Name_of_Reporter"] . "</td>";
                                echo "<td>" . $row["Contact_Number"] . "</td>";
                                echo "<td>" . $row["Date_Reported"] . "</td>";
                            }
                        } else {
                            echo "<tr><td colspan='9' style='text-align:center'>No reports found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            </div>
  <!--footer sheeshh-->
  
    <?php
    include '../../partials/footer.php';
    ?>
  
</body>
    <script src="../../assets/js/header.js"></script>
    <script src="../../assets/js/modal.js"></script>
    <script src="../../assets/js/carousel.js"></script>
    <script src="../../assets/js/timelynews.js"></script>
    <script src="../../assets/js/dropdown.js"></script>
    <script src="../../assets/js/report_ajax.js"></script>

</html>
