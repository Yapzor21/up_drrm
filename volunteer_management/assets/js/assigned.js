// Fixed modal functionality
function openModal(modalId) {
  console.log("Opening modal:", modalId);
  const modal = document.getElementById(modalId);
  if (modal) {
      // Close any other modals if this is not a nested modal
      if (!modal.classList.contains('nested')) {
          document.querySelectorAll('.modal.show').forEach(openModal => {
              if (openModal.id !== modalId) {
                  openModal.style.display = "none";
                  openModal.classList.remove("show");
              }
          });
      }
      
      modal.style.display = "flex";
      modal.classList.add("show");
  } else {
      console.error("Modal not found:", modalId);
  }
}

function closeModal(modalId) {
  console.log("Closing modal:", modalId);
  const modal = document.getElementById(modalId);
  if (modal) {
      modal.style.display = "none";
      modal.classList.remove("show");
  } else {
      console.error("Modal not found:", modalId);
  }
}

function stopPropagation(e) {
  if (e) e.stopPropagation();
}

// Add this JavaScript to fix the assign team functionality
document.addEventListener("DOMContentLoaded", function() {
  console.log("DOM fully loaded");
  
  // Add click handlers for report_id and disaster_type cells to open viewReportModal
  document.querySelectorAll('.report-id-cell, .disaster-type-cell').forEach(cell => {
      cell.addEventListener('click', function() {
          const reportId = this.getAttribute('data-id');
          console.log("Opening view report modal for ID:", reportId);
          openModal('viewReportModal');
      });
  });
  
  // Fix for assign team modal - Direct open without closing parent modal
  document.querySelectorAll('.assign-btn').forEach(button => {
      button.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          console.log("Assign button clicked");
          
          const reportId = this.getAttribute('data-id');
          
          document.getElementById("report_id").value = reportId;
          
          // Get the parent row to extract data
          const row = this.closest('tr');
          
          // Extract data from the row cells
          const disasterType = row.cells[0].textContent;
          
          // Fill the form fields with the extracted data
          document.getElementById("disasterType").value = disasterType;
          
          // Display the modal without closing the parent modal
          openModal('assignModal');
      });
  });

  // Fix for update team modal - Direct open without closing parent modal
  document.querySelectorAll('.edit-btn').forEach(button => {
      button.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          console.log("Edit team button clicked");
          
          const reportId = this.getAttribute('data-id');
          
          // Find the row data for this report ID
          const row = this.closest('tr');
          const disasterType = row.cells[0].textContent;
          const timeStartedFull = row.cells[1].textContent;
          const assignedTeam = row.cells[2].textContent;
          
          // Extract just the time portion from the timeStartedFull
          const timeStarted = timeStartedFull.split(' ')[0];
          
          // Set the values in the update form
          document.getElementById('update_team_id').value = reportId;
          document.getElementById('updateDisasterType').value = disasterType;
          document.getElementById('updateTimeStarted').value = timeStarted;
          document.getElementById('updateAssignedTeam').value = assignedTeam;
          
          // Display the modal without closing the parent modal
          openModal('updateTeamModal');
      });
  });

  // Fix for edit report button
  document.querySelectorAll('.edit-btn').forEach(button => {
      button.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          console.log("Edit report button clicked");
          
          const reportId = this.getAttribute('data-id');
          
          // Find the row data for this report ID
          const row = this.closest('tr');
          
          // Set the report ID in the form
          document.getElementById('update_report_id').value = reportId;
          
          // Extract data from the row cells
          document.getElementById('updateReportDisasterType').value = row.cells[1].textContent;
          document.getElementById('location').value = row.cells[2].textContent;
          document.getElementById('description').value = row.cells[4].textContent;
          document.getElementById('reporter').value = row.cells[5].textContent;
          document.getElementById('contact').value = row.cells[6].textContent;
          
          // Display the modal
          openModal('updateModal');
      });
  });

  // Fix for delete buttons
  document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();
          
          console.log("Delete button clicked");
          
          const reportId = this.getAttribute('data-id');
          document.getElementById('delete_report_id').value = reportId;
          
          // Display the modal
          openModal('deleteModal');
      });
  });

  // Add event listeners to all close buttons
  document.querySelectorAll('.close, .close-button').forEach(button => {
      button.addEventListener('click', function() {
          // Find the parent modal
          const modal = this.closest('.modal');
          if (modal) {
              closeModal(modal.id);
          }
      });
  });

  // Add event listeners to all cancel buttons
  document.querySelectorAll('button[type="button"]').forEach(button => {
      if (button.textContent.toLowerCase().includes('cancel')) {
          button.addEventListener('click', function() {
              // Find the parent modal
              const modal = this.closest('.modal');
              if (modal) {
                  closeModal(modal.id);
              }
          });
      }
  });
});