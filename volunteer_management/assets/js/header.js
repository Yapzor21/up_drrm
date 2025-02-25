window.addEventListener("scroll", function () {
    let subHeader = document.getElementById("sub-header");
    if (window.scrollY > 50) { // If scrolled past top-header
        subHeader.style.top = "0px"; // Move sub-header to top
        subHeader.style.transition = "top 0.10s ease-in-out"; 
    } else {
        subHeader.style.top = "50px"; // Keep it below top-header
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const currentPage = window.location.pathname.split('/').pop();
    const navLinks = document.querySelectorAll('.nav-link');

    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }
    });

    let subHeader = document.getElementById("sub-header");
    subHeader.style.transition = "top 0.10s ease-in-out";
});


