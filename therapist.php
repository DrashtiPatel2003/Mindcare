<?php 
session_start(); 
include 'includes/db_connect.php';

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Therapists | Mental Health</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #FFF0F5; /* Light pastel pink */
      margin: 0;
      
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
    .therapist-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }
    .therapist-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      overflow: hidden;
      width: 350px;
      padding: 20px;
      text-align: left;
      position: relative;
      transition: transform 0.3s ease-in-out;
    }
    .therapist-card:hover {
      transform: translateY(-5px);
    }
    .therapist-card img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #FFD1DC; /* Pastel pink border */
    }
    .therapist-header {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .therapist-name {
      font-size: 18px;
      font-weight: bold;
      color: #4A4A4A;
    }
    .therapist-exp {
      font-size: 14px;
      color: #888;
    }
    .therapist-info {
      margin-top: 10px;
      font-size: 14px;
      color: #666;
    }
    .badge {
      display: inline-block;
      background: #FFD1DC;
      color: #4A4A4A;
      font-size: 12px;
      padding: 5px 10px;
      border-radius: 5px;
      margin: 5px 3px 5px 0;
    }
    .session-buttons {
      margin-top: 15px;
      display: flex;
      gap: 10px;
    }
    .session-btn {
      border: none;
      padding: 8px 14px;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s;
    }
    .online-btn {
      background: #FFB6C1;
      color: white;
    }
    .offline-btn {
      background: white;
      border: 2px solid #FFB6C1;
      color: #FFB6C1;
    }
    .online-btn:hover {
      background: #ff8ca2;
    }
    .offline-btn:hover {
      background: #FFB6C1;
      color: white;
    }
    .appointment-info {
      margin-top: 15px;
      font-size: 14px;
      color: #666;
    }
    .book-btn {
      background: #52734D;
      color: white;
      padding: 10px 16px;
      font-size: 14px;
      border-radius: 8px;
      cursor: pointer;
      border: none;
      width: 100%;
      margin-top: 10px;
    }
    .book-btn:hover {
      background: #41613C;
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
        <li><a href="about.php">About</a></li>
        <li><a href="services.html">Services</a></li>
        <li><a href="therapist.php">Therapists</a></li>
        <li><a href="contact.php">Contact</a></li>
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
      <section style="padding: 40px 20px; text-align: center; margin-top: 20px;">
  <h1 style="font-size: 2.5em; color: #f86d7a; margin: 0;">Our Therapists</h1>
</section>

<section class="therapist-list">
 
    <?php
    $sql = "SELECT * FROM therapists";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
    ?>
    <div class="therapist-card">
        <div class="therapist-header">
            <img src="assets/images/<?php echo basename($row['image']); ?>" alt="<?php echo $row['name']; ?>">
            <div>
                <div class="therapist-name"><?php echo $row['name']; ?></div>
                <div class="therapist-exp"><?php echo $row['experience']; ?> years of experience</div>
            </div>
        </div>
        <div class="therapist-info">
            <p>Starts @ <strong>₹<?php echo $row['price']; ?></strong> for 50 mins</p>
            <p>Expertise:</p>
            <span class="badge"><?php echo $row['specialization']; ?></span>
        </div>
        <div class="session-buttons">
          <?php if ($row['session_type'] == "Online" || $row['session_type'] == "Both") : ?>
              <button class="session-btn online-btn">Online</button>
          <?php endif; ?>
          <?php if ($row['session_type'] == "Offline" || $row['session_type'] == "Both") : ?>
              <button class="session-btn offline-btn">In-person</button>
          <?php endif; ?>
        </div>
       
        <?php if ($is_logged_in): ?>
        <a href="therapist_detail.php?id=<?php echo $row['id']; ?>">
          <button class="book-btn">BOOK</button>
        </a>
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
      <?php else: ?>
        <a href="signinsignup/signin.html">
          <button class="book-btn">Sign In to Book</button>
        </a>
      <?php endif; ?>
    </div>
    <?php } ?>
</section>

</body>
</html>
<?php $conn->close(); ?>
