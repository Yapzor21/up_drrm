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
                 <ol><a href="#">About us</a></ol>
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
            <a href="#" id="admin-link">Account</a>
            <ol> <a href="community.php">About us</a></ol>
            <input type="text" placeholder="Search Here" id="search-box" class="search-box">
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
    
    <!-- modal of report-->
    <div class="modal" id="reportModal" >
        <div class="modal-content" onclick="stopPropagation()" >
            <button class="close-button" onclick="closeModal('reportModal')">×</button>
            <form id="reportForm">
                <div class="form-group">
                    <label for="disasterType">Disaster Type</label>
                    <input type="text" id="disasterType" required>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" required>
                </div>

                <div class="form-group">
                    <label for="Reporter">Name of Reporter</label>
                    <input type="text" id="Reporter" required>
                </div>

                <div class="form-group">
                    <label for="contact">Contact No.</label>
                    <input type="tel" id="contact">
                </div>

                <div class="form-group">
                    <label for="description">Description of Disaster</label>
                    <textarea id="description" required></textarea>
                </div>

                <button type="submit" class="submit-button">Report</button>
            </form>
        </div>
    </div>