
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


function openModal(modalId) {
    document.getElementById(modalId).style.display = "flex"
  }
  
  function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none"
  }
  
// update , delete

 
   // Get modal elements
   const deleteModal = document.getElementById('deleteModal');
   const updateModal = document.getElementById('updateModal');
   const closeButtons = document.getElementsByClassName('close');
   
   // Get buttons
   const cancelDeleteBtn = document.getElementById('cancelDelete');
   const cancelUpdateBtn = document.getElementById('cancelUpdate');
   
   // Close modals when clicking on X
   for (let i = 0; i < closeButtons.length; i++) {
       closeButtons[i].onclick = function() {
           deleteModal.style.display = "none";
           updateModal.style.display = "none";
       }
   }
   
   // Close modals when clicking cancel
   cancelDeleteBtn.onclick = function() {
       deleteModal.style.display = "none";
   }
   
   cancelUpdateBtn.onclick = function() {
       updateModal.style.display = "none";
   }
   
   // Close modals when clicking outside
   window.onclick = function(event) {
       if (event.target == deleteModal) {
           deleteModal.style.display = "none";
       }
       if (event.target == updateModal) {
           updateModal.style.display = "none";
       }
   }
   
   // Add event listeners to all edit buttons
   document.querySelectorAll('.edit-btn').forEach(button => {
       button.addEventListener('click', function(e) {
           e.stopPropagation(); // Prevent row click event
           const reportId = this.getAttribute('data-id');
           const row = document.querySelector(`tr[data-id="${reportId}"]`);
           
           updateModal.style.display = "flex";
       });
   });
   
   // Add event listeners to all delete buttons
   document.querySelectorAll('.delete-btn').forEach(button => {
       button.addEventListener('click', function(e) {
           e.stopPropagation(); // Prevent row click event
           const reportId = this.getAttribute('data-id');
           document.getElementById('delete_report_id').value = reportId;
           deleteModal.style.display = "flex";
       });
   });
   
   // Make rows clickable to highlight them
   document.querySelectorAll('.clickable-row').forEach(row => {
       row.addEventListener('click', function() {
           // Remove selected class from all rows
           document.querySelectorAll('tr').forEach(r => {
               r.classList.remove('selected');
           });
           
           // Add selected class to clicked row
           this.classList.add('selected');
       });
   });


