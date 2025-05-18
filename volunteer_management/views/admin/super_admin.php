<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account</title>
  <link rel="stylesheet" href="../../assets/css/admin/super_admin_dashboard.css">

  <link rel = "icon" type="image/svg+xml" href="../../assets/images/iconLogo1.svg">

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
                 <ol><a href="main_admin.php">Admin</a></ol>
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
            <a href="main_admin.php">Admin</a>
            <a href="teams.php">Teams</a>
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
    
    <div class="main-contents">

    
  <div class="form-container">
    <div class="form-header">
      <h2>Create Account</h2>
      <p>Join our team and make a difference</p>
    </div>
    
  <form action="../../controllers/super_admin.php" method="post">
  <div class="form-row">
    <div class="form-group">
      <label for="fname">First Name</label>
      <input type="text" id="fname" name="fname" placeholder="Enter first name" required>
    </div>
    <div class="form-group">
      <label for="mname">Middle Name</label>
      <input type="text" id="mname" name="mname" placeholder="Enter middle name" required>
    </div>
    <div class="form-group">
      <label for="lname">Last Name</label>
      <input type="text" id="lname" name="lname" placeholder="Enter last name" required>
    </div>
  </div>

  <div class="form-group">
    <label for="contact_num">Contact Number</label>
    <input type="text" id="contact_num" name="contact_num" placeholder="Enter contact number" required>
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Create a strong password" required>
    <div class="password-strength"></div>
  </div>

  <div class="form-group">
    <label for="confirm_password">Confirm Password</label>
    <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat password" required>
  </div>

  <div class="form-group">
    <label>Select Role</label>
    <div class="role-options">
      <div class="role-option">
        <input type="radio" id="admin" name="role" value="admin" checked>
        <label for="admin">
          <span class="role-icon">👑</span>
          Admin
        </label>
      </div>

      <div class="role-option">
        <input type="radio" id="volunteer" name="role" value="volunteer">
        <label for="volunteer">
          <span class="role-icon">🤝</span>
          Volunteer
        </label>
      </div>

  <div class="form-group" id="volunteer-dropdown" style="display: none;">
  <label for="volunteerType">Select Volunteer Type</label>
  <select id="volunteerType" name="volunteerType">
    <option value="">-- Select Type --</option>
    <option value="medical">Medical Volunteer</option>
    <option value="rescue">Rescue Volunteer</option>
    <option value="logistics">Logistics Volunteer</option>
    <option value="fire">Fire Volunteer</option>
  </select>
</div>

    </div>
  </div>

  <button type="submit">Create Account</button>
</form>

  </div>
  </div>
<script src="../../assets/js/super_admin.js"></script>
<script src="../../assets/js/timelynews.js"></script>
</body>
</html>