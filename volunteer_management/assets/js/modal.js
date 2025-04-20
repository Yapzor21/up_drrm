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
  
  // update and delete modal
   // Get id and class  of modal
   const deleteModal = document.getElementById('deleteModal');
   const updateModal = document.getElementById('updateModal');
   const closeButtons = document.getElementsByClassName('close');
   const cancelDeleteBtn = document.getElementById('cancelDelete');
   const cancelUpdateBtn = document.getElementById('cancelUpdate');
   
   // close modal logic
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
   
  
    // update
   document.querySelectorAll('.edit-btn').forEach(button => {
       button.addEventListener('click', function(e) {
        e.stopPropagation(); 

        const reportId = this.getAttribute('data-id');
        document.getElementById("update_report_id").value = reportId

        // Get the parent row to extract data
        const row = this.closest('tr');
        
        // Extract data from the row cells
        const disasterType = row.cells[1].textContent;
        const location = row.cells[2].textContent;
        const description = row.cells[4].textContent;
        const reporter = row.cells[5].textContent;
        const contact = row.cells[6].textContent;
        
        // Fill the form fields with the extracted data
        document.getElementById("updateModal").querySelector('#disasterType').value = disasterType;
        document.getElementById("updateModal").querySelector('#location').value = location;
        document.getElementById("updateModal").querySelector('#description').value = description;
        document.getElementById("updateModal").querySelector('#reporter').value = reporter;
        document.getElementById("updateModal").querySelector('#contact').value = contact;

           updateModal.style.display = "flex";

       });
   });
   

   // delete
   document.querySelectorAll('.delete-btn').forEach(button => {
       button.addEventListener('click', function(e) {
           e.stopPropagation(); 

           const reportId = this.getAttribute('data-id');
           document.getElementById('delete_report_id').value = reportId;

           deleteModal.style.display = "flex";
       });
   });


   /**
    * 
    * 
    * 
    * 
    * ASSIGNED TEAM MODAL
    */

// Modal functions
