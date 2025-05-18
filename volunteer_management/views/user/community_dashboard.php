<?php
require_once '../../controllers/report_control.php';
session_start();


// Create a single controller instance with the database connection
$controller = new UserReportController(null);

// Get all reports
$result = $controller->handleRequest();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Swiper CSS (Must be included) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="../../assets/css/user/main.css">
     <!-- ../../assets/css/user/main.css -->
    <title>Community Dashboard</title>
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
                 <ol><a href="#">Dashboard</a></ol>
                 <ol><a href="community_report.php">Account</a></ol>
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

    <!--heroin-->
    <!-- Swiper Container -->
    <div class="swiper mySwiper">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
            <img src="../../assets/images/EMPOWERING COMMUNITIES, SAVING LIVES. (2).png" alt="Slide 1">
        </div>
        <div class="swiper-slide">
            <img src="../../assets/images/hero11.png" alt="Slide 2">
        </div>
        <div class="swiper-slide">
            <img src="../../assets/images/EMPOWERING COMMUNITIES, SAVING LIVES. (2).png" alt="Slide 3">
        </div>
        <div class="swiper-slide">
            <img src="../../assets/images/hero11.png" alt="Slide 4">
        </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
    <div class="autoplay-progress">
        <svg viewBox="0 0 48 48">
            <circle cx="24" cy="24" r="20"></circle>
        </svg>
        <span></span>
    </div>
</div>
    <div class="container">
        <h1 class="news">Latest News & Updates</h1>
        <div class="news-container">
            <div class="news-grid">
                <!-- News items repeated 4 times -->
                <a href="#" class="news-item">
                    <div class="news-image"> <img src="../../assets/images/puj_accident.jpg" alt=""></div>
                    <h2 class="news-title">PUJ Accident on Kalinga-Abra Road Due to Brake Failure; Vehicle Tumbles Off Roadside.</h2>
                    <div class="news-extend">Read more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path style="fill:#666" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/></svg></div>
                </a>
                <a href="#" class="news-item">
                    <div class="news-image"> <img src="../../assets/images/earthqauke.jpeg" alt=""></div>
                    <h2 class="news-title">Magnitude 5.4 Earthquake Hits Siocon, Zamboanga del Norte; Aftershocks and Damage Expected.</h2>
                    <div class="news-extend">Read more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path style="fill:#666" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/></svg></div>
                </a>
                <a href="#" class="news-item">
                    <div class="news-image"><img src="../../assets/images/TROPICAL STORMS.png" alt=""></div>
                    <h2 class="news-title">Tropical Storm 'Auring' Weakens to Depression; TCWS Alerts Adjusted in Visayas, Mindanao.</h2>
                    <div class="news-extend">Read more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path style="fill:#666" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/></svg></div>
                </a>
                <a href="#" class="news-item">
                    <div class="news-image"><img src="../../assets/images/fire_accident.jpg" alt=""></div>
                    <h2 class="news-title">Baranggay Pag-asa catches fire as one house explodes; Fire spread through Baranggay Gahak and Marulas.</h2>
                    <div class="news-extend">Read more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path style="fill:#666;" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/></svg></div>                  
                </a>
            </div>
        </div>
    </div>

    <!-- carousel news-->
    <div class="carousel-container">
        <div class="carousel">
            <div class="carousel-item">
                <h1 class="feature-title">FEATURE STORY</h1>
                <div class="feature-content">
                    <img src="../../assets/images/drill-manila-nov14-001-scaled.webp" alt="Disaster Preparedness" class="feature-image">
                    <div class="feature-text">
                        <h2>Community Disaster Preparedness and Emergency Response Drill</h2>
                        <p class="feature-date">February 7, 2025</p>
                        <p class="feature-description">On February 7, 2025, the DRRM Volunteer Management Board conducted a community disaster preparedness drill in Barangay San Isidro to strengthen emergency response coordination and train volunteers in disaster risk reduction strategies. The activity aimed to enhance the readiness of volunteers and community members in handling emergency situations such as earthquakes, floods, and fire incidents.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <h1 class="feature-title">FEATURE STORY</h1>
                <div class="feature-content">
                    <img src="../../assets/images/viber_image_2022-10-21_15-41-31-240.jpg" alt="Emergency Training" class="feature-image">
                    <div class="feature-text">
                        <h2>Emergency Response Training Workshop</h2>
                        <p class="feature-date">February 15, 2025</p>
                        <p class="feature-description">A comprehensive training workshop focused on emergency response protocols and disaster management techniques. Participants learned essential skills in first aid, evacuation procedures, and crisis communication.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item">
                <h1 class="feature-title">FEATURE STORY</h1>
                <div class="feature-content">
                    <img src="../../assets/images/joalskjqoiusad9otujlq.jpg" alt="Safety Campaign" class="feature-image">
                    <div class="feature-text">
                        <h2>Community Safety Awareness Campaign</h2>
                        <p class="feature-date">February 22, 2025</p>
                        <p class="feature-description">Launch of a month-long safety awareness campaign targeting local communities. The initiative includes educational seminars, practical demonstrations, and distribution of emergency preparedness materials.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <h1 class="feature-title">FEATURE STORY</h1>
                <div class="feature-content">
                    <img src="../../assets/images/apmcdrr-closing-conference.jpg" alt="Risk Reduction Summit" class="feature-image">
                    <div class="feature-text">
                        <h2>Disaster Risk Reduction Summit</h2>
                        <p class="feature-date">March 1, 2025</p>
                        <p class="feature-description">Annual summit bringing together experts, community leaders, and volunteers to discuss innovative approaches to disaster risk reduction and emergency management strategies.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-buttons">
            <button class="carousel-button prev">&lt;</button>
            <button class="carousel-button next">&gt;</button>
        </div>
        <div class="carousel-dots"></div>
    </div>

  <!--footer sheeshh-->

    <?php
    include '../../partials/footer.php';
    ?>
  
    <script src="../../assets/js/header.js"></script>
    <script src="../../assets/js/modal.js"></script>
    <script src="../../assets/js/carousel.js"></script>
    <script src="../../assets/js/timelynews.js"></script>
    <script src="../../assets/js/dropdown.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../../assets/js/swiper.js"></script>
</body>
</html>
