<?php
session_start();
include 'includes/db_connect.php';
$is_logged_in = isset($_SESSION['user_id']);
// Validate and fetch therapist details
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid therapist ID. Received: " . print_r($_GET, true));
}
$therapist_id = intval($_GET['id']);

$sql = "SELECT * FROM therapists WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $therapist_id);
$stmt->execute();
$result = $stmt->get_result();
$therapist = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$therapist) {
    die("Therapist not found for ID " . $therapist_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointment | <?php echo htmlspecialchars($therapist['name']); ?></title>
  <style>
    /* Basic Styles */
    body {
      margin: 0;
      padding: 0;
      font-family: "Arial", sans-serif;
      background-color: #ffeef2;
      color: #333;
    }
    .main-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px 20px 40px;
    }
    /* Therapist Card */
    .therapist-card {
      background-color: #fff;
      border-radius: 12px;
      margin-bottom: 30px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 20px;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
    }
    .therapist-image {
      flex: 0 0 200px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .therapist-image img {
      width: 180px;
      height: 180px;
      object-fit: cover;
      border-radius: 50%;
      border: 4px solid #ffcdd2;
    }
    .therapist-info {
      flex: 1;
      padding: 0 20px;
    }
    .therapist-info h2 {
      color: #f06292;
      margin: 0;
      font-size: 1.8rem;
    }
    .therapist-info p {
      margin: 8px 0;
      line-height: 1.5;
    }
    /* Date Carousel & Dropdowns */
    .date-carousel {
      margin-top: 30px;
      text-align: center;
    }

    .carousel-controls button {
      background-color: #f48fb1;
      border: none;
      color: #fff;
      padding: 8px 16px;
      margin: 0 5px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
      transition: background 0.3s ease;
      width: 120px;
    }
    .carousel-controls button:hover {
      background-color: #ec407a;
    }
    .year-select,
    .month-select {
      padding: 8px 12px;
      margin: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
      background-color: #ffeef2;
      font-size: 1rem;
      color: #333;
    }
    .date-list {
      display: flex;
      justify-content: center;
      gap: 10px;
      flex-wrap: wrap;
    }
    .date-item {
      background-color: #ffcdd2;
      color: #333;
      padding: 10px;
      border-radius: 8px;
      min-width: 120px;
      cursor: pointer;
      transition: 0.3s ease;
      font-weight: 500;
      text-align: center;
    }
    .date-item:hover {
      background-color: #f06292;
      color: #fff;
    }
    .date-item.selected {
      background-color: #ec407a;
      color: #fff;
    }
    .date-item.disabled {
      opacity: 0.5;
      cursor: default;
      pointer-events: none;
    }
    .day-label {
      font-weight: bold;
    }
    .slot-count {
      font-size: 0.9em;
      color: #555;
      margin-top: 2px;
    }
    /* Slots Container */
    .slots-container {
      margin-top: 20px;
      background-color: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      display: none;
    }
    .slots-header {
      font-size: 1.2rem;
      color: #f06292;
      margin-bottom: 15px;
      text-align: center;
    }
    .slot-sections {
      display: flex;
      justify-content: space-between;
      gap: 20px;
      flex-wrap: wrap;
    }
    .slot-column {
      flex: 1 1 200px;
    }
    .slot-column h4 {
      margin: 0 0 10px 0;
      color: #333;
      font-size: 1.1rem;
      border-bottom: 2px solid #f48fb1;
      display: inline-block;
      padding-bottom: 3px;
    }
    .slot-item {
      background-color: #ffcdd2;
      padding: 8px;
      margin: 8px 0;
      border-radius: 6px;
      text-align: center;
      cursor: pointer;
      transition: 0.3s;
      font-weight: 500;
    }
    .slot-item:hover {
      background-color: #f06292;
      color: #fff;
    }
    .slot-item.selected {
      background-color: #ec407a !important;
      color: #fff;
    }
    /* Booking Form */
    .booking-form {
      background-color: #fff;
      margin-top: 30px;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .booking-form h3 {
      margin-top: 0;
      color: #f06292;
      font-size: 1.4rem;
    }
    .booking-form label {
      display: block;
      margin: 10px 0 5px;
      font-weight: 500;
    }
    .booking-form input,
    .booking-form select,
    .booking-form textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      margin-bottom: 10px;
      font-size: 1rem;
    }
    .booking-form button {
      background-color: #f48fb1;
      border: none;
      color: #fff;
      padding: 12px 20px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 1rem;
      transition: background-color 0.3s ease;
    }
    .booking-form button:hover {
      background-color: #ec407a;
    }
    .selected-slot-display {
      margin: 10px 0;
      font-weight: bold;
      color: #f48fb1;
    }
    /* Calendar Modal Styles */
    #calendarModal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      z-index: 1000;
      width: 90%;
      max-width: 600px;
    }
    #calendarModal h2 {
      text-align: center;
      margin-top: 0;
    }
    #calendarModal .calendar-grid {
      display: grid;
      grid-template-columns: repeat(7, 1fr);
      gap: 5px;
      margin-top: 10px;
    }
    #calendarModal .calendar-cell {
      border: 1px solid #ddd;
      padding: 5px;
      text-align: center;
      min-height: 60px;
      position: relative;
      cursor: pointer;
      border-radius: 4px;
    }
    #calendarModal .calendar-cell.disabled {
      opacity: 0.5;
      cursor: default;
      pointer-events: none;
    }
    #calendarModal .calendar-cell .date-number {
      font-weight: bold;
    }
    #calendarModal .calendar-cell .slot-count {
      position: absolute;
      bottom: 2px;
      right: 2px;
      font-size: 0.8rem;
      font-weight: bold;
    }
    /* Color coding for available slots */
    .available-green {
      background-color: #c8e6c9;
    }
    .available-orange {
      background-color: #ffe0b2;
    }
    .available-red {
      background-color: #ffcdd2;
    }
    .no-slots {
      background-color: #f0f0f0;
    }
    /* Calendar backdrop */
    #calendarBackdrop {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.4);
      z-index: 900;
    }
    /* Calendar Icon button */
    .carousel-controls {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}

#calendarIcon {
  margin-left: auto; /* This pushes it to the extreme right */
  font-size: 28px;
  border: none;
  background: transparent;
  cursor: pointer;
  color: #f48fb1;
  transition: transform 0.2s ease, color 0.2s ease;
  padding: 5px;
}

#calendarIcon:hover {
  transform: scale(1.1);
  color: #ec407a;
}
.calendar-nav {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 10px;
  gap: 10px;
}

.calendar-nav button {
  background-color: #f48fb1;
  border: none;
  color: #fff;
  padding: 6px 10px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1rem;
  transition: background 0.3s ease;
}

.calendar-nav button:hover {
  background-color: #ec407a;
}

#current-month-year {
  font-size: 1.1rem;
  font-weight: bold;
  color: #333;
}


  </style>
</head>
<body>

<div class="main-container">
  <!-- Therapist Card -->
  <div class="therapist-card">
    <div class="therapist-image">
      <img src="<?php echo htmlspecialchars($therapist['image']); ?>" alt="Therapist">
    </div>
    <div class="therapist-info">
      <h2><?php echo htmlspecialchars($therapist['name']); ?></h2>
      <p><strong>Specialization:</strong> <?php echo htmlspecialchars($therapist['specialization']); ?></p>
      <p><strong>Experience:</strong> <?php echo htmlspecialchars($therapist['experience']); ?> years</p>
      <p><strong>Contact:</strong> <?php echo htmlspecialchars($therapist['contact']); ?></p>
      <p><strong>Price per session:</strong> ₹<?php echo htmlspecialchars($therapist['price']); ?></p>
      <p><strong>Session Type:</strong> <?php echo htmlspecialchars($therapist['session_type']); ?></p>
      <p><strong>Bio:</strong> <?php echo nl2br(htmlspecialchars($therapist['bio'])); ?></p>
    </div>
  </div>

  <!-- Date Carousel -->
  <div class="date-carousel">
    <div class="carousel-controls">
      <button id="prev-week">&laquo; Previous</button>
      <button id="next-week">Next &raquo;</button>
      <!-- Calendar Icon Button -->
<button id="calendarIcon">📅</button>

<!-- Calendar Backdrop & Modal -->
<div id="calendarBackdrop"></div>
<div id="calendarModal">
  <h2>Available Slots Calendar</h2>
  <!-- Month Navigation Bar -->
  <div class="calendar-nav">
    <button id="prev-month">«</button>
    <span id="current-month-year"></span>
    <button id="next-month">»</button>
  </div>
  <div class="calendar-grid" id="calendarGrid">
    <!-- Calendar cells will be dynamically generated here -->
  </div>
  <br>
  <button onclick="closeCalendar()">Close</button>
</div>
    </div>
    <div id="date-list" class="date-list"></div>
  </div>

  <!-- Slots Container -->
  <div id="slots-container" class="slots-container">
    <div class="slots-header">Available Slots on <span id="selected-date-text"></span></div>
    <div class="slot-sections">
      <div class="slot-column">
        <h4>Morning</h4>
        <div id="morning-slots"></div>
      </div>
      <div class="slot-column">
        <h4>Noon</h4>
        <div id="noon-slots"></div>
      </div>
    </div>
  </div>

  <!-- Booking Form -->
  <div class="booking-form">
    <h3>Book an Appointment</h3>
    <form action="book_appointment.php" method="POST">
      <input type="hidden" name="therapist_id" value="<?php echo $therapist['id']; ?>">
      <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
      <input type="hidden" name="date" id="selected-date" value="">
      <input type="hidden" name="slot_id" id="selected-slot-id" value="">
      <input type="hidden" name="time_slot" id="selected-slot" value="">
      
      <div class="selected-slot-display" id="selected-slot-display">
        No time slot selected.
      </div>

      <label for="user_name">Your Name</label>
      <input type="text" name="user_name" id="user_name" required>

      <label for="phone_number">Your Phone Number</label>
      <input type="tel" name="user_phone" id="phone_number" pattern="[0-9]{10}" placeholder="Enter 10-digit phone number" required>

      <label for="user_email">Your Email</label>
      <input type="email" name="user_email" id="user_email" required>

      <label for="session_type">Session Type</label>
      <select name="session_type" id="session_type">
        <option value="Online">Online</option>
        <option value="Offline">Offline</option>
      </select>

      <label for="primary_concern">Primary Concern</label>
      <textarea name="primary_concern" id="primary_concern" rows="4" placeholder="Please describe your primary concern..."></textarea>

      <label for="referral">How did you hear about us?</label>
      <input type="text" name="referral" id="referral" placeholder="E.g., Friend, Social Media, etc.">

      <button type="submit" class="book-btn">Book Appointment</button>
    </form>
  </div>
</div>

<script>
// --- Shared Variables and Initialization ---
// Set current date to midnight
let currentDate = new Date();
currentDate.setHours(0, 0, 0, 0);
// Global therapistId (injected from PHP)
const therapistId = <?php echo (int)$therapist_id; ?>;
// Get necessary DOM elements
const dateList = document.getElementById('date-list');
const prevBtn = document.getElementById('prev-week');
const nextBtn = document.getElementById('next-week');

// Create Year & Month selectors with custom classes
const yearSelect = document.createElement('select');
yearSelect.className = "year-select";
const monthSelect = document.createElement('select');
monthSelect.className = "month-select";
// Attach onchange events
yearSelect.onchange = updateDates;
monthSelect.onchange = updateDates;
// Insert selectors into the DOM (before the date list)
const carousel = document.querySelector('.date-carousel');
carousel.insertBefore(yearSelect, dateList);
carousel.insertBefore(monthSelect, dateList);
// Initialize filters and load the dates for the current month
initializeFilters();
updateDates();

// Global variables for the calendar modal
let currentCalendarDate = new Date(); // This will track the currently displayed month

// Get calendar elements
const calendarIcon = document.getElementById('calendarIcon');
const calendarModal = document.getElementById('calendarModal');
const calendarBackdrop = document.getElementById('calendarBackdrop');
const calendarGrid = document.getElementById('calendarGrid');
const currentMonthYearDisplay = document.getElementById('current-month-year');

// Event listeners for calendar icon and navigation buttons
calendarIcon.addEventListener('click', openCalendar);
document.getElementById('prev-month').addEventListener('click', () => {
  currentCalendarDate.setMonth(currentCalendarDate.getMonth() - 1);
  loadCalendar(currentCalendarDate);
});
document.getElementById('next-month').addEventListener('click', () => {
  currentCalendarDate.setMonth(currentCalendarDate.getMonth() + 1);
  loadCalendar(currentCalendarDate);
});

function openCalendar() {
  // Set currentCalendarDate to now when opening (or leave previous state)
  currentCalendarDate = new Date();
  calendarModal.style.display = 'block';
  calendarBackdrop.style.display = 'block';
  loadCalendar(currentCalendarDate);
}

function closeCalendar() {
  calendarModal.style.display = 'none';
  calendarBackdrop.style.display = 'none';
}

function loadCalendar(dateObj) {
  calendarGrid.innerHTML = '';

  // Update the header display with current month and year
  currentMonthYearDisplay.textContent = dateObj.toLocaleString('default', { month: 'long', year: 'numeric' });

  const year = dateObj.getFullYear();
  const month = dateObj.getMonth();
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const daysInMonth = lastDay.getDate();
  const startDayIndex = firstDay.getDay(); // 0 = Sunday, 1 = Monday, etc.

  // Create blank cells before the first day of the month
  for (let i = 0; i < startDayIndex; i++) {
    const emptyCell = document.createElement('div');
    emptyCell.classList.add('calendar-cell', 'disabled');
    calendarGrid.appendChild(emptyCell);
  }

  // Create a cell for each day
  for (let day = 1; day <= daysInMonth; day++) {
    const cell = document.createElement('div');
    cell.classList.add('calendar-cell');

    // Format date as yyyy-mm-dd for API call
    const yyyy = year;
    const mm = String(month + 1).padStart(2, '0');
    const dd = String(day).padStart(2, '0');
    const formattedDate = `${yyyy}-${mm}-${dd}`;

    // Display day number
    cell.innerHTML = `<div class="date-number">${day}</div>`;

    // Fetch available slot count via AJAX
    fetch(`fetch_slot_counts.php?date=${formattedDate}&therapist_id=${therapistId}`)
      .then(response => response.json())
      .then(data => {
        const count = data.available_slots || 0;
        const countDiv = document.createElement('div');
        countDiv.classList.add('slot-count');
        countDiv.textContent = count + " slots";

        // Apply color coding based on availability:
        // Green: 4+ slots, Orange: 2-3 slots, Red: 1 slot, Grey: 0 slots
        if (count >= 4) {
          cell.classList.add('available-green');
        } else if (count >= 2) {
          cell.classList.add('available-orange');
        } else if (count === 1) {
          cell.classList.add('available-red');
        } else {
          cell.classList.add('no-slots', 'disabled');
        }
        cell.appendChild(countDiv);
      })
      .catch(error => console.error('Error fetching slot count:', error));

    // Make the cell clickable if not disabled
    cell.onclick = () => {
      if (!cell.classList.contains('disabled')) {
        // Instead of redirecting, call selectDate to update the slots-container inline
        selectDate(formattedDate, cell);
      }
    };

    calendarGrid.appendChild(cell);
  }
}

function selectDate(formattedDate, element) {
  document.querySelectorAll('.date-item').forEach(item => item.classList.remove('selected'));
  element.classList.add('selected');
  const slotsContainer = document.getElementById('slots-container');
  slotsContainer.style.display = 'block';
  document.getElementById('selected-date-text').textContent = formattedDate;
  document.getElementById('selected-date').value = formattedDate;
  fetchSlots(formattedDate);
}

// --- Date Carousel Functions ---
function initializeFilters() {
  const currentYear = new Date().getFullYear();
  for (let i = currentYear; i <= currentYear + 2; i++) {
    const option = document.createElement('option');
    option.value = i;
    option.textContent = i;
    yearSelect.appendChild(option);
  }
  const months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];
  months.forEach((month, index) => {
    const option = document.createElement('option');
    option.value = index;
    option.textContent = month;
    monthSelect.appendChild(option);
  });
  yearSelect.value = new Date().getFullYear();
  monthSelect.value = currentDate.getMonth();
}

function updateDates() {
  const selectedYear = parseInt(yearSelect.value);
  const selectedMonth = parseInt(monthSelect.value);
  const startDate = new Date(selectedYear, selectedMonth, 1);
  const endDate = new Date(selectedYear, selectedMonth + 1, 0);
  dateList.innerHTML = '';
  const today = new Date();
  today.setHours(0, 0, 0, 0);
  for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
    if (d >= today) {
      let dd = String(d.getDate()).padStart(2, '0');
      let mm = String(d.getMonth() + 1).padStart(2, '0');
      let yyyy = d.getFullYear();
      let formattedLocal = `${yyyy}-${mm}-${dd}`;
      let displayDate = `${dd}-${mm}-${yyyy}`;
      let dayName = d.toLocaleString('default', { weekday: 'long' });
      let div = document.createElement('div');
      div.classList.add('date-item');
      div.innerHTML = `<div class="day-label">${dayName}</div>
                       <div class="date-label">${displayDate}</div>
                       <div class="slot-count"></div>`;
      if (d.getDay() === 0) {
        div.classList.add('disabled');
        updateSlotCount(formattedLocal, div);
      } else {
        div.onclick = () => selectDate(formattedLocal, div);
        updateSlotCount(formattedLocal, div);
      }
      dateList.appendChild(div);
    }
  }
}

function updateSlotCount(formattedDate, dateDiv) {
  const url = `fetch_slot_counts.php?date=${formattedDate}&therapist_id=${therapistId}`;
  fetch(url)
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        console.error('Error from API:', data.error);
        return;
      }
      const count = data.available_slots || 0;
      const slotCountElem = dateDiv.querySelector('.slot-count');
      if (slotCountElem) {
        slotCountElem.textContent = `(${count} slots available)`;
      } else {
        console.error('Slot count element not found in the dateDiv.');
      }
    })
    .catch(error => console.error('Error fetching slot count:', error));
}

function fetchSlots(formattedDate) {
  const morningSlotsDiv = document.getElementById('morning-slots');
  const noonSlotsDiv = document.getElementById('noon-slots');
  morningSlotsDiv.innerHTML = '';
  noonSlotsDiv.innerHTML = '';
  const url = `fetch_slots.php?date=${formattedDate}&therapist_id=${therapistId}`;
  fetch(url)
    .then(response => response.json())
    .then(data => {
      if (!data || data.length === 0) {
        morningSlotsDiv.innerHTML = '<p>No slots available.</p>';
        noonSlotsDiv.innerHTML = '';
        return;
      }
      const morningSlots = data.filter(slot => {
        let hour = parseInt(slot.raw_time.split(':')[0]);
        return hour < 12;
      });
      morningSlotsDiv.innerHTML = morningSlots.length > 0 ?
        morningSlots.map(slot => `<div class="slot-item" onclick="selectSlot('${slot.id}', '${slot.slot_datetime}', this)">${slot.slot_datetime}</div>`).join('') :
        '<p>No morning slots.</p>';
      const noonSlots = data.filter(slot => {
        let hour = parseInt(slot.raw_time.split(':')[0]);
        return hour >= 12;
      });
      noonSlotsDiv.innerHTML = noonSlots.length > 0 ?
        noonSlots.map(slot => `<div class="slot-item" onclick="selectSlot('${slot.id}', '${slot.slot_datetime}', this)">${slot.slot_datetime}</div>`).join('') :
        '<p>No noon slots.</p>';
    })
    .catch(error => console.error('Error fetching slots:', error));
}
function selectSlot(slotId, slotTime, element) {
  // Remove 'selected' class from all slot items
  document.querySelectorAll('.slot-item').forEach(item => item.classList.remove('selected'));
  // Mark the clicked slot as selected
  element.classList.add('selected');
  
  // Set hidden form values and update display text
  document.getElementById('selected-slot').value = slotTime;
  document.getElementById('selected-slot-id').value = slotId;
  document.getElementById('selected-slot-display').textContent = `Selected Time Slot: ${slotTime}`;
  
  // Check if closeCalendar exists before calling it
  if (typeof closeCalendar === 'function') {
    closeCalendar();
  } else {
    console.error('closeCalendar function is not defined.');
    // Fallback: manually hide calendar modal and backdrop if needed
    const calendarModal = document.getElementById('calendarModal');
    const calendarBackdrop = document.getElementById('calendarBackdrop');
    if (calendarModal) calendarModal.style.display = 'none';
    if (calendarBackdrop) calendarBackdrop.style.display = 'none';
  }
}

prevBtn.onclick = () => { 
  let currentMonth = parseInt(monthSelect.value);
  if (currentMonth === 0) {
    monthSelect.value = 11;
    yearSelect.value = parseInt(yearSelect.value) - 1;
  } else {
    monthSelect.value = currentMonth - 1;
  }
  updateDates();
};

nextBtn.onclick = () => { 
  let currentMonth = parseInt(monthSelect.value);
  if (currentMonth === 11) {
    monthSelect.value = 0;
    yearSelect.value = parseInt(yearSelect.value) + 1;
  } else {
    monthSelect.value = currentMonth + 1;
  }
  updateDates();
};



</script>

</body>
</html>
