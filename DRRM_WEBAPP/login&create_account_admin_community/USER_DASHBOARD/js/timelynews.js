// time 

function updatePhilippineTime() {
    const options = {
        timeZone: 'Asia/Manila',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    };

    const dateOptions = {
        timeZone: 'Asia/Manila',
        month: 'long',
        day: 'numeric',
        year: 'numeric'
    };

    const now = new Date();
    const timeElement = document.getElementById('ph-time');
    const dateElement = document.getElementById('ph-date');

    timeElement.textContent = now.toLocaleTimeString('en-US', options);
    dateElement.textContent = now.toLocaleDateString('en-US', dateOptions);
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
}

// Close ang sidebar when overlay is clicked
document.getElementById('overlay').addEventListener('click', toggleSidebar);

updatePhilippineTime();
setInterval(updatePhilippineTime, 1000);


// news and updates
const newsContainer = document.querySelector('.news-container');
        let isDown = false;
        let startX;
        let scrollLeft;

        // Only enable drag scrolling if not on mobile
        if (window.innerWidth > 640) {
            newsContainer.addEventListener('mousedown', (e) => {
                isDown = true;
                startX = e.pageX - newsContainer.offsetLeft;
                scrollLeft = newsContainer.scrollLeft;
            });

            newsContainer.addEventListener('mouseleave', () => {
                isDown = false;
            });

            newsContainer.addEventListener('mouseup', () => {
                isDown = false;
            });

            newsContainer.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - newsContainer.offsetLeft;
                const walk = (x - startX) * 2;
                newsContainer.scrollLeft = scrollLeft - walk;
            });
        }

        // Update layout on resize
        window.addEventListener('resize', () => {
            if (window.innerWidth <= 640) {
                newsContainer.style.overflowX = 'hidden';
            } else {
                newsContainer.style.overflowX = 'auto';
            }
        });


