<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOVPH DRRM Dashboard</title>
   <link rel="stylesheet" href="/login&create_account_admin_community/USER_DASHBOARD/main.css">
   
</head>
<body>
    <div class="overlay" id="overlay"></div>
    <div class="sidebar" id="sidebar" onclick="stopPropagation()">
        <button class="sidebar-close" onclick="toggleSidebar()">×</button>
        <nav class="nav-menu">
            <ul>
                 <ol><a href="#">Dashboard</a></ol>
                 <ol> <a href="#">Community</a></ol>
                 <ol> <a href="#">Admin</a></ol>
            </ul>
        </nav>
        <input type="text" placeholder="Search Here" class="search-box">
        <button class="report-btn"  onclick="openModal()">REPORT</button>
    </div>

    <header class="top-header">
        <a href="#" class="govph-logo">
            <img src="/login&create_account_admin_community/USER_DASHBOARD/images/Frame 3.svg" alt="">
        </a>
        <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
        <nav class="nav-menu">
            <a href="#">Dashboard</a>
            <a href="#">Community</a>
            <a href="#">Admin</a> <input type="text" placeholder="Search Here" class="search-box">
        </nav>
    </header>

    <div class="sub-header">
        <div class="drrm-logo">
           <img src="/login&create_account_admin_community/USER_DASHBOARD/images/Frame 1 (1).svg" alt="">
        </div>
        <div class="right-section">
            <button class="report-btn" onclick="openModal()">REPORT</button>
            <div class="time-box">
                <div>Philippine Standard Time</div>
                <div class="time" id="ph-time"></div>
                <div class="date" id="ph-date"></div>
            </div>
        </div>
    </div>

    <!-- modal of report-->
    <div class="modal" id="reportModal" >
        <div class="modal-content" onclick="stopPropagation()" >
            <button class="close-button" onclick="closeModal()">×</button>
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
    <!--heroin-->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Empowering Communities, Saving Lives</h1>
        </div>
    </section>

    <div class="container">
        <h1 class="news">Latest News & Updates</h1>
        <div class="news-container">
            <div class="news-grid">
                <!-- News items repeated 4 times -->
                <a href="#" class="news-item">
                    <div class="news-image"> <img src="/login&create_account_admin_community/USER_DASHBOARD/images/road accident.png" alt=""></div>
                    <h2 class="news-title">PUJ Accident on Kalinga-Abra Road Due to Brake Failure; Vehicle Tumbles Off Roadside.</h2>
                    <div class="news-extend">Read more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path style="fill:#666" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/></svg></div>
                </a>
                <a href="#" class="news-item">
                    <div class="news-image"> <img src="/login&create_account_admin_community/USER_DASHBOARD/images/earth quake.png" alt=""></div>
                    <h2 class="news-title">Magnitude 5.4 Earthquake Hits Siocon, Zamboanga del Norte; Aftershocks and Damage Expected.</h2>
                    <div class="news-extend">Read more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path style="fill:#666" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/></svg></div>
                </a>
                <a href="#" class="news-item">
                    <div class="news-image"><img src="/login&create_account_admin_community/USER_DASHBOARD/images/TROPICAL STORMS.png" alt=""></div>
                    <h2 class="news-title">Tropical Storm 'Auring' Weakens to Depression; TCWS Alerts Adjusted in Visayas, Mindanao.</h2>
                    <div class="news-extend">Read more <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25"><path style="fill:#666" d="m17.5 5.999-.707.707 5.293 5.293H1v1h21.086l-5.294 5.295.707.707L24 12.499l-6.5-6.5z" data-name="Right"/></svg></div>
                </a>
                <a href="#" class="news-item">
                    <div class="news-image"><img src="/login&create_account_admin_community/USER_DASHBOARD/images/fire.png" alt=""></div>
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
                    <img src="/login&create_account_admin_community/USER_DASHBOARD/images/fire.png" alt="Disaster Preparedness" class="feature-image">
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
                    <img src="/login&create_account_admin_community/USER_DASHBOARD/images/earth quake.png" alt="Emergency Training" class="feature-image">
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
                    <img src="/login&create_account_admin_community/USER_DASHBOARD/images/road accident.png" alt="Safety Campaign" class="feature-image">
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
                    <img src="/login&create_account_admin_community/USER_DASHBOARD/images/TROPICAL STORMS.png" alt="Risk Reduction Summit" class="feature-image">
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

  <footer class="footer">
    <div class="footer-content">
        <div class="footer-grid">
            <div class="footer-logo">
                <div class="logo_1"> <img src="/login&create_account_admin_community/USER_DASHBOARD/images/Rectangle 1079.png" alt=""></div>

                <div class="logo_2"> <img src="/login&create_account_admin_community/USER_DASHBOARD/images/Group 2829.png" alt=""></div>
               
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
<script src="/login&create_account_admin_community/USER_DASHBOARD/js/modal.js"></script>
<script src="/login&create_account_admin_community/USER_DASHBOARD/js/timelynews.js"></script>
<script src="/login&create_account_admin_community/USER_DASHBOARD/js/carousel.js"></script>


</html>