<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://d3js.org/d3.v6.min.js"></script>
</head>
<body>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Set a consistent background across the whole webpage */
body {
    background: #fff0f5; /* Pastel Pink */
    font-family: 'Arial', sans-serif;
    display: flex;
    flex-direction: column;
    
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


         /* Mood Button Styles */
.mood-btn {
    width: 140px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px;
    border-radius: 12px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    color: #d63384;
    transition: transform 0.3s ease-in-out;
    user-select: none;
    text-align: center;
    border: 2px solid #d63384;
}

    .mood-btn:hover {
        transform: scale(1.1);
    }
    input[type="radio"]:checked + label {
    background: #ff99cc; /* Highlight selected mood */
    color: white;
    transform: scale(1.1);
    border: 2px solid #ff66b2;
    }

    /* Navigation Header */
    .calendar-header {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 15px;
      margin-bottom: 20px;
    }
    .month-name {
      font-size: 20px;
      font-weight: bold;
      color: #d63384;
    }
    .year-selector {
      font-size: 16px;
      padding: 6px;
      border: 2px solid #d63384;
      border-radius: 8px;
      color: #d63384;
      font-weight: bold;
      background: white;
      cursor: pointer;
      transition: 0.3s ease;
    }
    .year-selector:hover {
      background: #ffe6f0;
    }
    .nav-button {
      background: linear-gradient(45deg, #ff66b2, #ff85a2);
      color: white;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 16px;
      border-radius: 8px;
      transition: 0.3s ease;
      box-shadow: 0 3px 8px rgba(0,0,0,0.2);
    }
    .nav-button:hover {
      background: linear-gradient(45deg, #e63988, #ff77c0);
    }
/* Calendar Grid */
.calendar-container {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 8px;
  width: 90%; 
  max-width: 900px;
  margin: 20px auto;
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

/* Day Cells (Fixed Size & Structured) */
.day-cell {
  width: 90px;
  height: 90px;
  background: #f5f5f5;
  border-radius: 8px;
  position: relative;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  transition: transform 0.2s ease-in-out, background 0.3s ease;
}

/* Single Mood: Full Background */
.day-cell.single-mood {
  display: flex;
  align-items: center;
  justify-content: center;
}

/* Multi Mood Grid */
.mood-box-container {
  width: 100%;
  height: 100%;
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: 1fr 1fr;
  position: absolute;
  top: 0;
  left: 0;
}

/* Mood Colors */
.happy { background: #FFD700; }   /* Yellow */
.sad { background: #4682B4; }      /* Blue */
.neutral { background: #A9A9A9; }  /* Gray */
.stressed { background: #FF4500; } /* Red */

/* Day Number (Top Left) */
.day-number {
  position: absolute;
  top: 5px;
  left: 5px;
  font-size: 14px;
  font-weight: bold;
  color: #333;
  z-index: 2;
}

/* Tooltip for Mood Details */
.day-cell:hover::after {
  content: attr(data-tooltip);
  position: absolute;
  bottom: 110%;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(0, 0, 0, 0.75);
  color: white;
  font-size: 12px;
  padding: 5px;
  border-radius: 4px;
  white-space: nowrap;
}

/* Legend Styling */
.legend {
    max-width: 600px;
    margin: 20px auto;
    display: flex;
    justify-content: center;
    gap: 15px;
    background: white;
    padding: 12px 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    font-size: 16px;
    font-weight: bold;
    color: #555;
}

/* Individual Legend Items */
.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 8px;
    background: #f8f8f8;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease, background 0.3s ease;
}

/* Hover Effect */
.legend-item:hover {
    transform: scale(1.05);
    background: #ffebf0;
}

/* Colored Mood Indicators */
.legend-color {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    border: 1px solid rgba(0, 0, 0, 0.1);
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

<section class="hero-mood" style="display: flex; align-items: center; justify-content: center; gap: 50px; padding: 80px 10%; background: #fff0f5;">
    <div class="hero-content" style="flex: 1; max-width: 500px; opacity: 1; transform: translateY(0); transition: opacity 0.8s ease-out, transform 0.8s ease-out;">
        <h1 class="fade-in" style="font-size: 40px; font-weight: bold; color: #d63384;">Track Your Mood, <span style="color: #ff85a2;">Understand Yourself</span></h1>
        <p class="fade-in" style="font-size: 18px; color: #444; margin-top: 15px;">
            Log your emotions daily and visualize them in an interactive <b>calendar and graphs</b>. Gain insights into your emotional well-being through simple yet powerful tracking tools.
        </p>
        <a href="#mood-tracker" class="hero-btn fade-in" style="display: inline-block; margin-top: 20px; padding: 12px 20px; background: linear-gradient(45deg, #ff66b2, #ff85a2); color: white; border-radius: 10px; font-size: 18px; font-weight: bold; text-decoration: none; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); transition: transform 0.2s ease, background 0.3s ease;">
            Start Tracking
        </a>
    </div>
    <div class="hero-image" style="flex: 1; display: flex; justify-content: center; opacity: 1; transform: translateX(0); transition: opacity 1s ease-out, transform 1s ease-out;">
        <img src="assets/images/moodhero.png" alt="Mood Tracker Preview" class="slide-in" style="width: 100%; max-width: 500px; border-radius: 12px;">
    </div>
</section>
<section id="mood-tracker" style="width: 100%; padding: 40px; background: #fff0f5;; border-radius: 12px;">
    
  <section id="mood-tracker" style="width: 100%; padding:40px; background: #fff8f6; border-radius: 12px; box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.1); margin: 20px 0; position: relative; overflow: hidden; display: flex; justify-content: center;">
    <div id="mood-container" style="display: contain; width: 100%; max-width: 800px; justify-content: space-between; align-items: center; position: relative;">
  
        <!-- Mood Form -->
        <form action="save_mood.php" method="post" id="mood-form" style="flex: 1; padding: 20px; background: white; border-radius: 12px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); transition: transform 0.5s ease-in-out; position: relative;">
            <h2 style="color: #d63384; text-align: center;">How are you feeling today?</h2>
            <br>
  
            <div id="mood-options" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px;">
                <input type="radio" id="happy" name="mood" value="happy" style="display: none;">
                <label for="happy" class="mood-btn" style="background: #FFFACD;">😃 Happy</label>
  
                <input type="radio" id="neutral" name="mood" value="neutral" style="display: none;">
                <label for="neutral" class="mood-btn" style="background: #D3D3D3;">😐 Neutral</label>
  
                <input type="radio" id="sad" name="mood" value="sad" style="display: none;">
                <label for="sad" class="mood-btn" style="background: #ADD8E6;">😢 Sad</label>
  
                <input type="radio" id="stressed" name="mood" value="stressed" style="display: none;">
                <label for="stressed" class="mood-btn" style="background: #D8BFD8;">😫 Stressed</label>
            </div>
  
            <label for="mood-date" style="font-weight: bold; color: #d63384;">Date:</label>
            <input type="text" id="mood-date" name="mood_date" placeholder="Pick a date" readonly style="width: 100%; padding: 10px; border: 1px solid #ff99cc; border-radius: 8px; background-color: #fff; color: #d63384; text-align: center; font-size: 16px; margin-bottom: 20px; cursor: pointer;">
  
            <label for="note" style="font-weight: bold; color: #d63384;">Add a Note (optional):</label>
            <textarea id="note" name="note" style="width: 100%; padding: 10px; border: 1px solid #ff99cc; border-radius: 8px; background-color: #fff; color: #d63384; font-size: 16px;"></textarea>
  
            <button type="submit" style="width: 100%; padding: 15px; background: linear-gradient(45deg, #ff66b2, #ff99cc); color: white; border: none; border-radius: 10px; font-weight: bold; font-size: 18px; margin-top: 20px; cursor: pointer; transition: 0.3s;">
                🚀 Save Mood
            </button>
                <!-- View Graph Button -->
      <a href="user_dashboard.php" style="width: 100%; padding: 15px; background: linear-gradient(45deg, #66b3ff, #99ccff); color: white; border: none; border-radius: 10px; font-weight: bold; font-size: 18px; margin-top: 20px; text-align: center; display: block; text-decoration: none;">
        📊 View Graph
    </a>
        </form>
  
        <!-- Full-Screen Calendar (Hidden by Default) -->
        <div id="calendar-section" style="position: absolute; top: 0; right: -100%; width: 25%; height: 100%; background: white; border-left: 3px solid #ff99cc; box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1); transition: right 0.6s ease-in-out; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            <h3 style="color: #d63384;">📅 Select a Date</h3>
            <input type="date" id="calendar-input" style="width: 100%; padding: 10px; border: 2px solid #ff99cc; border-radius: 8px; background-color: #fff; color: #d63384; text-align: center; font-size: 16px;">
            <button id="close-calendar" style="margin-top: 15px; padding: 10px 20px; background: #ff66b2; color: white; border: none; border-radius: 6px; cursor: pointer;">Close</button>
        </div>
    </div>
  </section>
    <!-- Year Selector Dropdown -->
    <select id="year-selector" class="year-selector">
        <!-- Options will be populated by JavaScript -->
      </select>
      <div class="calendar-header">
        <button class="nav-button" id="prev-month">◀ Prev</button>
        <span class="month-name" id="current-month"></span>
        <button class="nav-button" id="next-month">Next ▶</button>
      </div>
</section>


 

  <!-- Calendar Grid -->
  <div id="mood-calendar" class="calendar-container"></div>

  <!-- Mood Color Legend -->
  <div class="legend">
    <div class="legend-item"><span class="legend-color" style="background: #FFD700;"></span> Happy</div>
    <div class="legend-item"><span class="legend-color" style="background: #4682B4;"></span> Sad</div>
    <div class="legend-item"><span class="legend-color" style="background: #A9A9A9;"></span> Neutral</div>
    <div class="legend-item"><span class="legend-color" style="background: #FF4500;"></span> Stressed</div>
</div>
  <script>
     document.getElementById("mood-date").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("calendar-section").style.right = "0"; // Slide in calendar
    document.getElementById("mood-form").style.transform = "translateX(-30%)"; // Slide form to extreme left
});

document.getElementById("close-calendar").addEventListener("click", function() {
    document.getElementById("calendar-section").style.right = "-100%"; // Hide calendar
    document.getElementById("mood-form").style.transform = "translateX(0)"; // Bring form back
});

document.getElementById("calendar-input").addEventListener("change", function() {
        document.getElementById("mood-date").value = this.value;
    });
    document.addEventListener("DOMContentLoaded", function () {
    // Mood color mapping (case-sensitive matching the database values)
    const moodColors = {
        "Happy": "#FFD700",   // Yellow
        "Sad": "#4682B4",     // Blue
        "Neutral": "#A9A9A9", // Gray
        "Stressed": "#FF4500" // Red
    };

    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth();

    const calendarContainer = document.getElementById("mood-calendar");
    const monthName = document.getElementById("current-month");
    const yearSelector = document.getElementById("year-selector");

    // Populate Year Selector with options from 2000 to 2050
    for (let year = 2000; year <= 2050; year++) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        yearSelector.appendChild(option);
    }
    yearSelector.value = currentYear;

    // Month names array
    const monthNames = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    function updateCalendar() {
        // Update the header text
        monthName.textContent = `${monthNames[currentMonth]} ${currentYear}`;
        calendarContainer.innerHTML = ""; // Clear previous grid

        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();

        for (let day = 1; day <= daysInMonth; day++) {
            const dateStr = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
            const dayCell = document.createElement("div");
            dayCell.className = "day-cell";

            // Add day number at the top left
            const dayNumber = document.createElement("span");
            dayNumber.className = "day-number";
            dayNumber.textContent = day;
            dayCell.appendChild(dayNumber);

            // Fetch mood data for this date from PHP
            fetch(`fetch_moods.php?date=${dateStr}`)
                .then(response => response.json())
                .then(moods => {
                    if (moods.length === 1) {
                        // If a single mood is logged, fill the cell with that mood's color.
                        dayCell.style.background = moodColors[moods[0]];
                        dayCell.classList.add("single-mood");
                    } else if (moods.length > 1) {
                        // For multiple moods, convert the cell to a 2x2 grid.
                        dayCell.style.background = "transparent";
                        dayCell.classList.add("multiple-moods");

                        const moodBoxContainer = document.createElement("div");
                        moodBoxContainer.className = "mood-box-container";

                        // Limit to 4 moods (if more, you might consider showing a plus sign)
                        moods.slice(0, 4).forEach(mood => {
                            const moodBox = document.createElement("div");
                            moodBox.className = "mood-box";
                            moodBox.style.background = moodColors[mood];
                            moodBoxContainer.appendChild(moodBox);
                        });

                        dayCell.appendChild(moodBoxContainer);
                    }
                })
                .catch(error => console.error("Error fetching moods for", dateStr, error));

            calendarContainer.appendChild(dayCell);
        }
    }

    // Month navigation event listeners
    document.getElementById("prev-month").addEventListener("click", function () {
        currentMonth = (currentMonth - 1 + 12) % 12;
        if (currentMonth === 11) currentYear--;
        updateCalendar();
    });

    document.getElementById("next-month").addEventListener("click", function () {
        currentMonth = (currentMonth + 1) % 12;
        if (currentMonth === 0) currentYear++;
        updateCalendar();
    });

    yearSelector.addEventListener("change", function () {
        currentYear = parseInt(this.value);
        updateCalendar();
    });

    updateCalendar(); // Render calendar initially
});
</script>

 
</body>

</html>
