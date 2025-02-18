const modal = document.getElementById('reportModal');
const reportForms = document.getElementById('reportForm');

function openModal() {
    modal.classList.add('active');
}

function closeModal() {
    modal.classList.remove('active');
    reportForms.reset();
}

// need to testing(if the user click the screen the modal will not close)
document.querySelector('.modal-content', '.sidebar').addEventListener('click', (e) => {
    e.stopPropagation();
});


/**
 * // Close modal when clicking outside
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeModal();
    }
});
 * 
 */


/**
 * // Form submission
reportForms.addEventListener('submit', (e) => {
    e.preventDefault();
    // Handle form submission here
    console.log({
        disasterType: document.getElementById('disasterType').value,
        location: document.getElementById('location').value,
        contact: document.getElementById('contact').value,
        description: document.getElementById('description').value
    });
    closeModal();
});
 * 
 */
