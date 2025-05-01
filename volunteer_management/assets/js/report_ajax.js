// This file will handle AJAX for report submission and real-time updates

document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the community dashboard page with the report form
    const reportForm = document.getElementById('reportForm');
    
    if (reportForm) {
      reportForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Create FormData object from the form
        const formData = new FormData(this);
        
        // Add action parameter
        formData.append('action', 'create');
        
        // Send AJAX request
        fetch('../../controllers/report_control.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(data => {
          // Close the modal
          closeModal('reportModal');
          
          // Show success message
          alert('Report submitted successfully');
          
          // Notify the admin page about the new report
          // This will trigger a WebSocket event or use another method
          // to notify the admin page
          notifyAdminPage();
        })
        .catch(error => {
          console.error('Error:', error);
        });
      });
    }
    
    // Function to notify admin page
    function notifyAdminPage() {
      // You could implement WebSockets here for real-time communication
      // For simplicity, we'll just use localStorage as a signal
      localStorage.setItem('newReport', Date.now());
    }
    
    // Check if we're on the admin page
    const adminTable = document.querySelector('.table-container table tbody');
    
    if (adminTable) {
      // Function to refresh the reports table
      function refreshReportsTable() {
        fetch('../../controllers/report_control.php?action=get_reports', {
          method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
          // Clear the current table
          adminTable.innerHTML = '';
          
          // Add the new data
          if (data && data.length > 0) {
            data.forEach(row => {
              const tr = document.createElement('tr');
              tr.innerHTML = `
                <td>${row.Report_Id}</td>
                <td>${row.Disaster_Type}</td>
                <td>${row.Location}</td>
                <td>${row.City}</td>
                <td>${row.Description}</td>
                <td>${row.Name_of_Reporter}</td>
                <td>${row.Contact_Number}</td>
                <td>${row.Date_Reported}</td>
                <td>
                  <i class='fas fa-edit edit-btn' style='cursor:pointer; margin: 0 8px;' data-id='${row.Report_Id}'></i>
                  <i class='fas fa-trash delete-btn' style='cursor:pointer;' data-id='${row.Report_Id}'></i>
                </td>
              `;
              adminTable.appendChild(tr);
            });
          } else {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td colspan='9' style='text-align:center'>No reports found</td>`;
            adminTable.appendChild(tr);
          }
          
          // Reattach event listeners for edit and delete buttons
          attachEventListeners();
        })
        .catch(error => {
          console.error('Error:', error);
        });
      }
      
      // Function to attach event listeners to edit and delete buttons
      function attachEventListeners() {
        // Re-attach edit button event listeners
        document.querySelectorAll('.edit-btn').forEach(btn => {
          btn.addEventListener('click', function() {
            const reportId = this.getAttribute('data-id');
            // Your existing edit functionality
          });
        });
        
        // Re-attach delete button event listeners
        document.querySelectorAll('.delete-btn').forEach(btn => {
          btn.addEventListener('click', function() {
            const reportId = this.getAttribute('data-id');
            // Your existing delete functionality
          });
        });
      }
      
      // Check for new reports every 10 seconds
      setInterval(refreshReportsTable, 10000);
      
      // Also check when localStorage changes (for same-browser testing)
      window.addEventListener('storage', function(e) {
        if (e.key === 'newReport') {
          refreshReportsTable();
        }
      });
      
      // Initial load
      refreshReportsTable();
    }
  });
  
  console.log("AJAX functionality for reports has been initialized");