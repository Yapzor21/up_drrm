<?php
require_once '../../controllers/report_control.php';
require_once '../../controllers/assigned_control.php';
require_once '../../controllers/personnel_control.php';
require_once '../../model/assigned.php';
require_once '../../model/teams.php';
require_once '../../config/database.php';

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

// Display notifications
$notification = '';
$notificationType = '';

if (isset($_GET['success']) && $_GET['success'] == 'assigned') {
    $notification = 'Teams successfully assigned to the report.';
    $notificationType = 'success';
} else if (isset($_GET['info']) && $_GET['info'] == 'already_assigned') {
    $notification = 'All selected teams were already assigned to this report.';
    $notificationType = 'info';
} else if (isset($_GET['error']) && $_GET['error'] == 'assignment_failed') {
    $notification = 'Failed to assign teams to the report.';
    $notificationType = 'error';
}
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
    <link rel="icon" type="image/svg+xml" href="../../assets/images/iconLogo1.svg">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
</head>
<body>
    <div id="overlay"></div>
    
    <!-- Sidebar -->
    <div id="sidebar" onclick="stopPropagation()">
        <div class="close">  
            <button class="sidebar-close" onclick="toggleSidebar()">×</button>
        </div>   
        <div class="menu">
            <nav>
                <ul>
                    <ol><a href="main_dashboard.php">Dashboard</a></ol>
                    <ol><a href="volunteer_dispatchment.php">Dispatch</a></ol>
                    <ol><a href="#">Admin</a></ol>
                </ul>
            </nav>
        </div>
        <button onclick="openModal('reportModal')">REPORT</button>
    </div>

    <!-- Header -->
    <header id="top-header">
        <div class="logos">
            <a href="#" id="drrm-logo">
                <img src="../../assets/images/Group 2829.png" alt="">
            </a>
            <a href="#" id="govph-logo">
                <img src="../../assets/images/Frame 3 (1).svg" alt="">
            </a>
        </div>
        <button id="menu-toggle" onclick="toggleSidebar()">☰</button>
        <nav id="nav-menu">
            <a href="community_dashboard.php">Dashboard</a>
            <a href="../views/user/community_report.php">Account</a>
            <a href="../views/admin/main_admin.php">Admin</a>
            <ol><a href="community.php">About us</a></ol>
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

    <!-- Assign Team Modal -->
    <div class="modal" id="assignModal" <?php echo $showAssignModal ? 'style="display: flex;"' : ''; ?>>
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
                    <label>Select Teams to Assign</label>
                    <?php if ($teams && is_array($teams)): ?>
                        <?php foreach ($teams as $teamItem): ?>
                        <div class="checkbox-item">
                            <input type="checkbox" name="<?php echo strtolower($teamItem['name']); ?>" id="team_<?php echo $teamItem['id']; ?>">
                            <label for="team_<?php echo $teamItem['id']; ?>"><?php echo ucfirst($teamItem['name']); ?></label>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No teams available</p>
                    <?php endif; ?>
                </div>
                <div class="confirm">
                    <button type="submit" name="assign_submit" class="submit-button">Assign Team</button>
                    <button type="button" onclick="closeModal('assignModal')" class="cancel-button">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteModal')">&times;</span>
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
            <span class="close" onclick="closeModal('updateTeamModal')">&times;</span>
            <h3>Update Team Assignment</h3>
            <form method="post" action="">
                <input type="hidden" id="update_team_id" name="report_id">
                <div class="form-group">
                    <label for="updateDisasterType">Disaster Type</label>
                    <input type="text" id="updateDisasterType" name="disasterType" disabled>
                </div>
                <div class="form-group">
                    <label for="updateTimeStarted">Time Started</label>
                    <input type="time" id="updateTimeStarted" name="timeStarted" required>
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

    <!-- Update report Modal -->
    <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('updateModal')">&times;</span>
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

    <!-- Main Content -->
    <div class="wrapper">
        <div class="main-content">
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
                            <th>Operation</th>
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

            <!-- Assignment Details Section -->
            <?php if ($reportId): ?>
            <div class="table-container">
                <h2>Assignment Details for Report #<?php echo htmlspecialchars($reportId); ?></h2>
                <?php if (!empty($assignmentDetails)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Disaster Type</th>
                                <th>Location</th>
                                <th>City</th>
                                <th>Assigned Teams</th>
                                <th>Time Started</th>
                                <th>Date Assigned</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($assignmentDetails as $detail): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($detail['Disaster_Type']); ?></td>
                                <td><?php echo htmlspecialchars($detail['Location']); ?></td>
                                <td><?php echo htmlspecialchars($detail['City']); ?></td>
                                <td><?php echo htmlspecialchars($detail['team_names']); ?></td>
                                <td><?php echo htmlspecialchars(date('h:i A', strtotime($detail['time_started']))); ?></td>
                                <td><?php echo htmlspecialchars(date('M d, Y', strtotime($detail['date_assigned']))); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="no-data">No assignment details found for this report.</div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- All Team Assignments Section -->
            <div class="container">
                <h2>All Team Assignments</h2>
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

            <!-- Responses Table -->
            <div class="table-container">
                <div class="search-container">
                    <div class="title-header"><h3>Responses</h3></div>
                    <div class="const">
                        <input type="text" id="searchInput" placeholder="Search responses...">
                        <button id="searchButton">Search</button>
                    </div>
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

       <!-- Personnel Sidebar -->
<div class="personnel-sidebar">
    <div class="personnel">
        <h6>Personnel</h6> 
        <img src="../../assets/images/down-arrow-svgrepo-com.svg" alt="Toggle" id="toggle-sidebar">
    </div>
    
    <div class="personnel-section">
        <div class="section-title">Deployed</div>
        <ul class="personnel-list" id="deployed-list">
            <?php foreach ($deployed as $person): ?>
            <li class="personnel-item" data-id="<?php echo $person['admin_id']; ?>" data-status="deployed">
                <span class="status-indicator deployed"></span>
                <span><?php echo $person['first_name'] . ' ' . $person['middle_name'][0] . '. ' . $person['last_name']; ?></span>
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
            <li class="personnel-item" data-id="<?php echo $person['admin_id']; ?>" data-status="standby">
                <span class="status-indicator standby"></span>
                <span><?php echo $person['first_name'] . ' ' . $person['middle_name'][0] . '. ' . $person['last_name']; ?></span>
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
            <li class="personnel-item" data-id="<?php echo $person['admin_id']; ?>" data-status="oncall">
                <span class="status-indicator oncall"></span>
                <span><?php echo $person['first_name'] . ' ' . $person['middle_name'][0] . '. ' . $person['last_name']; ?></span>
                <span class="phone-icon">📞</span>
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
    <!-- Footer -->
     <?php include '../../partials/footer.php'?>
    <!-- Scripts -->
    <script src="../../assets/js/timelynews.js"></script>
    <script src="../../assets/js/modal.js"></script>
    <script src="../../assets/js/dropdown.js"></script>
    <script src="../../assets/js/assigned.js"></script>
    <script src="../../assets/js/header.js"></script>
    <script src="../../assets/js/ajax.js"></script>
    <script src="../../assets/js/report_ajax.js"></script>
</body>
</html>