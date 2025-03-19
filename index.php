<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MindCare - Home</title>
  <link rel="stylesheet" href="assets/css/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>


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
    @keyframes slideInFromRight {
    from {
      opacity: 0;
      transform: translateX(100px);
    }
    to {
      opacity: 1;
      transform: translateX(0);
    }
  }
  @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    /* Hover Effect on Service Cards */
    .service:hover {
      transform: scale(1.05);
    }
    /* Container for the icon */
    .info-icon {
    display: inline-block;
    vertical-align: middle;
  }
  
  /* Icon image styles */
  .info-image {
    width: 40px; /* Adjust the size as needed */
    height: auto;
    border-radius: 40%;
    transition: transform 0.3s ease;
  }
  
  /* Hover effect to slightly enlarge the icon */
  .info-icon:hover .info-image {
    transform: scale(1.1);
  }
    
</style>  

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

<section>
<!-- Hero Section -->
<div class="hero">
  <img src="assets/images/hero.png" alt="Hero Image" class="hero-img">
  <div class="herotext">
    <h1>Welcome to MindCare</h1>
    <p>Your journey to mental wellness starts here.</p>
    <a href="services.html" class="cta-btn">Explore Services</a>
  </div>
</div>

</section>  

<section id="about" style="display: flex; flex-direction: row; align-items: center; justify-content: center; padding: 10px 20px; min-height: 100vh; background: #fff0f5;">
    
  <!-- Text Container (Left Side) -->
  <div style="flex: 1; padding: 20px;">
    <h2 style="font-size: 48px; margin-bottom: 20px; color: #d63384; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">
      About Us
      <a href="about.php" class="info-icon" title="Learn More About Us">
        <img src="assets/images/infoanim.gif" alt="Information Icon" class="info-image">
      </a>
    </h2>
    <p style="font-size: 20px; line-height: 1.6; margin-bottom: 30px; color: #333; text-shadow: 1px 1px 3px rgba(0,0,0,0.3);">
      At MindCare, we believe that mental health is as important as physical health. Our platform is designed to offer tools, resources, and support to help you achieve a balanced and healthy mind.
    </p>
    <!-- Button directing to the About Us page -->
    <a href="about.php" 
       style="display: inline-block; background: linear-gradient(to right, #ff66b2, #ff85a2); color: #fff; padding: 12px 25px; border-radius: 10px; text-decoration: none; font-size: 18px; font-weight: bold; box-shadow: 0 4px 10px rgba(0,0,0,0.3); text-shadow: 1px 1px 2px rgba(0,0,0,0.3); transition: background 0.3s ease;"
       onmouseover="this.style.background='linear-gradient(to right, #e63988, #ff77c0)'"
       onmouseout="this.style.background='linear-gradient(to right, #ff66b2, #ff85a2)'">
       Discover More
    </a>

  </div>
  
  <!-- Image Container (Right Side) -->
  <div style="flex: 1; padding: 20px; display: flex; justify-content: center; align-items: center;">
    <img id="about-image" src="assets/images/teamwork.png" alt="Teamwork" 
         style="max-width: 100%; opacity: 0; transform: translateX(100px);" />
  </div>
</section>





<!-- Services Section -->
<section id="services" class="services-section" style="padding: 80px 20px; background: #f9f9f9; text-align: center;">
  <h2 style="font-size: 36px; margin-bottom: 30px; color: #d63384;">Our Services</h2>
  <div class="services-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
    
    <!-- Service Card 1: Self-Assessments -->
    <div class="service" style="flex: 1 1 300px; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: transform 0.3s ease; opacity: 0; transform: translateY(30px);">
      <img src="assets/images/selfasses.jpg" alt="Self-Assessments" style="width: 50%; margin-bottom: 20px; border-radius: 5px;">
      <h3 style="font-size: 24px; margin-bottom: 10px; color: #333;">Self-Assessments
        <a href="#" class="info-icon" title="Self-Assessments">
          <img src="assets/images/quiz.gif" alt="Information Icon" class="info-image">
        </a>
      </h3>
      <p style="font-size: 16px; color: #555;">Take personalized assessments to understand your mental health better.</p>
      <a href="questionnaire.php" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background: linear-gradient(to right, #ff66b2, #ff85a2); color: #fff; text-decoration: none; border-radius: 8px; font-weight: bold;">Learn More</a>
    </div>
    
    <!-- Service Card 2: AI Insights -->
    <div class="service" style="flex: 1 1 300px; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: transform 0.3s ease; opacity: 0; transform: translateY(30px);">
      <img src="assets/images/chatbot.jpg" alt="AI Insights" style="width: 50%; margin-bottom: 20px; border-radius: 5px;">
      <h3 style="font-size: 24px; margin-bottom: 10px; color: #333;">AI Insights       
        <a href="#" class="info-icon" title="AI system">
        <img src="assets/images/artificial.gif" alt="Information Icon" class="info-image">
      </a></h3>
      <p style="font-size: 16px; color: #555;">Leverage AI-powered insights for actionable recommendations.</p>
      <a href="http://127.0.0.1:5002" target="_blank"  style="display: inline-block; margin-top: 10px; padding: 10px 20px; background: linear-gradient(to right, #ff66b2, #ff85a2); color: #fff; text-decoration: none; border-radius: 8px; font-weight: bold;">Open Chatbot</a>

    </div>
    
<!-- Service Card: Mood Tracker -->
<div class="service" style="flex: 1 1 300px; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: transform 0.3s ease; opacity: 0; transform: translateY(30px);">
  <img src="assets/images/moodtracker.jpg" alt="Mood Tracker" style="width: 50%; margin-bottom: 20px; border-radius: 5px;">
  <h3 style="font-size: 24px; margin-bottom: 10px; color: #333;">
    Mood Tracker
    <a href="#" class="info-icon" title="Track your mood" style="display: inline-block; vertical-align: middle; margin-left: 5px;">
      <img src="assets/images/self-control.gif" alt="Information Icon" class="info-image" style="width: 50px; height: auto; vertical-align: middle;">
    </a>
  </h3>
  <p style="font-size: 16px; color: #555;">
    Track your daily mood and visualize your emotional trends with our interactive tracker.
  </p>
  <a href="moodtracker.php" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background: linear-gradient(to right, #ff66b2, #ff85a2); color: #fff; text-decoration: none; border-radius: 8px; font-weight: bold;">
    Track Now
  </a>
</div>
    
  </div>
</section>


  <div class="relax-section" style="text-align: center; margin: 50px auto; width: 90%; max-width: 1200px;">
    <h2 style="font-size: 2.5em; color: #d45d6f; margin-bottom: 30px;">Relax & Recharge</h2>
       
    <!-- Carousel Container -->
    <div class="carousel" style="position: relative; overflow: hidden; width: 100%;">

        <!-- Carousel Images/Items -->
        <div class="carousel-items" style="display: flex; transition: transform 0.5s ease;">
            <div class="carousel-item" style="min-width: 100%; box-sizing: border-box; padding: 20px;">
                <div class="card" style="background-color: #fff; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; text-align: center;">
                    <img src="assets\images\cat.jpg" alt="Funny Video" style="width: 100%; border-radius: 10px; max-height: 300px; object-fit: cover;">
                    <h3 style="color: #d45d6f; margin-top: 15px;">Funny Cat Videos</h3>
                    <p>Watch funny videos to lift your spirits!</p>
                    <a href="cat.html" style="background-color: #d45d6f; color: white; padding: 10px 20px; text-decoration: none; border-radius: 25px;">Explore</a>
                </div>
            </div>
            <div class="carousel-item" style="min-width: 100%; box-sizing: border-box; padding: 20px;">
                <div class="card" style="background-color: #fff; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; text-align: center;">
                    <img src="assets/images/yoga.jpg" alt="Yoga Practice" style="width: 100%; border-radius: 10px; max-height: 300px; object-fit: cover;">
                    <h3 style="color: #d45d6f; margin-top: 15px;">Yoga & Mindfulness</h3>
                    <p>Relax your mind and body with simple yoga routines.</p>
                    <a href="yoga.html" style="background-color: #d45d6f; color: white; padding: 10px 20px; text-decoration: none; border-radius: 25px;">Explore</a>
                </div>
            </div>
            <div class="carousel-item" style="min-width: 100%; box-sizing: border-box; padding: 20px;">
                <div class="card" style="background-color: #fff; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; text-align: center;">
                    <img src="assets/images/standup.jpg" alt="Mindfulness" style="width: 100%; border-radius: 10px; max-height: 300px; object-fit: cover;">
                    <h3 style="color: #d45d6f; margin-top: 15px;">Standup Comedy</h3>
                    <p>Because laughter is the best therapy.</p>
                    <a href="standup.html" style="background-color: #d45d6f; color: white; padding: 10px 20px; text-decoration: none; border-radius: 25px;">Explore</a>
                </div>
            </div>
            <div class="carousel-item" style="min-width: 100%; box-sizing: border-box; padding: 20px;">
              <div class="card" style="background-color: #fff; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; text-align: center;">
                  <img src="assets/images/motivational.jpeg" alt="Yoga Practice" style="width: 100%; border-radius: 10px; max-height: 300px; object-fit: cover;">
                  <h3 style="color: #d45d6f; margin-top: 15px;">Motivational Videos</h3>
                  <p>Fuel your day with inspiration and positivity—watch motivational videos that ignite your passion and drive</p>
                  <a href="motivation.html" style="background-color: #d45d6f; color: white; padding: 10px 20px; text-decoration: none; border-radius: 25px;">Explore</a>
              </div>
          </div>
          <div class="carousel-item" style="min-width: 100%; box-sizing: border-box; padding: 20px;">
            <div class="card" style="background-color: #fff; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; text-align: center;">
                <img src="assets/images/breathing.jpg" alt="Yoga Practice" style="width: 100%; border-radius: 10px; max-height: 300px; object-fit: cover;">
                <h3 style="color: #d45d6f; margin-top: 15px;">Breathing Videos</h3>
                <p>Find your calm and recharge with guided breathing videos to help you relax and refocus.</p>
                <a href="breathing.html" style="background-color: #d45d6f; color: white; padding: 10px 20px; text-decoration: none; border-radius: 25px;">Explore</a>
            </div>
        </div>
        </div>

        <!-- Navigation Buttons -->
        <button class="prev" style="position: absolute; top: 50%; left: 10px; background-color: rgba(0, 0, 0, 0.5); color: white; border: none; padding: 10px; font-size: 1.5em; border-radius: 50%; transform: translateY(-50%); cursor: pointer;">&#10094;</button>
        <button class="next" style="position: absolute; top: 50%; right: 10px; background-color: rgba(0, 0, 0, 0.5); color: white; border: none; padding: 10px; font-size: 1.5em; border-radius: 50%; transform: translateY(-50%); cursor: pointer;">&#10095;</button>
    </div>
</div>

<footer style="background: linear-gradient(135deg, #ffe6f0, #fffaf5); color: #5a5a5a; padding: 80px 20px; font-family: Arial, sans-serif;">
  <!-- Tagline / Intro Section -->
  <div style="max-width: 1200px; margin: auto; text-align: center; margin-bottom: 40px;">
    <h2 style="color: #c94b8c; font-size: 36px; margin-bottom: 10px;">MindCare - Caring for Your Mind, Body &amp; Soul</h2>
    <p style="font-size: 18px; margin: 0;">Empowering your journey towards mental wellness with insights, support, and a caring community.</p>
  </div>
  
  <!-- Main Footer Columns -->
  <div style="max-width: 1200px; margin: auto; display: flex; flex-wrap: wrap; justify-content: space-between; text-align: left;">
    <!-- Quick Links Column -->
    <div style="flex: 1; min-width: 220px; margin: 10px;">
      <h4 style="color: #c94b8c; font-size: 20px; margin-bottom: 10px;">Quick Links</h4>
      <ul style="list-style: none; padding: 0;">
        <li style="margin-bottom: 8px;"><a href="about.php" style="text-decoration: none; color: #5a5a5a; font-size: 16px;">About Us</a></li>
        <li style="margin-bottom: 8px;"><a href="services.html" style="text-decoration: none; color: #5a5a5a; font-size: 16px;">Services</a></li>
        <li style="margin-bottom: 8px;"><a href="privacy.html" style="text-decoration: none; color: #5a5a5a; font-size: 16px;">Privacy Policy</a></li>
        <li style="margin-bottom: 8px;"><a href="terms.php" style="text-decoration: none; color: #5a5a5a; font-size: 16px;">Terms &amp; Conditions</a></li>
      </ul>
    </div>
    
    <!-- Contact Column -->
    <div style="flex: 1; min-width: 220px; margin: 10px;">
      <h4 style="color: #c94b8c; font-size: 20px; margin-bottom: 10px;">Contact</h4>
      <p style="margin: 4px 0; font-size: 16px;">Email: support@mindcare.in</p>
      <p style="margin: 4px 0; font-size: 16px;">Phone1: +91 9904414690</p>
      <p style="margin: 4px 0; font-size: 16px;">Phone2: +91 9974835039</p>
      <p style="margin: 4px 0; font-size: 16px;">Phone3: +91 9428826860</p>
      <p style="margin: 4px 0; font-size: 16px;">Address: 123 MindCare , Ahmedabad, Gujarat, India</p>
    </div>
    
    <!-- Social Media Column -->
    <div style="flex: 1; min-width: 220px; margin: 10px;">
      <h4 style="color: #c94b8c; font-size: 20px; margin-bottom: 10px;">Follow Us</h4>
      <p style="margin: 4px 0; font-size: 16px;"><a href="https://facebook.com" target="_blank" style="text-decoration: none; color: #5a5a5a;">Facebook</a></p>
      <p style="margin: 4px 0; font-size: 16px;"><a href="https://twitter.com" target="_blank" style="text-decoration: none; color: #5a5a5a;">Twitter</a></p>
      <p style="margin: 4px 0; font-size: 16px;"><a href="https://instagram.com" target="_blank" style="text-decoration: none; color: #5a5a5a;">Instagram</a></p>
    </div>
    
    <!-- Newsletter Signup Column -->
    <div style="flex: 1; min-width: 250px; margin: 10px;">
  <h4 style="color: #c94b8c; font-size: 20px; margin-bottom: 10px;">Newsletter</h4>
  <p style="margin: 0 0 10px 0; font-size: 16px;">Subscribe for updates and mental health tips:</p>
  <form action="subscribe.php" method="POST" style="display: flex; flex-direction: column; align-items: center; margin: 20px 0; max-width: 500px; width: 100%;">
    <input type="email" name="email" placeholder="Enter your email" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; margin-bottom: 10px;">
    <button type="submit" style="width: 100%; padding: 10px 16px; border: none; background-color: #ff99c8; color: #fff; border-radius: 4px; cursor: pointer; font-size: 16px;">Subscribe</button>
  </form>
</div>

    </div>
  </div>
  
  <!-- Footer Bottom Section -->
  <div style="max-width: 1200px; margin: auto; border-top: 1px solid #ddd; padding-top: 20px; text-align: center; font-size: 16px; margin-top: 40px;">
    <p style="margin: 0;">&copy; 2025 MindCare Project. All rights reserved.</p>
    <p style="margin: 5px 0 0 0;">Designed with care in Gujarat, India</p>
    <a href="#top" style="display: inline-block; margin-top: 10px; text-decoration: none; color: #c94b8c; font-weight: bold;">Back to Top &uarr;</a>
  </div>
</footer>

<script>
  let currentIndex = 0;
  const items = document.querySelectorAll('.carousel-item');
  const totalItems = items.length;

  document.addEventListener("DOMContentLoaded", function () {
      const carousel = document.querySelector(".carousel-items");
      const prevButton = document.querySelector(".prev");
      const nextButton = document.querySelector(".next");
      let index = 0; // To track the current slide

      const totalItems = document.querySelectorAll(".carousel-item").length; // Get total slides
      const itemWidth = document.querySelector(".carousel-item").offsetWidth; // Get width of a slide

      // Show next item in carousel
      nextButton.addEventListener("click", function () {
          index = (index + 1) % totalItems; // Loop back to 0 after the last item
          carousel.style.transform = `translateX(-${index * itemWidth}px)`;
      });

      // Show previous item in carousel
      prevButton.addEventListener("click", function () {
          index = (index - 1 + totalItems) % totalItems; // Loop back to the last item if at the first item
          carousel.style.transform = `translateX(-${index * itemWidth}px)`;
      });
  });

  // Show next item in carousel
  function showNext() {
      currentIndex = (currentIndex + 1) % totalItems; // Loop back to first item after last one
      updateCarousel();
  }

  // Show previous item in carousel
  function showPrev() {
      currentIndex = (currentIndex - 1 + totalItems) % totalItems; // Loop back to last item if at the first one
      updateCarousel();
  }

  // Update the carousel items based on current index
  function updateCarousel() {
      const carouselItems = document.querySelector('.carousel-items');
      carouselItems.style.transform = 'translateX(' + (-currentIndex * 100) + '%)';
  }


 
document.addEventListener("DOMContentLoaded", function() {
  var aboutImage = document.getElementById("about-image");
  if ('IntersectionObserver' in window) {
    var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if(entry.isIntersecting) {
          // Reset the animation to trigger it again
          aboutImage.style.animation = "none";
          // Force reflow (this makes sure the animation restarts)
          void aboutImage.offsetWidth;
          // Apply the desired animation
          aboutImage.style.animation = "slideInFromRight 1s forwards";
        } else {
          // Optionally, you could clear the animation property when not visible.
          // aboutImage.style.animation = "none";
        }
      });
    }, { threshold: 0.5 }); // Adjust threshold as needed
    observer.observe(aboutImage);
  } else {
    // Fallback: trigger animation immediately
    aboutImage.style.animation = "slideInFromRight 1s forwards";
  }
});
document.addEventListener("DOMContentLoaded", function() {
      var services = document.querySelectorAll(".service");
      var observerOptions = { threshold: 0.1 };
      
      var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if(entry.isIntersecting) {
            entry.target.style.animation = "fadeInUp 0.3s forwards";
          } else {
            entry.target.style.animation = "";
          }
        });
      }, observerOptions);
      
      services.forEach(function(service) {
        observer.observe(service);
      });
    });
</script>
<!-- Add JavaScript -->

<script src="assets/js/script.js"></script>
<!-- Footer -->
<footer>
    <p>&copy; 2025 MindCare. All rights reserved.</p>
</footer>
 
</body>

</html>
