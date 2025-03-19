<?php
session_start();
include 'includes/db_connect.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details (name and email)
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = mysqli_fetch_assoc($result);
$stmt->close();

if (!$user) {
    echo "User not found.";
    exit;
}

// Fetch appointments for this user using user_id (assumes appointments table now has a user_id column)
$query = "SELECT a.*, t.name AS therapist_name 
          FROM appointments a 
          JOIN therapists t ON a.therapist_id = t.id 
          WHERE a.user_id = ? 
          ORDER BY a.date DESC, a.time_slot DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$resultAppointments = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
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

        body {
   
    color: #333;
    margin: 0;
    background: #fff0f5; /* Pastel Pink */
    font-family: 'Arial', sans-serif;
    
    flex-direction: column;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 50px;
    background-color: #fff0f5;;
    border-radius: 10px;
    
}

h1 {
    text-align: center;
    color: #FF61A6;
}

.appointment {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 15px;
    margin: 15px 0;
    background-color: #fff;
    transition: box-shadow 0.3s ease;
}

.appointment:hover {
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.appointment h3 {
    margin: 0 0 10px;
    color: #FF61A6;
}

.appointment p {
    margin: 5px 0;
}

.action-buttons {
    margin-top: 10px;
}

.action-buttons form,
.action-buttons a {
    display: inline-block;
    margin-right: 10px;
}

.action-buttons button {
    background-color: #FF61A6;
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.9em;
    transition: background-color 0.3s ease;
}

.action-buttons button:hover {
    background-color: #e05599;
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
    <h1>My Appointments</h1>
    <div class="user-info">
        <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    </div>
    <?php if ($resultAppointments->num_rows > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($resultAppointments)): ?>
            <div class="appointment">
                <h3>Therapist: <?php echo htmlspecialchars($row['therapist_name']); ?></h3>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?></p>
                <p><strong>Time:</strong> <?php echo htmlspecialchars(date("h:i A", strtotime($row['time_slot']))); ?></p>
                <p><strong>Session Type:</strong> <?php echo htmlspecialchars($row['session_type']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?></p>
                <?php if (!empty($row['primary_concern'])): ?>
                    <p><strong>Primary Concern:</strong> <?php echo htmlspecialchars($row['primary_concern']); ?></p>
                <?php endif; ?>
                <?php if (!empty($row['referral'])): ?>
                    <p><strong>Referral:</strong> <?php echo htmlspecialchars($row['referral']); ?></p>
                <?php endif; ?>
                <?php if ($row['status'] !== 'Cancelled'): ?>
                    <div class="action-buttons">
                        <!-- Cancel Appointment -->
                        <form action="cancel_appointment.php" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                            <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Cancel</button>
                        </form>
                        <!-- Reschedule Appointment -->
                       


                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>You haven't booked any appointments yet.</p>
    <?php endif; ?>
</div>
</body>
</html>