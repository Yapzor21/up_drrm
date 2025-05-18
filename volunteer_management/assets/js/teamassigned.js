// Add event listener for update team buttons
document.addEventListener('DOMContentLoaded', function() {
    const updateTeamBtns = document.querySelectorAll('.update-team-btn');
    updateTeamBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const reportId = this.getAttribute('data-id');
            document.getElementById('update_team_id').value = reportId;
            
            // Get current values to populate the form
            const row = this.closest('tr');
            const assignedTeamsCell = row.cells[3].textContent;
            const timeStarted = row.cells[4].textContent;
            
            // Split the assigned teams, handling the case where there might be no teams
            const assignedTeams = assignedTeamsCell.trim() ? assignedTeamsCell.split(', ') : [];
            
            // Convert time from 12-hour to 24-hour format for the input
            let timeValue = '';
            if (timeStarted) {
                const timeParts = timeStarted.match(/(\d+):(\d+) (\w+)/);
                if (timeParts) {
                    let hours = parseInt(timeParts[1]);
                    const minutes = timeParts[2];
                    const ampm = timeParts[3];
                    
                    if (ampm === 'PM' && hours < 12) hours += 12;
                    if (ampm === 'AM' && hours === 12) hours = 0;
                    
                    timeValue = `${hours.toString().padStart(2, '0')}:${minutes}`;
                }
            }
            
            // Reset all checkboxes first
            document.querySelectorAll('.update-team-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Check the boxes for currently assigned teams
            if (assignedTeams.length > 0) {
                // Get all available team checkboxes
                const teamCheckboxes = document.querySelectorAll('.update-team-checkbox');
                
                teamCheckboxes.forEach(checkbox => {
                    const label = document.querySelector(`label[for="${checkbox.id}"]`);
                    if (label) {
                        const labelText = label.textContent.trim().toLowerCase();
                        
                        // Check if this team is in the assigned teams list
                        for (let i = 0; i < assignedTeams.length; i++) {
                            const teamName = assignedTeams[i].trim().toLowerCase();
                            if (labelText === teamName) {
                                checkbox.checked = true;
                                break;
                            }
                        }
                    }
                });
            }
            
            document.getElementById('updateTimeStarted').value = timeValue;
            
            // Open the modal
            document.getElementById('updateTeamModal').style.display = 'flex';
        });
    });
    
    // Close modal when clicking the close button
    const closeButtons = document.querySelectorAll('#updateTeamModal .close');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            closeModal('updateTeamModal');
        });
    });
    
    // Add form submission handler to ensure unchecked teams are properly processed
    const updateForm = document.querySelector('#updateTeamModal form');
    if (updateForm) {
        updateForm.addEventListener('submit', function(e) {
            // Add a hidden input to indicate this is an update operation
            const updateIndicator = document.createElement('input');
            updateIndicator.type = 'hidden';
            updateIndicator.name = 'is_update';
            updateIndicator.value = 'true';
            this.appendChild(updateIndicator);
            
            // Form will submit normally after adding the indicator
        });
    }
});

// Function to close modals
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}