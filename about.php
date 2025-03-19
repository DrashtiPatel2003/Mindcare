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
    <title>About Us - Mental Health Project</title>

    <style>

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
        /* Inbuilt CSS for About Us Page */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f7f7;
            color: #333;
            line-height: 1.8;
        }


        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: scale(1.02);
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #f86d7a;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.2em;
        }

        p {
            font-size: 1.1em;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .section-title {
            color: #f86d7a;
            font-size: 1.8em;
            margin-top: 30px;
            text-align: center;
        }

        .section-content {
            font-size: 1.1em;
            color: #555;
            text-align: center;
            margin-top: 15px;
            line-height: 1.8;
            padding: 0 20px;
        }

        .team {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        .team-member {
            margin: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .team-member img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .team-member img:hover {
            transform: scale(1.1);
        }

        .team-member h3 {
            margin-top: 15px;
            color: #f86d7a;
        }

        .team-member p {
            color: #555;
        }

        .footer-btn {
            display: block;
            width: 250px;
            margin: 30px auto;
            padding: 15px;
            background-color: #f86d7a;
            color: #fff;
            text-align: center;
            font-size: 1.2em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .footer-btn:hover {
            background-color: #f8c2d4;
            transform: scale(1.05);
        }

        footer {
            background-color: #f8c2d4;
            padding: 15px;
            text-align: center;
            color: #fff;
        }

        .footer-link {
            color: #fff;
            text-decoration: none;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .team {
                flex-direction: column;
                align-items: center;
            }
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
      

    <div class="container">
        <h2>About Us</h2>
        <p>Welcome to the Mental Health Project, a platform dedicated to improving mental health awareness, offering personalized support, and promoting wellness through technology. Our mission is to make mental health support accessible, comforting, and easily available for everyone in need. In an era where mental health challenges are becoming more widespread, we strive to break down the stigma and provide resources to those who need it the most.</p>

        <div class="section-title">Our Mission</div>
        <div class="section-content">
            <p>We believe that mental health is just as important as physical health. Our mission is to provide a safe space where individuals can access resources, advice, and counseling to help them manage stress, anxiety, depression, and other mental health challenges. With the power of AI and machine learning, we aim to revolutionize mental health care, making it more accessible and personalized than ever before. Our technology leverages real-time data to offer individualized advice, treatment suggestions, and support systems, ensuring every person receives care tailored to their unique needs.</p>
        </div>

        <div class="section-title">Our Values</div>
        <div class="section-content">
            <p>We are committed to providing non-judgmental, empathetic, and scientifically-backed solutions to mental health. Our values include:</p>
            <ul>
                <li>Empathy and Compassion: We listen to everyone, no matter their background or situation, with the utmost empathy.</li>
                <li>Accessibility and Inclusion: Our services are designed to be available to everyone, regardless of their social, economic, or geographical status.</li>
                <li>Confidentiality and Security: We prioritize your privacy and ensure all your information is kept safe and confidential.</li>
                <li>Continuous Improvement and Innovation: We believe in constantly evolving our approach to mental health by utilizing the latest research and technology to improve our services.</li>
            </ul>
        </div>

        <div class="section-title">Meet Our Team</div>
        <div class="team">
            <div class="team-member">
                <img src="assets/images/drashti.png" alt="Team Member 1">
                <h3>Drashti Patel</h3>
             
            </div>
            <div class="team-member">
                <img src="assets/images/dev.png" alt="Team Member 2">
                <h3>Dev Salot</h3>
              
            </div>
            <div class="team-member">
                <img src="assets/images/anand.png" alt="Team Member 3">
                <h3>Anand Patel</h3>
                
            </div>
        </div>

        <button class="footer-btn" onclick="contactUs()">Get In Touch</button>

    </div>

    <footer>
        <p>&copy; 2025 Mental Health Project. All rights reserved. | <a href="terms.php" class="footer-link">Terms of Service</a> | <a href="privacy.html" class="footer-link">Privacy Policy</a></p>
    </footer>

    <script>
        // JS to navigate to the contact page when the "Get In Touch" button is clicked
        function contactUs() {
            window.location.href = "contact.php"; // Redirect to contact us page
        }
    </script>

</body>

</html>
