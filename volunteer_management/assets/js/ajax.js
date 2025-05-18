document.addEventListener("DOMContentLoaded", () => {
  // Toggle sidebar
  const toggleSidebar = document.getElementById("toggle-sidebar")
  const personnelSections = document.querySelectorAll(".personnel-section")

  if (toggleSidebar) {
    toggleSidebar.addEventListener("click", () => {
      personnelSections.forEach((section) => {
        section.style.display = section.style.display === "none" ? "block" : "none"
      })
    })
  }

  // Show status dropdown
  const actionButtons = document.querySelectorAll(".actions")

  actionButtons.forEach((button) => {
    button.addEventListener("click", function (e) {
      e.stopPropagation()

      // Hide all other dropdowns
      document.querySelectorAll(".status-dropdown").forEach((dropdown) => {
        if (dropdown !== this.nextElementSibling) {
          dropdown.classList.remove("show")
        }
      })

      // Toggle current dropdown
      this.nextElementSibling.classList.toggle("show")
    })
  })

  // Hide dropdown when clicking elsewhere
  document.addEventListener("click", () => {
    document.querySelectorAll(".status-dropdown").forEach((dropdown) => {
      dropdown.classList.remove("show")
    })
  })

  // Prevent dropdown from closing when clicking inside it
  document.querySelectorAll(".status-dropdown").forEach((dropdown) => {
    dropdown.addEventListener("click", (e) => {
      e.stopPropagation()
    })
  })

  // Handle status change
  const statusOptions = document.querySelectorAll(".status-option")

  statusOptions.forEach((option) => {
    option.addEventListener("click", function () {
      const newStatus = this.getAttribute("data-status")
      const personnelItem = this.closest(".personnel-item")
      const personnelId = personnelItem.getAttribute("data-id")
      const currentStatus = personnelItem.getAttribute("data-status")

      if (newStatus === currentStatus) {
        return
      }

      updatePersonnelStatus(personnelId, newStatus, personnelItem)
    })
  })
})

// Function to update personnel status via AJAX
function updatePersonnelStatus(id, status, personnelItem) {
  const xhr = new XMLHttpRequest()
  xhr.open("POST", "../../controllers/personnel_control.php", true)
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")

  xhr.onload = function () {
    if (this.status === 200) {
      try {
        const response = JSON.parse(this.responseText)

        if (response.success) {
          // Move the personnel item to the appropriate list
          const targetList = document.getElementById(
            status === "deployed" ? "deployed-list" : status === "standby" ? "standby-list" : "on-call-list",
          )

          // Clone the personnel item
          const clonedItem = personnelItem.cloneNode(true)

          // Update status attribute and indicator
          clonedItem.setAttribute("data-status", status)

          // Update the UI based on the new status
          // Remove phone icon if it exists (for any status)
          const phoneIcon = clonedItem.querySelector(".phone-icon")
          if (phoneIcon) {
            phoneIcon.remove()
          }

          // Add or update status indicator for all statuses
          let statusIndicator = clonedItem.querySelector(".status-indicator")
          if (!statusIndicator) {
            statusIndicator = document.createElement("span")
            statusIndicator.className = "status-indicator"
            clonedItem.insertBefore(statusIndicator, clonedItem.firstChild)
          }

          // Update status indicator class based on status
          // This will set the appropriate color: green for deployed, yellow for standby, red for oncall
          statusIndicator.className = "status-indicator " + status

          // Add event listeners to the cloned item
          addEventListenersToPersonnelItem(clonedItem)

          // Add to target list and remove original
          targetList.appendChild(clonedItem)
          personnelItem.remove()

          // Show success message
          showToast("Status updated successfully")
        } else {
          showToast("Failed to update status")
        }
      } catch (e) {
        console.error("Error parsing response:", e)
        showToast("An error occurred")
      }
    } else {
      showToast("An error occurred")
    }
  }

  xhr.onerror = () => {
    showToast("Network error occurred")
  }

  xhr.send(`action=updateStatus&id=${id}&status=${status}`)
}

// Function to add event listeners to personnel item
function addEventListenersToPersonnelItem(item) {
  // Add event listener to actions button
  const actionsButton = item.querySelector(".actions")
  if (actionsButton) {
    actionsButton.addEventListener("click", function (e) {
      e.stopPropagation()

      // Hide all other dropdowns
      document.querySelectorAll(".status-dropdown").forEach((dropdown) => {
        if (dropdown !== this.nextElementSibling) {
          dropdown.classList.remove("show")
        }
      })

      // Toggle current dropdown
      this.nextElementSibling.classList.toggle("show")
    })
  }

  // Add event listeners to status options
  const statusOptions = item.querySelectorAll(".status-option")
  statusOptions.forEach((option) => {
    option.addEventListener("click", function () {
      const newStatus = this.getAttribute("data-status")
      const personnelItem = this.closest(".personnel-item")
      const personnelId = personnelItem.getAttribute("data-id")
      const currentStatus = personnelItem.getAttribute("data-status")

      if (newStatus === currentStatus) {
        return
      }

      updatePersonnelStatus(personnelId, newStatus, personnelItem)
    })
  })
}

// Function to make a phone call
function makeCall(phoneNumber) {
  if (phoneNumber) {
    window.location.href = `tel:${phoneNumber}`
  } else {
    showToast("Phone number not available")
  }
}

// Function to show toast message
function showToast(message) {
  const toast = document.getElementById("toast")
  toast.textContent = message
  toast.style.display = "block"

  setTimeout(() => {
    toast.style.display = "none"
  }, 3000)
}
