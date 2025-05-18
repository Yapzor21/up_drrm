<?php
require_once __DIR__ . '../../../controllers/volunteer_control.php';

// Initialize controller
$controller = new VolunteerTeamsController();

// Get data from controller
$teamVolunteers = $controller->getVolunteersByTeam();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Teams</title>
    <link rel="stylesheet" href="../../assets/css/admin/main_admin.css">
    <link rel="icon" type="image/svg+xml" href="../../assets/images/iconLogo1.svg">
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
                 <ol><a href="#">Admin</a></ol>
                 <ol><a href="teams.php">Teams</a></ol>
                 <ol><a href="../../controllers/logout1.php">Logout</a></ol>
            </ul>
        </nav>
        </div>
        <button id="report-btn"  onclick="openModal('reportModal')">REPORT</button>
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
            <a href="main_dashboard.php">Dashboard</a>
            <a href="#">Admin</a>
            <a href="teams.php">Teams</a>
            <a href="../../controllers/logout1.php">Logout</a>
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

<div class="form-container">
    <div class="form-header">
        <div class="volunteer"><h2>Volunteer Teams</h2></div>
    </div>
    <?php if (empty($teamVolunteers)): ?>
        <div class="no-volunteers">No volunteers have been assigned to teams yet.</div>
    <?php else: ?>
        <?php 
        // Iterate through each team and create a separate table
        foreach ($teamVolunteers as $teamName => $teamMembers): 
        ?>
            <div class="team-section">
                <div class="search-container">
                    <div class="title-header"><h3><?php echo ucwords($teamName); ?> Team</h3></div>
                    <div class="const">
                        <input type="text" id="searchInput" placeholder="Search..." autocomplete="off">
                        <button id="searchButton">Search</button>
                    </div>
                </div>
                <?php if (empty($teamMembers)): ?>
                    <div class="no-volunteers">No volunteers have been assigned to this team yet.</div>
                <?php else: ?>
                    <table class="volunteer-table">
                        <thead>
                            <tr>
                                <th>First Name <span class="sort-icon">↕</span></th>
                                <th>Last Name <span class="sort-icon">↕</span></th>
                                <th>Id <span class="sort-icon">↕</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($teamMembers as $volunteer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($volunteer['first_name']); ?></td>
                                    <td><?php echo htmlspecialchars($volunteer['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($volunteer['admin_id']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

 <?php include '../../partials/footer.php'?>
</body>

<script src="../../assets/js/timelynews.js"></script>
</html>