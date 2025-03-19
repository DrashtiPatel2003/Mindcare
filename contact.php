<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MindCare - Contact Us</title>
  <link rel="stylesheet" href="assets/CSS/styles.css">
</head>
<body>
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
    
    /* Main container styling */
    .contact-hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 100vh;
        width: 100%;
        padding: 20px;
        background-color: #fff8f6; /* Optional background for better visibility */
    }
  
    /* Text content styling */
    .content {
        flex: 1;
        padding: 20px;
        animation: slide-in-left 1s ease-in-out;
    }
  
    .content h1 {
        font-size: 3rem;
        color: #000000;
    }
    .content p {
      color: #000000;

    }
  
    /* Image container styling */
    .image-container {
        flex: 1;
        background: url('assets/images/contactus.svg') no-repeat center center;
        background-size: contain;
        height: 80%;
        animation: slide-in-right 1s ease-in-out;
    }
  
    /* Slide-in animations */
    @keyframes slide-in-left {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
  
    @keyframes slide-in-right {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
   
    /* Hover effect for text */
    .content h1:hover {
        color: #f782bc;
        transform: scale(1.1);
        transition: all 0.3s ease;
    }
    .content p:hover {
        color: #f782bc;
        transform: scale(1.1);
        transition: all 0.3s ease;
    }
  
    /* Responsive design */
    @media (max-width: 768px) {
        .contact-hero {
            flex-direction: column;
            text-align: center;
        }
  
        .image-container {
            height: 50%;
        }
  
        .content h1 {
            font-size: 2rem;
        }
    }
    
   
  </style>
  <!-- Navigation -->

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
  <!-- Contact Section -->
  <div class="contact-hero">
    <div class="content">
        <h1>Contact Us</h1>
        <p style="font-size: 18px;">We’d love to hear from you! Reach out to us for any inquiries or support.</p>
        <p style="font-size: 18px;">Scroll and fill the form below. We will contact you as soon as possible.</p>
    </div>
    <div class="image-container"></div>
</div>
  <section class="contact-section">
    <h2 style="color: #f86d7a;">We'd love to hear from you!</h2>
    <form action="process\process_contact.php" method="POST" id="contactForm">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" placeholder="Your Name" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="Your Email" required>

      <label for="message">Message</label>
      <textarea id="message" name="message" placeholder="Write your message here..." rows="6" required></textarea>

      <button type="submit" class="cta-btn">Send Message</button>
    </form>
  </section>

  <footer>
    <p>&copy; 2025 MindCare. All rights reserved.</p>
  </footer>
</body>
</html>
