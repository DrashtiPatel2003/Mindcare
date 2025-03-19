<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index2.php");
    exit;
}
?>
<?php
// Include database connection
include '../includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>
  <style>
    /* General Body Styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #fffaf5; /* Light pastel pink */
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    /* Sidebar Styles */
    .sidebar {
      width: 260px;
      background-color: #ffe6f0; /* Pastel pink */
      padding: 20px;
      position: fixed;
      height: 100%;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease-in-out;
      z-index: 1000;
    }
    .sidebar h2 {
      color: #5a5a5a;
      text-align: center;
      margin-bottom: 20px;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
    }
    .sidebar ul li {
      margin: 15px 0;
    }
    .sidebar ul li a {
      text-decoration: none;
      color: #5a5a5a;
      padding: 12px 15px;
      display: block;
      border-radius: 8px;
      font-weight: bold;
      transition: all 0.3s ease;
    }
    .sidebar ul li a:hover {
      background-color: #ff99c8; /* Bright pastel pink */
      color: white;
      transform: scale(1.05);
    }
    /* Sidebar Toggle Button for Mobile */
    .sidebar-toggle {
      display: none;
      position: absolute;
      top: 15px;
      left: 15px;
      background-color: #ff99c8;
      color: white;
      border: none;
      padding: 10px 12px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 18px;
    }
    .sidebar-toggle:hover {
      background-color: #cc6699;
    }
    /* Main Content Styles */
    .main-content {
      margin-left: 280px; /* Sidebar width + margin */
      padding: 40px;
      background-color: #fff; /* White background */
      flex: 1;
      transition: margin-left 0.3s ease-in-out;
    }
    .main-content header h1 {
      color: #5a5a5a;
      margin-bottom: 25px;
      text-align: center;
    }
    /* Dashboard Container */
    .dashboard-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
      margin-top: 20px;
      padding-bottom: 20px;
    }
    /* Dashboard Card */
    .dashboard-card {
      background-color: #ffe6f0; /* Pastel pink */
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    .dashboard-card h3 {
      color: #5a5a5a;
      margin-bottom: 12px;
    }
    .dashboard-card p {
      color: #5a5a5a;
      margin-bottom: 15px;
    }
    /* Buttons */
    .dashboard-card .btn {
      text-decoration: none;
      background-color: #ff99c8; /* Bright pastel pink */
      color: white;
      padding: 10px 15px;
      border-radius: 8px;
      font-weight: bold;
      display: inline-block;
      transition: background-color 0.3s ease;
    }
    .dashboard-card .btn:hover {
      background-color: #cc6699; /* Darker pastel pink */
      transform: scale(1.05);
    }
    /* Footer */
    footer {
      text-align: center;
      padding: 15px;
      background-color: #ffe6f0; /* Pastel pink */
      color: #5a5a5a;
      width: 100%;
      margin-top: auto;
    }
    /* Responsive Design */
    @media (max-width: 1024px) {
      .sidebar {
        width: 220px;
      }
      .main-content {
        margin-left: 240px;
      }
    }
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
        width: 240px;
      }
      .sidebar.show {
        transform: translateX(0);
      }
      .sidebar-toggle {
        display: block;
      }
      .main-content {
        margin-left: 0;
        padding: 20px;
      }
      .dashboard-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <main>
    <!-- Sidebar -->
    <div class="sidebar">
      <h2>Admin Panel</h2>
      
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="view_messages.php">View Messages</a></li>
        <li><a href="manage_questions.php">Manage Questions</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
    <!-- Main Content -->
    <div class="main-content">
      <header>
        <h1>Admin Dashboard</h1>
      </header>
      <section class="dashboard-container">
        <!-- Dashboard Card 1: View User Messages -->
        <div class="dashboard-card">
          <h3>View User Messages</h3>
          <p>Read messages sent by users through the contact form.</p>
          <a href="view_message.php" class="btn">Go to Messages</a>
        </div>
        <!-- Dashboard Card 2: Manage Questions -->
        <div class="dashboard-card">
          <h3>Manage Questions</h3>
          <p>Update and manage the questions for the mental health questionnaire.</p>
          <a href="manage_questions.php" class="btn">Go to Questions</a>
        </div>
        <!-- Dashboard Card 3: Manage Users -->
        <div class="dashboard-card">
          <h3>Manage Users</h3>
          <p>Update user information and control access rights.</p>
          <a href="manage_users.php" class="btn">Go to Users</a>
        </div>
        <!-- Dashboard Card 4: User Mood -->
        <div class="dashboard-card">
          <h3>User Mood</h3>
          <p>Track user's mood and activity.</p>
          <a href="manage_mood.php" class="btn">Go to Mood</a>
        </div>
        <!-- Dashboard Card 5: Add Therapist -->
        <div class="dashboard-card">
          <h3>Add Therapist</h3>
          <p>Add a new therapist from here.</p>
          <a href="add_therapist.php" class="btn">Add</a>
        </div>
        <!-- Dashboard Card 6: Edit Therapist Details -->
        <div class="dashboard-card">
          <h3>Edit Therapist Details</h3>
          <p>Edit existing therapist details.</p>
          <a href="therapist_admin.php" class="btn">Edit</a>
        </div>
        <div class="dashboard-card">
          <h3>Questionnaire Responses</h3>
          <p>View responses from users for questionnaire</p>
          <a href="view_questionnaire_responses.php" class="btn">View</a>
        </div>
        <div class="dashboard-card">
          <h3>View Appointments</h3>
          <p>User Appointments</p>
          <a href="view_appointments.php" class="btn">View</a>
        </div>
        <div class="dashboard-card">
          <h3>News Letter Subscribers</h3>
          <p>View them </p>
          <a href="news.php" class="btn">View</a>
        </div>
      </section>
    </div>
  </main>
  <footer>
    <p>© 2025 Mental Health Project. All rights reserved.</p>
  </footer>

</body>
</html>
