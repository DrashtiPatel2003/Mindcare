<?php
session_start();

// Retrieve signup data from session if available
$name    = isset($_SESSION['signup_data']['name']) ? $_SESSION['signup_data']['name'] : "";
$phone   = isset($_SESSION['signup_data']['phone']) ? $_SESSION['signup_data']['phone'] : "";
$address = isset($_SESSION['signup_data']['address']) ? $_SESSION['signup_data']['address'] : "";
$email   = isset($_SESSION['signup_data']['email']) ? $_SESSION['signup_data']['email'] : "";
$otpSuccess = isset($_SESSION['otp_success']) ? $_SESSION['otp_success'] : "";

// Define $otpVerified variable (set to true if OTP was verified, otherwise false)
$otpVerified = isset($_SESSION['otp_verified']) ? $_SESSION['otp_verified'] : false;

// Optionally clear the OTP success message after displaying it if desired
unset($_SESSION['otp_success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="signinsignup.css">
  <style>


    .send-otp-btn {
      margin-left: 10px;
      padding: 5px 10px;
      background-color: palevioletred;
      color: #fff;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .send-otp-btn:hover {
      background-color: #ffcccc;
    }
    .error {
      font-size: 0.9em;
      margin-top: 5px;
    }
                /* Container for the icon */
    .info-icon {
    display: inline-block;
    vertical-align: middle;
  }
  
  /* Icon image styles */
  .info-image {
    width: 20px; /* Adjust the size as needed */
    height: auto;
    border-radius: 40%;
    transition: transform 0.3s ease;
  }
  
  /* Hover effect to slightly enlarge the icon */
  .info-icon:hover .info-image {
    transform: scale(1.1);
  }
  .info-images {
    width: 50px;
    height: auto;
    border-radius: 40%;
    transition: transform 0.3s ease;
  }

  </style>
</head>
<body>
<?php if ($otpSuccess): ?>
    <p style="color: green;"><?php echo htmlspecialchars($otpSuccess); ?></p>
  <?php endif; ?>
  <div class="containera" style="display:flex;">
      <div class="left-panel">
          <h1>Join Us!</h1>
          <p>Create an account to begin your journey towards better mental health.</p>
      </div>
      <div class="right-panel">
          <form id="signup-form" action="signup.php" method="POST" enctype="multipart/form-data">
              <h2>Sign Up
              <a href="#" class="info-icon" title="Sign Up here">
              <img src="../assets/images/signup.gif" alt="Information Icon" class="info-images">
              </a>
              </h2>
              <br>
              <label for="name">  <a href="#" class="info-icon" title="Name">
              <img src="../assets/images/signupname.gif" alt="Information Icon" class="info-image">
              </a>
                Name
              </label>
              <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($name); ?>">
              <p id="name-error" class="error"></p>

              <label for="phone"><a href="#" class="info-icon" title="Phone">
              <img src="../assets/images/signupphone.gif" alt="Information Icon" class="info-image">
              </a>
              Phone Number</label>
              <input type="tel" id="phone" name="phone" required value="<?php echo htmlspecialchars($phone); ?>">
              <p id="phone-error" class="error">~10 numbers required</p>

              <label for="address"><a href="#" class="info-icon" title="Address">
              <img src="../assets/images/signupaddress.gif" alt="Information Icon" class="info-image">
              </a>Address</label>
              <textarea id="address" name="address" required><?php echo htmlspecialchars($address); ?></textarea>
              <p id="address-error" class="error"></p>
              <label for="email"><a href="#" class="info-icon" title="Email">
              <img src="../assets/images/signupemail.gif" alt="Information Icon" class="info-image">
              </a> Email</label>
              <div style="display:flex; align-items: center;">
                  <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">
                  <!-- This button submits the form to send_otp.php instead of signup.php -->
                  <button type="submit" formaction="send_otp_signup.php" class="send-otp-btn">Send OTP</button>
              </div>
              <p id="email-error" class="error"></p>
          
              <label for="password"><a href="#" class="info-icon" title="Password">
              <img src="../assets/images/signuppassword.gif" alt="Information Icon" class="info-image">
              </a>Password</label>
              <input type="password" id="password" name="password" required <?php echo $otpVerified ? '' : 'disabled'; ?>>
              <p id="password-error" class="error"></p>
              <div id="password-criteria" class="error">
                  <p>~At least one uppercase letter</p>
                  <p>~At least one number</p>
                  <p>~At least one special character (!@#$%^&*)</p>
                  <p>~Minimum length 8 characters</p>
              </div>

              <label for="confirm-password"><a href="#" class="info-icon" title="Confirm Password">
              <img src="../assets/images/signupconfirm.gif" alt="Information Icon" class="info-image">
              </a>Confirm Password</label>
              <input type="password" id="confirm-password" name="confirm-password" required <?php echo $otpVerified ? '' : 'disabled'; ?>>
              <p id="confirm-password-error" class="error"></p>

              <button type="submit">Sign Up</button>
          </form>
          <div id="response-message" style="display:none;"></div>
      </div>
  </div>


<script>
      document.addEventListener("DOMContentLoaded", function() {
      // --- Phone Number Dynamic Validation ---
      const phoneInput = document.getElementById("phone");
      const phoneError = document.getElementById("phone-error");

      phoneInput.addEventListener("input", function() {
        let phoneValue = phoneInput.value.replace(/\D/g, "");
        phoneInput.value = phoneValue;
        if (phoneValue.length < 10) {
          phoneError.textContent = "10 numbers required";
          phoneError.style.color = "red";
        } else if (phoneValue.length === 10) {
          phoneError.textContent = "10 numbers required";
          phoneError.style.color = "green";
        } else {
          phoneError.textContent = "Phone number should be 10 digits";
          phoneError.style.color = "red";
        }
      });

      // --- Password Validation ---
      const passwordInput = document.getElementById("password");
      const confirmPasswordInput = document.getElementById("confirm-password");
      const passwordCriteria = document.getElementById("password-criteria");

      if (passwordInput) {
        passwordInput.addEventListener("input", () => {
          const value = passwordInput.value;
          const criteria = [
            /[A-Z]/.test(value),
            /[0-9]/.test(value),
            /[!@#$%^&*]/.test(value),
            value.length >= 8,
          ];
          const criteriaText = passwordCriteria.querySelectorAll("p");
          criteria.forEach((valid, index) => {
            criteriaText[index].style.color = valid ? "green" : "red";
          });
        });
      }

      if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener("input", () => {
          const confirmPasswordError = document.getElementById("confirm-password-error");
          if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordError.textContent = "Passwords do not match.";
          } else {
            confirmPasswordError.textContent = "";
          }
        });
      }
    });
  </script>

</body>
</html>
