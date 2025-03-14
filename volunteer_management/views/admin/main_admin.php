<?php
// Include database connection
require_once '../../config/database.php';
$sql = "SELECT * FROM user_report ORDER BY Date_Reported DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOVPH DRRM Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/admin/main_admin.css">
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

    <div class="modal" id="recordModal" >
        <div class="modal-content" onclick="stopPropagation()" >
            <button class="close-button"  onclick="closeModal('recordModal')">×</button>
            <h3>New Record</h3>

            <form id="reportForm">
                <div class="form-group">
                    <label for="disasterType">Disaster Type</label>
                    <input type="text" id="disasterType" required>
                </div>

                <div class="form-group">
                    <label for="location"> Time Started</label>
                    <input type="datetime-local" id="time" required>
                </div>

                <div class="form-group">
                    <label for="Assigned Team">Assigned Team </label>
                    <input type="text" id="Team" required>
                </div>

                <div class="form-group">
                    <label for="Affected Areas">Affected Areas</label>
                    <textarea id="Areas" required></textarea>
                </div>
                <button type="submit" class="submit-button"> Insert Records </button>
            </form>
        </div>
    </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
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
    
    <!-- Update Modal -->
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
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" required>
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
                        <th>Disaster Type</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Name of Reporter</th>
                        <th>Contact Number</th>
                        <th>Date_Reported</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="resources-table">
                <?php
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { 
                                echo "<td>" . $row["Disaster_Type"] . "</td>";
                                echo "<td>" . $row["Location"] . "</td>";
                                echo "<td>" . $row["Description"] . "</td>";
                                echo "<td>" . $row["Name_of_Reporter"] . "</td>";
                                echo "<td>" . $row["Contact_Number"] . "</td>";
                                echo "<td>" . $row["Date_Reported"] . "</td>";
                                echo "<td>
                                        <button class='edit-btn' data-id='" .   $row["Report_Id"] . "'>Edit</button>
                                        <button class='delete-btn' data-id='" . $row["Report_Id"] . "'>Delete</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' style='text-align:center'>No reports found</td></tr>";
                        }
                        ?>
                </tbody>
            </table>
        </div>

        <div class="table-container">
        <div class="search-container">
            <div class="title-header"><h3>Assigned Team</h3></div>
            <div class="const"> <input type="text" id="searchInput" placeholder="Search team...">
            <button id="searchButton">Search</button></div>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Disaster Type</th>
                        <th>Time Started</th>
                        <th>Assigned Team</th>
                        <th>Affected Areas</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="disaster-table">
                    <tr>
                        <td>Medical Emergency</td>
                        <td>2025-03-12 9:35:20 am</td>
                        <td>Medical Team</td>
                        <td>Barangay 44, Bacolod City</td>
                        <td>
                            <button class="edit-btn">Edit</button>
                            <button class="delete-btn">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="button-containers">
            <button class="btns btn-new" id="btnNew" onclick="openModal('recordModal')">New Records</button>
            <button class="btns btn-alert" id="btnAlert" onclick="openModal('reportModal')">Create Alert</button>
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
        </div>

       
    </div>

    <div class="personnel-sidebar">
        <div class="personnel">
            <h6>Personnel</h6> 
            <img src="../../assets\images\down-arrow-svgrepo-com.svg" alt="">
         </div>
        <div class="personnel-section">
            <div class="section-title">Deployed</div>
            <ul class="personnel-list" id="deployed-list">
                <li class="personnel-item">
                    <span class="status-indicator deployed"></span>
                    <span>Mark Cantos</span>
                </li>
                <li class="personnel-item">
                    <span class="status-indicator deployed"></span>
                    <span>Mark Cantos</span>
                </li>
                <li class="personnel-item">
                    <span class="status-indicator deployed"></span>
                    <span>Mark Cantos</span>
                </li>
            </ul>
        </div>

        <div class="personnel-section">
            <div class="section-title">Stand By</div>
            <ul class="personnel-list" id="standby-list">
                <li class="personnel-item">
                    <span class="status-indicator standby"></span>
                    <span>Mark Cantos</span>
                </li>
                <li class="personnel-item">
                    <span class="status-indicator standby"></span>
                    <span>Mark Cantos</span>
                </li>
            </ul>
        </div>

        <div class="personnel-section">
            <div class="section-title">On Call</div>
            <ul class="personnel-list" id="on-call-list">
                <li class="personnel-item">
                    <span>Mark Cantos</span>
                    <span class="phone-icon" onclick="makeCall('09770757048')">📞</span>
                </li>
                <li class="personnel-item">
                    <span>Mark Cantos</span>
                    <span class="phone-icon" onclick="makeCall('09770757048')">📞</span>
                </li>
                <li class="personnel-item">
                    <span>Mark Cantos</span>
                    <span class="phone-icon" onclick="makeCall('09770757048')">📞</span>
                </li>
            </ul>
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
<script src="../../assets/js/timelynews.js"></script>
<script src="../../assets/js/modal.js"></script>
<script src="../../assets/js/modal.js"></script>
</html>
