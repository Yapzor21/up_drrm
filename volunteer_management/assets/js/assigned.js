// Modal functions
function openModal(modalId) {
    document.getElementById(modalId).style.display = "flex"
  }
  
  function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none"
  
    // Reset form if closing assign modal
    if (modalId === "assignModal") {
      document.getElementById("assignTeamForm").reset()
    }
  }
  

  document.addEventListener("DOMContentLoaded", () => {
   
    // Add event listeners to all close buttons
    const closeButtons = document.getElementsByClassName("close")
    for (let i = 0; i < closeButtons.length; i++) {
      closeButtons[i].addEventListener("click", function () {
        // Find the parent modal
        const modal = this.closest(".modal")
        if (modal) {
          modal.style.display = "none"
        }
      })
    }
  
    // Add event listeners to cancel buttons
    const cancelButtons = document.querySelectorAll(".confirm button[type='button']")
    for (let i = 0; i < cancelButtons.length; i++) {
      cancelButtons[i].addEventListener("click", function () {
        // Find the parent modal
        const modal = this.closest(".modal")
        if (modal) {
          modal.style.display = "none"
        }
      })
    }
  

    //assign team modal
    document.querySelectorAll('.assign-btn').forEach(button => {
      button.addEventListener('click', function(e) {
          e.stopPropagation();
  
          const reportId = this.getAttribute('data-id');
          document.getElementById("report_id").value = reportId;
          
          // Get the parent row to extract data
          const row = this.closest('tr');
          
          // Extract data from the row cells
          const disasterType = row.cells[0].textContent;
          
          // Fill the form fields with the extracted data
          document.getElementById("assignModal").querySelector('#disasterType').value = disasterType;
        
          // Set focus on the assignedTeam field since that's what the user will likely want to fill
          setTimeout(() => {
              document.getElementById("assignModal").querySelector('#assignedTeam').focus();
          }, 100);
          
          // Display the modal
          assignModal.style.display = "flex";
      });
  });
  

  //team update modal
    const editTeamButtons = document.querySelectorAll('.edit-team-btn');

    editTeamButtons.forEach(button => {
        button.addEventListener('click', function() {
            const reportId = this.getAttribute('data-id');
            
            // Find the row data for this report ID
            const row = this.closest('tr');
            const disasterType = row.cells[0].textContent;
            const timeStartedFull = row.cells[1].textContent;
            const assignedTeam = row.cells[2].textContent;
            const affectedAreas = row.cells[3].textContent;
            
            // Extract just the time portion from the timeStartedFull
            const timeStarted = timeStartedFull.split(' ')[0];
            
            // Set the values in the update form
            document.getElementById('update_team_id').value = reportId;
            document.getElementById('updateDisasterType').value = disasterType;
            document.getElementById('updateTimeStarted').value = timeStarted;
            document.getElementById('updateAssignedTeam').value = assignedTeam;
            document.getElementById('updateAffectedAreas').value = affectedAreas;
            
            openModal('updateTeamModal');
        });
    });


  })

  