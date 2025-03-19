<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signinsignup/signin.php");
    exit();
}

include 'includes/db_connect.php';


$user_id = $_SESSION['user_id'];

// Process form submission (update user details)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and trim form fields
    $name              = trim($_POST['name']);
    $phone             = trim($_POST['phone']);
    $emergency_contact = trim($_POST['emergency_contact']);
    $dob               = trim($_POST['dob']);
    $gender            = trim($_POST['gender']);
    $address           = trim($_POST['address']);

    // Update the user record using a prepared statement
    $stmt = $conn->prepare("UPDATE users SET name = ?, phone = ?, emergency_contact = ?, dob = ?, gender = ?, address = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $name, $phone, $emergency_contact, $dob, $gender, $address, $user_id);
    if ($stmt->execute()) {
        $success = "Profile updated successfully!";
    } else {
        $error = "Error updating profile. Please try again.";
    }
    $stmt->close();
}

// Fetch the current user data
$stmt = $conn->prepare("SELECT name, email, phone, emergency_contact, dob, gender, address, profile_pic FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found!");
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 100%;
      max-width: 1000px;
      margin: 20px auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
    }
    h2 {
      margin-top: 0;
    }
/* Define a fadeIn keyframe if not already defined */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* Logout container */
.logout {
  float: right;
  opacity: 0;                     /* Start transparent */
  animation: fadeIn 1s ease-in forwards; /* Fade in animation */
  transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Styling for the logout link inside */
.logout a {
  text-decoration: none;
  color: #fff;
  background-color: #e63946;
  padding: 10px 15px;
  border-radius: 5px;
  display: inline-block;
  transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Hover effect for logout link */
.logout a:hover {
  transform: scale(1.05);
  opacity: 0.9;
}

   /* Container for Profile Section */
.profile-container {
  display: flex;
  gap: 20px;
  align-items: flex-start;
  margin: 20px auto;
  max-width: 800px;
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

/* Profile Image Section */
.profile-image-section {
  flex: 0 0 200px;
  text-align: center;
}

.profile-pic {
  width: 150px;
  height: 150px;
  object-fit: cover;
  border-radius: 50%;
  border: 3px solid #f86d7a;
}

/* Buttons below the Profile Image */
.profile-image-buttons {
  margin-top: 10px;
}

.profile-image-buttons .btn {
  display: inline-block;
  padding: 8px 12px;
  text-decoration: none;
  font-size: 0.9em;
  border-radius: 5px;
  margin: 5px 0;
  transition: background-color 0.3s ease;
}

.upload-btn {
  background-color: #4CAF50;
  color: #fff;
}

.upload-btn:hover {
  background-color: #45a049;
}

.delete-btn {
  background-color: #e63946;
  color: #fff;
}

.delete-btn:hover {
  background-color: #c5303f;
}

/* Profile Information Section */
.profile-info-section {
  flex: 1;
}

/* Form Groups (optional styling for the form) */
.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-group input,
.form-group textarea,
.form-group select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

    .success {
      color: green;
    }
    .error {
      color: red;
    }
    .mood-graph {
      margin-top: 20px;
    }
    
.profile-icon {
    margin-left: 10px;
    text-decoration: none;
   
    }

    .profile-img {
    height: 30px; /* Adjust size as needed */
    width: auto;  /* Keeps the aspect ratio */
    vertical-align: middle;
    border-radius: 100px;
   
    }
    /* Logo Styling */
.logo {
  display: contents;
  align-items: center;
  justify-content: center;
  
}

.logo-img {
  width: 120px;    /* Adjust the size of the logo */
  height: 120px;    /* Maintain the aspect ratio of the logo */
  object-fit: contain;  /* Ensures the logo fits inside the container */
}
.logo-img {
  width: 150%;  /* Responsive size */
  max-width: 200px;  /* Maximum size */
  height: auto;
}
header nav ul {
  list-style-type: none;
  padding: 0;
}

header nav ul li {
  display: inline;
  margin: 0 15px;
}

header nav ul li a {
  text-decoration: none;
  color: #fff;
  font-weight: bold;
  padding: 10px;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}


header nav ul li a:hover {
  background-color: #d3a4c1; /* Slightly darker pastel pink */
}
header nav{
  background: #f9c0d794; /* Pastel pink background */
  color: #4a4a4a; /* Dark gray text color */
  display: flex;
  padding: 10px;
  text-align: center;
  justify-content: space-between;
  align-items: center;

  top: 0;
  z-index: 10;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

nav ul {
  list-style: none;
  display: flex;
}

nav ul li {
  margin: 0 1rem;
}

nav ul li a {
  color: #4a4a4a; /* Dark gray for links */
  text-decoration: none;
  font-weight: bold;
  transition: color 0.3s ease;
}

nav ul li a:hover {
  color: #e63946; /* Coral red hover effect */
}

/* Buttons in Navbar */
.nav-buttons {
  display: flex;
  gap: 10px;
}

.nav-btn {
  padding: 10px 15px;
  background-color: #000000; /* Dark gray for Sign In */
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.nav-btn:hover {
  background-color: #ff9d9d; /* Slightly darker gray hover */
}
.profile-icon {
  margin-left: 10px;
  text-decoration: none;
}
.profile-img {
  height: 24px; /* Adjust size as needed */
  width: auto;
  vertical-align: middle;
}
  </style>
</head>
<body>
   
<header style="position: sticky; top: 0; z-index: 1000;">
  <nav style="background-color:#f9c0d794;">
  <!-- Logo Section -->
  <div class="logo">
    <a href="index.php">
      <img src="assets/images/logo.png" alt="MindCare Logo" class="logo-img">
    </a>
  </div>
  

    <ul>
      <li><a href="about.html">About</a></li>
      <li><a href="services.html">Services</a></li>
      <li><a href="therapist.php">Therapists</a></li>
      <li><a href="contact.html">Contact</a></li>
      <?php if (!isset($_SESSION['user_id'])): ?>
      <li><a href="signinsignup\signin.html">Sign In</a></li>
      <li><a href="signinsignup\signup1.php" style="color: #e63946;">Sign Up</a></li>
      <?php endif; ?>
      <a href="profile.php" class="profile-icon" title="Profile">
        <img src="assets/images/profile.gif" alt="Profile Image" class="profile-img">
      </a>
    </ul>
  </nav>

</header>
  <div class="container">
    <div class="logout">
      <a href="logout.php">Logout</a>
    </div>
    <h2>User Profile</h2>
    <?php if (isset($success)) { echo '<p class="success">' . $success . '</p>'; } ?>
    <?php if (isset($error)) { echo '<p class="error">' . $error . '</p>'; } ?>

    <div class="profile-container">
  <div class="profile-image-section">
    <?php if (!empty($user['profile_pic'])): ?>
      <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" class="profile-pic">
      <div class="profile-image-buttons">
      <form action="upload_profile_pic.php" method="POST" enctype="multipart/form-data" style="text-align: center; margin-top: 20px;">
    <!-- File Input with inline CSS -->
    <input type="file" name="profile_pic" accept="image/*" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; margin-bottom: 10px;">

    <!-- Submit Button with inline CSS -->
    <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; transition: background-color 0.3s ease;">
        Upload
    </button>
</form>


         <a href="delete_profile_pic.php" class="btn delete-btn">Delete Photo</a>
      </div>
    <?php else: ?>
      <img src="assets/images/user.png" alt="Default Profile Picture" class="profile-pic">
      <form action="upload_profile_pic.php" method="POST" enctype="multipart/form-data" style="text-align: center; margin-top: 20px;">
    <!-- File Input with inline CSS -->
    <input type="file" name="profile_pic" accept="image/*" required style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1em; margin-bottom: 10px;">

    <!-- Submit Button with inline CSS -->
    <button type="submit" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; transition: background-color 0.3s ease;">
        Upload
    </button>
</form>

    <?php endif; ?>
  </div>
  <div class="profile-info-section">
    <!-- Example form for updating user details -->
    <form action="profile.php" method="post">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
      </div>
      <div class="form-group">
        <label for="email">Email (cannot be changed)</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
      </div>
      <div class="form-group">
        <label for="phone">Contact Number</label>
        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
      </div>
      <div class="form-group">
        <label for="emergency_contact">Emergency Contact</label>
        <input type="text" id="emergency_contact" name="emergency_contact" value="<?php echo htmlspecialchars($user['emergency_contact']); ?>">
      </div>
      <div class="form-group">
      <?php
$dob_value = ($user['dob'] == "0000-00-00" || empty($user['dob'])) ? "" : $user['dob'];
?>
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($dob_value); ?>">
      </div>
      <div class="form-group">
        <label for="gender">Gender</label>
        <select name="gender" id="gender">
          <option value="">Select Gender</option>
          <option value="Male" <?php if($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
          <option value="Female" <?php if($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
          <option value="Other" <?php if($user['gender'] == 'Other') echo 'selected'; ?>>Other</option>
        </select>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
      </div>
      <button type="submit" style="padding: 10px 20px; background-color: #f86d7a; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 1.1em; transition: background-color 0.3s ease;">
    Save Changes
</button>
    </form>
  </div>
</div>


    <!-- Link to Detailed Mood Graph -->
    <div class="mood-graph" style="text-align: center;">
  <a href="user_dashboard.php">
    <button type="button" style="padding: 12px 25px; background-color: #f86d7a; color: white; border: none; border-radius: 5px; font-size: 1.2em; cursor: pointer; transition: background-color 0.3s ease;">
      View Detailed Mood Graph For You
    </button>
  </a>
</div>
<div class="mood-graph" style="text-align: center;">
  <a href="my_appointments.php">
    <button type="button" style="padding: 12px 25px; background-color: #f86d7a; color: white; border: none; border-radius: 5px; font-size: 1.2em; cursor: pointer; transition: background-color 0.3s ease;">
      appointments
    </button>
  </a>
</div>

  </div>
</body>
</html>
