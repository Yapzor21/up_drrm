window.addEventListener("scroll", function () {
    let subHeader = document.getElementById("sub-header");
    if (window.scrollY > 50) { // If scrolled past top-header
        subHeader.style.top = "0px"; // Move sub-header to top
    } else {
        subHeader.style.top = "50px"; // Keep it below top-header
    }
});
