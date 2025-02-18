const carousel = document.querySelector('.carousel');
const items = document.querySelectorAll('.carousel-item');
const dotsContainer = document.querySelector('.carousel-dots');
const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');

let currentIndex = 0;
let start = 0;
let isDragging = false;

// Create dots
items.forEach((_, index) => {
    const dot = document.createElement('div');
    dot.classList.add('dot');
    if (index === 0) dot.classList.add('active');
    dot.addEventListener('click', () => goToSlide(index));
    dotsContainer.appendChild(dot);
});

// Update dots
function updateDots() {
    document.querySelectorAll('.dot').forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex);
    });
}

// Go to specific slide
function goToSlide(index) {
    currentIndex = index;
    carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
    updateDots();
}

// Next slide
function nextSlide() {
    currentIndex = (currentIndex + 1) % items.length;
    goToSlide(currentIndex);
}

// Previous slide
function prevSlide() {
    currentIndex = (currentIndex - 1 + items.length) % items.length;
    goToSlide(currentIndex);
}

// Touch events
carousel.addEventListener('touchstart', (e) => {
    start = e.touches[0].clientX;
    isDragging = true;
});

carousel.addEventListener('touchmove', (e) => {
    if (!isDragging) return;
    const currentX = e.touches[0].clientX;
    const diff = start - currentX;
    
    if (Math.abs(diff) > 50) {
        if (diff > 0) {
            nextSlide();
        } else {
            prevSlide();
        }
        isDragging = false;
    }
});

carousel.addEventListener('touchend', () => {
    isDragging = false;
});

// Button events
prevButton.addEventListener('click', prevSlide);
nextButton.addEventListener('click', nextSlide);