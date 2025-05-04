<?php
require_once '../../controllers/report_control.php';
require_once '../../controllers/assigned_control.php';
require_once '../../controllers/personnel_control.php';


// Initialize controllers
$personnelController = new PersonnelController();
$reportController = new UserReportController(null);


// Get personnel by status using the controller
$deployed = $personnelController->getPersonnelByStatus('deployed');
$standby = $personnelController->getPersonnelByStatus('standby');
$oncall = $personnelController->getPersonnelByStatus('oncall');

// Get all reports based on user actions
$result = $reportController->handleRequest();
$message = $reportController->getMessage();


require_once '../../model/assigned.php';
require_once '../../model/teams.php';
require_once '../../config/database.php';


// Create database connection
$database = new Database();
$db = $database->connect();


$team = new Team($db);
$assignment = new Assignment($db);

// Get all teams
$teams = $team->getAllTeams();

// Check if a report ID is provided for assignment
$reportIdForAssignment = isset($_GET['report_id']) ? $_GET['report_id'] : null;
$showAssignModal = isset($_GET['action']) && $_GET['action'] === 'assign';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/admin/main_admin.css">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel = "icon" type="image/svg+xml" href="../../assets/images/iconLogo1.svg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <!-- jQuery -->
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


   <?php
   include '../../partials/header.php';
   ?>

    <!-- create alert-->
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

    <!-- assigned team  -->
  <!-- Assign Team Modal -->
<div class="modal" id="assignModal" <?php echo $showAssignModal ? 'style="display: block;"' : ''; ?>>
    <div class="modal-content">
        <span class="close" onclick="closeModal('assignModal')">&times;</span>
        <h3>Assign Team</h3>
        <form id="assignTeamForm" method="post" action="../../controllers/assigned_control.php">
            <input type="hidden" id="report_id" name="report_id" value="<?php echo $reportIdForAssignment; ?>">
            
            <div class="form-group">
                <label for="timeStarted">Time Started</label>
                <input type="time" id="timeStarted" name="timeStarted" required>
            </div>

            <div class="form-group">
                <?php foreach ($teams as $teamItem): ?>
                <div>
                    <input type="checkbox" name="<?php echo strtolower($teamItem['name']); ?>" id="team_<?php echo $teamItem['id']; ?>">
                    <label for="team_<?php echo $teamItem['id']; ?>"><?php echo ucfirst($teamItem['name']); ?></label>
                </div>
                <?php endforeach; ?>
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
            <div class="const"> <input type="text" id="searchInput" placeholder="Search reports..." autocomplete="off">
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
            <i class='fas fa-user-plus assign-btn' style='cursor:pointer;' data-id='" . $row["Report_Id"] . "' title='Assign'></i>
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
            <div class="title-header"><h3>Report Details</h3></div>
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
                     if ($result && is_array($result) && count($result) > 0) {
                        foreach($result as $row) { 
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
  <?php
   include '../../partials/footer.php';
   ?>
</body>
<script src="../../assets/js/timelynews.js"></script>
<script src="../../assets/js/modal.js"></script>
<script src="../../assets/js/dropdown.js"></script>
<script src="../../assets/js/assigned.js"></script>
<script src="../../assets/js/header.js"></script>
<script src="../../assets/js/ajax.js"></script>
<script src="../../assets/js/report_ajax.js"></script>

</html> 