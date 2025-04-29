<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Account</title>
  <link rel="stylesheet" href="../../assets/css/admin/super_admin_dashboard.css">
  <link rel = "icon" type="image/svg+xml" href="../../assets/images/iconLogo1.svg">

</head>
<body>
  <div class="form-container">
    <div class="form-header">
      <h2>Create Account</h2>
      <p>Join our team and make a difference</p>
    </div>
    
    <form action="../../controllers/super_admin.php" method="post">
      <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" placeholder="Enter first name" required>
      </div>
      <div class="form-group">
        <label for="mname">Middle Name</label>
        <input type="text" id="mname" name="mname" placeholder="Enter middle name" required>
      </div>
      <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" placeholder="Enter last name" required>
      </div>
      <div class="form-group">
        <label for="contact_num">Contact Number</label>
        <input type="text" id="contact_num" name="contact_num" placeholder="Enter contact number" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Create a strong password" required>
        <div class="password-strength"></div>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat password" required>
      </div>

      <div class="form-group">
        <label>Select Role</label>
        <div class="role-options">
          <div class="role-option">
            <input type="radio" id="admin" name="role" value="admin" checked>
            <label for="admin">
              <span class="role-icon">👑</span>
              Admin
            </label>
          </div>
          <div class="role-option">
            <input type="radio" id="volunteer" name="role" value="volunteer">
            <label for="volunteer">
              <span class="role-icon">🤝</span>
              Volunteer
            </label>
          </div>
        </div>
      </div>

      <button type="submit">Create Account</button>
    </form>
  </div>

  <script>
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
  </script>
</body>
</html>