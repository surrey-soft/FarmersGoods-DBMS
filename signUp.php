<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign-Up Forms</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
      .form-container {
        display: none;
        margin-top: 20px;
      }
    </style>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const userTypeSelect = document.getElementById("userType");
        const forms = document.querySelectorAll(".form-container");

        userTypeSelect.addEventListener("change", function () {
          // Hide all forms
          forms.forEach((form) => (form.style.display = "none"));

          // Get the selected user type
          const selectedUserType = userTypeSelect.value;

          // Display the appropriate form
          const selectedForm = document.getElementById(`${selectedUserType}Form`);
          if (selectedForm) {
            selectedForm.style.display = "block";

            // Update the hidden input in the selected form
            const userTypeInput = selectedForm.querySelector('input[name="userType"]');
            if (userTypeInput) {
              userTypeInput.value = selectedUserType;
            }
          }
        });
      });
    </script>
  </head>
  <body>
    <div class="container mt-5">
      <h1 class="text-center">Sign-Up Portal</h1>
      <div class="mt-4">
        <label for="userType" class="form-label">Select User Type:</label>
        <select id="userType" class="form-select">
          <option value="">-- Select --</option>
          <option value="farmer">Farmer</option>
          <option value="qcOfficer">QC Officer</option>
          <option value="customer">Customer</option>
          <option value="packagingStaff">Packaging Staff</option>
          <option value="driver">Driver</option>
        </select>
      </div>

      <!-- Farmer Sign-Up Form -->
      <div id="farmerForm" class="form-container">
        <h2>Farmer Sign-Up</h2>
        <form method="POST" action="config-php-files/save_sign_up.php" class="border p-3 rounded">
          <input type="hidden" name="userType" value="farmer" />
          <div class="mb-3">
            <label for="firstName" class="form-label">First Name:</label>
            <input type="text" id="firstName" name="firstName" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="lastName" class="form-label">Last Name:</label>
            <input type="text" id="lastName" name="lastName" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth:</label>
            <input type="date" id="dob" name="dob" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="contact" class="form-label">Contact Number:</label>
            <input type="tel" id="contact" name="contactInfo" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="city" class="form-label">City:</label>
            <input type="text" id="city" name="city" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="roadNo" class="form-label">Road No:</label>
            <input type="text" id="roadNo" name="roadNo" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="houseNo" class="form-label">House No:</label>
            <input type="text" id="houseNo" name="houseNo" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
      </div>

      <!-- QC Officer Sign-Up Form -->
      <div id="qcOfficerForm" class="form-container">
        <h2>QC Officer Sign-Up</h2>
        <form method="POST" action="config-php-files/save_sign_up.php" class="border p-3 rounded">
          <input type="hidden" name="userType" value="qcOfficer" />
          <div class="mb-3">
            <label for="firstName" class="form-label">First Name:</label>
            <input type="text" id="firstName" name="firstName" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="lastName" class="form-label">Last Name:</label>
            <input type="text" id="lastName" name="lastName" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="sim1" class="form-label">SIM 1:</label>
            <input type="tel" id="sim1" name="sim1" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="sim2" class="form-label">SIM 2:</label>
            <input type="tel" id="sim2" name="sim2" class="form-control" />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
      </div>

      <!-- Customer Sign-Up Form -->
      <div id="customerForm" class="form-container">
        <h2>Customer Sign-Up</h2>
        <form method="POST" action="config-php-files/save_sign_up.php" class="border p-3 rounded">
          <input type="hidden" name="userType" value="customer" />
          <div class="mb-3">
            <label for="firstName" class="form-label">First Name:</label>
            <input type="text" id="firstName" name="firstName" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="lastName" class="form-label">Last Name:</label>
            <input type="text" id="lastName" name="lastName" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address:</label>
            <input type="text" id="address" name="address" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="mobile" class="form-label">Mobile Number:</label>
            <input type="tel" id="mobile" name="mobile" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
      </div>

      <!-- Packaging Staff Sign-Up Form -->
      <div id="packagingStaffForm" class="form-container">
        <h2>Packaging Staff Sign-Up</h2>
        <form method="POST" action="config-php-files/save_sign_up.php" class="border p-3 rounded">
          <input type="hidden" name="userType" value="packagingStaff" />
          <div class="mb-3">
            <label for="firstName" class="form-label">First Name:</label>
            <input type="text" id="firstName" name="firstName" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="lastName" class="form-label">Last Name:</label>
            <input type="text" id="lastName" name="lastName" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address:</label>
            <input type="text" id="address" name="address" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth:</label>
            <input type="date" id="dob" name="dob" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="contactInfo" class="form-label">Contact Info:</label>
            <input type="tel" id="contactInfo" name="contactInfo" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
      </div>

      <!-- Driver Sign-Up Form -->
      <div id="driverForm" class="form-container">
        <h2>Driver Sign-Up</h2>
        <form method="POST" action="config-php-files/save_sign_up.php" class="border p-3 rounded">
          <input type="hidden" name="userType" value="driver" />
          <div class="mb-3">
            <label for="dFirstName" class="form-label">First Name:</label>
            <input type="text" id="dFirstName" name="firstName" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="dLastName" class="form-label">Last Name:</label>
            <input type="text" id="dLastName" name="lastName" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="contactInfo" class="form-label">Contact Info:</label>
            <input type="tel" id="contactInfo" name="contactInfo" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="dAddress" class="form-label">Address:</label>
            <input type="text" id="dAddress" name="address" class="form-control" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
      </div>
    </div>
  </body>
</html>
