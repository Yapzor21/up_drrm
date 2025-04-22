<?php
require_once '../../controllers/report_control.php';
require_once '../../controllers/assigned_control.php';
require_once '../../controllers/personnel_control.php';

// Initialize controllers
$personnelController = new PersonnelController();
$reportController = new UserReportController(null);
$teamController = new TeamController(null);

// Get personnel by status using the controller
$deployed = $personnelController->getPersonnelByStatus('deployed');
$standby = $personnelController->getPersonnelByStatus('standby');
$oncall = $personnelController->getPersonnelByStatus('oncall');

// Get all reports based on user actions
$result = $reportController->handleRequest();

// Get all team assignments
$final = $teamController->handleRequest();

$message = $reportController->getMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOVPH DRRM Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/admin/main_admin.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
                 <ol><a href="main_dashboard.php">Dashboard</a></ol>
                 <ol><a href="volunteer_dispatchment.php">Dispatch</a></ol>
                 <ol><a href="#">Admin</a></ol>
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
            <a href="main_dashboard.php" id="dashboard-link">Dashboard</a>
            <a href="volunteer_dispatchment.php" id="community-link">Dispatch</a>
            <a href="#" id="admin-link">Admin</a>
        </nav>
    </header>

    <!-- sub-header 
     
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

          <div class="button-containers">
            <button class="btns btn-alert" id="btnAlert" onclick="openModal('reportModal')">Create Alert</button>
        </div>
    </div>
    

    //original
      <button id="report-btn" class="report-btn" onclick="openModal('reportModal')">REPORT</button>
    
    -->

    <div id="sub-header">
        <div id="drrm-logor">
            <img src="../../assets/images/Frame 1 (1).svg" alt="">
        </div>
        <div id="right-section">
        <button class="btns btn-alert" id="btnAlert" onclick="openModal('reportModal')">Create Alert</button>
            <div id="time-box">
                <div id="time-label">Philippine Standard Time</div>
                <div id="ph-time" class="time"></div>
                <div id="ph-date" class="date"></div>
            </div>
        </div>
    </div>


    <!-- create alert-->
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


    <!-- assigned team  -->
    <div class="modal" id="assignModal">
    <div class="modal-content">
         <span class="close">&times;</span>
        <h3>Assign Team</h3>
        <form id="assignTeamForm" method="post" action="../../controllers/assigned_control.php">
            <input type="hidden" id="report_id" name="report_id">
         
            <div class="form-group">
                <label for="timeStarted">Time Started</label>
                <input type="time" id="timeStarted" name="timeStarted" required>
            </div>

            <div class="form-group">
                <label for="assignedTeam">Assigned Team</label>
                <input type="text" id="assignedTeam" name="assignedTeam" required>
            </div>

            <div class="confirm">
                <button type="submit" name="assign_submit" class="submit-button">Assign Team</button>
                <button type="button" onclick="closeModal('assignModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>


        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="modal">
        <div class="modal-content">
        <span class="close" onclick="closeModal('updateTeamModal')">&times;</span>
            <h3>Confirm Delete</h3>
            <p>Are you sure you want to delete this report?</p>
            <form method="post" action="../../controllers/report_control.php">
                <input type="hidden" id="delete_report_id" name="report_id">
                <div class="confirm">
                <button type="submit" name="delete" id="delete">Yes, Delete</button>
                <button type="button" id="cancelDelete">Cancel</button>
                </div>          
            </form>
        </div>
    </div>

 <!-- Update assigned team Modal -->
<div id="updateTeamModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Update Team Assignment</h3>
        <form method="post" action="../../controllers/assigned_control.php">
            <input type="hidden" id="update_team_id" name="report_id">
            <div class="form-group">
                <label for="updateDisasterType">Disaster Type</label>
                <input type="text" id="updateDisasterType" name="disasterType" disabled>
            </div>

            <div class="form-group">
                <label for="updateTimeStarted">Time Started</label>
                <input type="time" id="updateTimeStarted" name="timeStarted"  required>
            </div>

            <div class="form-group">
                <label for="updateAssignedTeam">Assigned Team</label>
                <input type="text" id="updateAssignedTeam" name="assignedTeam" required>
            </div>

            <div class="form-group">
                <label for="updateAffectedAreas">Affected Areas</label>
                <input type="text" id="updateAffectedAreas" name="affectedAreas" required>
            </div>
            <div class="confirm">
                <button type="submit" name="update_team_submit" class="submit-button">Update Assignment</button>
                <button type="button" onclick="closeModal('updateTeamModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>


<!-- Update report Modal  -->
<div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Update Report</h3>
            <form method="post" action="../../controllers/report_control.php">

                <input type="hidden" id="update_report_id" name="report_id">
                <div class="form-group">
                    <label for="disasterType">Disaster Type:</label>
                    <input type="text" id="disasterType" name="disasterType" required>
                </div>
                
                <div class="form-group">
                    <label for="location">Address:</label>
                    <input type="text" id="location" name="location" required>

                <label for="city" style="margin-top: 8px;">City:</label>
                <select id="city" name="city" required>
                <option value="" disabled selected>Select City</option>
                <!-- Cities will be populated via JavaScript -->
                </select>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="reporter">Name of Reporter:</label>
                    <input type="text" id="reporter" name="reporter" required>
                </div>
                
                <div class="form-group">
                    <label for="contact">Contact Number:</label>
                    <input type="text" id="contact" name="contact" required>
                </div>
                
                <div class="confirm">
                <button type="submit" name="update_submit" id="update">Update Report</button>
                <button type="button" id="cancelUpdate">Cancel</button>
                </div>
            </form>
        </div>
    </div>


<div class="wrapper">
    <div class="main-content">

         <div class="table-container">
            <div class="search-container">
            <div class="title-header"><h3>Reports</h3></div>
            <div class="const"> <input type="text" id="searchInput" placeholder="Search reports...">
            <button id="searchButton">Search</button></div>
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
                        <th>Operation </th>
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
        echo "<td>
            <i class='fas fa-edit edit-btn' style='cursor:pointer; margin: 0 8px;' data-id='" . $row["Report_Id"] . "'></i>
            <i class='fas fa-trash delete-btn' style='cursor:pointer;' data-id='" . $row["Report_Id"] . "'></i>
        </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='9' style='text-align:center'>No reports found</td></tr>";
}
?>

                </tbody>
            </table>
        </div>


        <!-- Add this modal for viewing report details -->
<div id="viewReportModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('viewReportModal')">&times;</span>

        <div class="table-containers">
        <div class="search-container">
            <div class="title-header"><h3>Assigned Team</h3></div>
            <!-- <div class="const"> <input type="text" id="searchInput" placeholder="Search team...">
            <button id="searchButton">Search</button></div>  -->
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Disaster Type</th>
                        <th>Time Started</th>
                        <th>Assigned Team</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                     if ($final && is_array($final) && count($final) > 0) {
                        foreach($final as $row) { 
                            echo "<td>" . $row["Disaster_Type"] . "</td>";

                            // remove the miliseconds and microseconds
                            $time = date('H:i', strtotime($row["time_started"]));
                            echo "<td>" . $time . " " . $row["Date_Reported"] . "</td>";
                            echo "<td>" . $row["assigned_team"] . "</td>";
                            echo "<td>
                                <i class='fas fa-user-plus assign-btn' style='cursor:pointer;' data-id='" . $row["Report_Id"] . "' title='Assign'></i>
                                <i class='fas fa-edit edit-btn' style='cursor:pointer; margin: 0 8px;' data-id='" . $row["Report_Id"] . "' title='Update'></i>
                                <i class='fas fa-trash delete-btn' style='cursor:pointer;' data-id='" . $row["Report_Id"] . "' title='Delete'></i>
                              </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center'>No team assignments found</td></tr>";
                    }
                ?>
            </tbody>
            </table>
        </div>

        
    </div>
</div>

        <div class="table-container">
        <div class="search-container">
            <div class="title-header"><h3>Responses</h3></div>
            <div class="const"> <input type="text" id="searchInput" placeholder="Search responses...">
            <button id="searchButton">Search</button></div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Skillset</th>
                        <th>Response</th>
                    </tr>
                </thead>
                <tbody id="personnel-table">
                    <tr>
                        <td>Jobert Pedro</td>
                        <td>09770757048</td>
                        <td>Medical, First Aid</td>
                        <td>Yes</td>
                    </tr>
                </tbody>
            </table>
            <div class="print_report">
                <form method="POST" action="../../controllers/pdf.php">
                <button class="print_report_bts" type="submit">Print Report</button>

                </form>

            </div>
        </div>
    </div>

    <div class="personnel-sidebar">
        <div class="personnel">
            <h6>Personnel</h6> 
            <img src="../../assets/images/down-arrow-svgrepo-com.svg" alt="Toggle" id="toggle-sidebar">
        </div>
        
        <div class="personnel-section">
            <div class="section-title">Deployed</div>
            <ul class="personnel-list" id="deployed-list">
                <?php foreach ($deployed as $person): ?>
                <li class="personnel-item" data-id="<?php echo $person['id']; ?>" data-status="deployed">
                    <span class="status-indicator deployed"></span>
                    <span><?php echo $person['name']; ?></span>
                    <div class="actions">⋮</div>
                    <div class="status-dropdown">
                        <div class="status-option" data-status="deployed">Deployed</div>
                        <div class="status-option" data-status="standby">Stand By</div>
                        <div class="status-option" data-status="oncall">On Call</div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="personnel-section">
            <div class="section-title">Stand By</div>
            <ul class="personnel-list" id="standby-list">
                <?php foreach ($standby as $person): ?>
                <li class="personnel-item" data-id="<?php echo $person['id']; ?>" data-status="standby">
                    <span class="status-indicator standby"></span>
                    <span><?php echo $person['name']; ?></span>
                    <div class="actions">⋮</div>
                    <div class="status-dropdown">
                        <div class="status-option" data-status="deployed">Deployed</div>
                        <div class="status-option" data-status="standby">Stand By</div>
                        <div class="status-option" data-status="oncall">On Call</div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="personnel-section">
            <div class="section-title">On Call</div>
            <ul class="personnel-list" id="on-call-list">
                <?php foreach ($oncall as $person): ?>
                <li class="personnel-item" data-id="<?php echo $person['id']; ?>" data-status="oncall">
                    <span><?php echo $person['name']; ?></span>
                    <span class="phone-icon" onclick="makeCall('<?php echo $person['phone']; ?>')">📞</span>
                    <div class="actions">⋮</div>
                    <div class="status-dropdown">
                        <div class="status-option" data-status="deployed">Deployed</div>
                        <div class="status-option" data-status="standby">Stand By</div>
                        <div class="status-option" data-status="oncall">On Call</div>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <div class="toast" id="toast"></div>


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
<script src="../../assets/js/timelynews.js"></script>
<script src="../../assets/js/modal.js"></script>
<script src="../../assets/js/dropdown.js"></script>
<script src="../../assets/js/assigned.js"></script>
<script src="../../assets/js/header.js"></script>
<script src="../../assets/js/ajax.js"></script>
</html> 