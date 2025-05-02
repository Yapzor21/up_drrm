
  // Simple password strength indicator
  const passwordInput = document.getElementById('password');
  passwordInput.addEventListener('input', function() {
    const password = this.value;
    
    if (password.length > 8 && /[A-Z]/.test(password) && /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password)) {
      this.setAttribute('data-strength', 'strong');
    } else if (password.length > 6 && (/[A-Z]/.test(password) || /[0-9]/.test(password))) {
      this.setAttribute('data-strength', 'medium');
    } else {
      this.removeAttribute('data-strength');
    }
  });

  // Check if passwords match
  const confirmInput = document.getElementById('confirm_password');
  const form = document.querySelector('form');
  
  form.addEventListener('submit', function(e) {
    if (passwordInput.value !== confirmInput.value) {
      e.preventDefault();
      alert('Passwords do not match!');
      confirmInput.focus();
    }
  });

  // Dropdown toggle for volunteer
  const roleOptions = document.querySelectorAll('.role-option input');
  const volunteerDropdown = document.getElementById('volunteer-dropdown');

  roleOptions.forEach(option => {
    option.addEventListener('change', () => {
      if (option.value === 'volunteer' && option.checked) {
        volunteerDropdown.style.display = 'block';
      } else if (option.checked) {
        volunteerDropdown.style.display = 'none';
      }
    });
  });

