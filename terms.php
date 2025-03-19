<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions</title>

    <style>
        /* Inbuilt CSS for a Detailed Terms and Conditions Page */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f7f7;
            color: #333;
            line-height: 1.8;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        h2 {
            color: #f86d7a;
            text-align: center;
            margin-bottom: 20px;
        }

        h3 {
            color: #f86d7a;
            margin-top: 20px;
        }

        p {
            font-size: 1.1em;
            line-height: 1.6;
        }

        ul {
            padding-left: 20px;
            font-size: 1.1em;
        }

        ul li {
            margin-bottom: 15px;
        }

        .content {
            padding: 20px;
            font-size: 1.1em;
        }

        .accordion {
            background-color: #dca9ae;
            color: white;
            cursor: pointer;
            padding: 15px;
            width: 100%;
            border: none;
            text-align: left;
            font-size: 1.1em;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .accordion:hover {
            background-color: #f8c2d4;
        }

        .panel {
            padding: 0 18px;
            display: none;
            background-color: #f1f1f1;
            overflow: hidden;
        }

        .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black;
            cursor: pointer;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%; /* Position above the text */
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

    /* Progress Container */
    .progress-container {
      width: 100%;
      background-color: #f1f1f1;
      border-radius: 5px;
      position: fixed; /* Sticky at bottom */
      bottom: 0;
      left: 0;
      z-index: 1000; /* Ensure it's on top */
      padding: 0 10px;
    }
    /* Progress Bar */
    .progress-bar {
      height: 8px;
      background-color: #efacb3;
      width: 0%;
      border-radius: 5px;
      transition: width 0.3s ease;
    }

        .accept-btn {
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

        .accept-btn:hover {
            background-color: #f8c2d4;
            transform: scale(1.05);
        }

        .back-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #f86d7a;
            color: #fff;
            text-align: center;
            font-size: 1.2em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back-btn:hover {
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

        @media (max-width: 768px) {
            header {
                font-size: 2em;
            }

            .container {
                padding: 20px;
            }

            .accept-btn {
                font-size: 1.1em;
                width: 200px;
            }

            .back-btn {
                font-size: 1.1em;
                width: 180px;
            }
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
        <h2>Terms and Conditions</h2>
        <div class="content">
            <p>Welcome to the Mental Health Project! We are committed to providing valuable mental health support while maintaining your privacy and safety. Please carefully read these terms and conditions before using our website and services.</p>

            <h3>1. Acceptance of Terms</h3>
            <p>By accessing and using this website, you agree to comply with and be bound by these Terms and Conditions. If you do not agree to these terms, please do not use this site.</p>

            <h3>2. Use of Services</h3>
            <p>The services provided through this website are intended for mental health support, advice, and analysis. The data you provide will be treated confidentially and used to tailor the support we offer. However, we do not replace professional medical care, and we encourage users to seek advice from healthcare professionals when necessary.</p>

            <h3>3. User Responsibilities</h3>
            <ul>
                <li>Users must provide accurate information when using our services.</li>
                <li>Users are responsible for maintaining the confidentiality of their accounts and any activities that occur under their account.</li>
                <li>You agree not to use our services for any unlawful purpose or in any manner that could damage, disable, or impair the website.</li>
            </ul>

            <h3 class="tooltip">4. Privacy and Data Collection <span class="tooltip-text">Your privacy is important to us. We take necessary steps to protect your data.</span></h3>
            <p>Your privacy is very important to us. Please review our <a href="privacy.html" class="footer-link" style="color: #f86d7a;">Privacy Policy</a> to understand how we collect, use, and protect your personal information. By using this website, you consent to the collection and use of your data as described in our privacy policy.</p>

            <button class="accordion">5. Changes to Terms</button>
            <div class="panel">
                <p>We reserve the right to update or modify these Terms and Conditions at any time. Any changes will be reflected on this page with an updated date. Your continued use of the website after changes constitutes your acceptance of the updated terms.</p>
            </div>

            <button class="accordion">6. Limitation of Liability</button>
            <div class="panel">
                <p>We strive to offer accurate and helpful information, but we cannot guarantee the accuracy or completeness of the content on the site. We are not responsible for any damages or issues that arise from using this website, including any decisions made based on the information provided.</p>
            </div>

            <button class="accordion">7. External Links</button>
            <div class="panel">
                <p>Our website may contain links to external websites. These links are provided for convenience, but we do not endorse or have control over the content of these websites. We are not responsible for any external content or services.</p>
            </div>

            <h3>8. Termination</h3>
            <p>We reserve the right to suspend or terminate your access to the website at our discretion, especially if we suspect that you are violating these terms. We will notify you in such cases.</p>

            <h3>9. Governing Law</h3>
            <p>These terms will be governed by the laws of your country, and any disputes arising under these terms will be subject to the jurisdiction of the appropriate courts.</p>

            <button class="accept-btn" onclick="window.location.href='index.php'">Accept Terms</button>

            <button class="back-btn" onclick="window.location.href='index.php'">Back</button>
        </div>
    </div>

    <footer>
        <p>For more information, visit our <a href="privacy.html" class="footer-link">Privacy Policy</a> and <a href="contact.php" class="footer-link">Contact Us</a></p>
    </footer>

    <div class="progress-container">
        <div class="progress-bar" id="progress-bar"></div>
      </div>
    
    <script>
        const accordions = document.querySelectorAll(".accordion");
        accordions.forEach(accordion => {
            accordion.addEventListener("click", function () {
                this.classList.toggle("active");
                const panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        });
    // Get the progress bar element
    let progressBar = document.getElementById('progress-bar');
    let progress = 0;
    let interval = setInterval(function () {
      if (progress >= 100) {
        clearInterval(interval);
      } else {
        progress++;
        progressBar.style.width = progress + '%';
        console.log('Progress: ' + progress + '%');
      }
    }, 20);
    </script>

</body>

</html>
