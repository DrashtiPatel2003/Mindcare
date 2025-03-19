<?php
session_start();
include 'includes/db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mental Health Questionnaire</title>
  <style>
    /* Global Styles */
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #ffdee9, #fff0f5);
      color: #333;
      margin: 0;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    /* Main Container */
    .container {
      width: 90%;
      max-width: 900px;
      background: white;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      overflow-y: auto;
      height: 90vh; /* Full-screen form */
    }
    /* Sections for each question */
    .question-section {
      background: #fff5f8;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      transition: box-shadow 0.3s ease-in-out;
    }
    /* Hover effect */
    .question-section:hover {
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
    }
    /* Labels */
    label {
      font-size: 16px;
      font-weight: bold;
      display: block;
      margin-bottom: 10px;
      color: #d63384;
    }
    /* Input fields & Selects */
    input, select {
      width: 100%;
      padding: 12px;
      border: 2px solid #d63384;
      border-radius: 8px;
      font-size: 16px;
      transition: border 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    /* Input focus effect */
    input:focus, select:focus {
      outline: none;
      border-color: #ff66b2;
      box-shadow: 0 0 10px rgba(228, 112, 134, 0.3);
    }
    /* Button Styles */
    .btn {
      background: linear-gradient(to right, #ff66b2, #ff85a2);
      color: white;
      padding: 14px;
      font-size: 18px;
      border-radius: 10px;
      width: 100%;
      box-shadow: 0 5px 10px rgba(214, 51, 132, 0.3);
      border: none;
      cursor: pointer;
    }
    .btn:hover {
      background: linear-gradient(to right, #e63988, #ff77c0);
    }
  </style>
</head>
<body>

<div class="container">
  <h1 style="text-align: center; color: #d63384;">Mental Health Questionnaire</h1>
  <form action="submit_questionnaire.php" method="POST">

    <!-- Age -->
    <div class="question-section">
      <label for="age">Age:</label>
      <input type="number" name="age" required>
    </div>

    <!-- Gender -->
    <div class="question-section">
      <label>Gender:</label>
      <select name="gender">
        <option value="0">Female</option>
        <option value="1">Male</option>
        <option value="2">Others</option>
      </select>
    </div>

    <!-- Self Employed -->
    <div class="question-section">
      <label>Are you self-employed?</label>
      <select name="self_employed">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>

    <!-- Family History -->
    <div class="question-section">
      <label>Do you have a family history of mental illness?</label>
      <select name="family_history">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>



    <!-- Work Interfere -->
    <div class="question-section">
      <label>Does work interfere with your mental health?</label>
      <select name="work_interfere">
        <option value="0">Don't know</option>
        <option value="1">Never</option>
        <option value="2">Often</option>
        <option value="3">Rarely</option>
        <option value="4">Sometimes</option>
      </select>
    </div>

    <!-- Company Size -->
    <div class="question-section">
      <label>Company Size:</label>
      <select name="no_employees">
        <option value="0">1-5</option>
        <option value="1">100-500</option>
        <option value="2">26-100</option>
        <option value="3">500-1000</option>
        <option value="4">6-25</option>
        <option value="5">More than 1000</option>
      </select>
    </div>

    <!-- Remote Work -->
    <div class="question-section">
      <label>Do you work remotely?</label>
      <select name="remote_work">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>

    <!-- Tech Company -->
    <div class="question-section">
      <label>Do you work in a tech company?</label>
      <select name="tech_company">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>

    <!-- Benefits -->
    <div class="question-section">
      <label>Does your workplace offer mental health benefits?</label>
      <select name="benefits">
        <option value="0">Don't know</option>
        <option value="1">No</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Care Options -->
    <div class="question-section">
      <label>Does your employer provide mental health care options?</label>
      <select name="care_options">
        <option value="0">No</option>
        <option value="1">Not sure</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Wellness Program -->
    <div class="question-section">
      <label>Is there a wellness program at your workplace?</label>
      <select name="wellness_program">
        <option value="0">Don't know</option>
        <option value="1">No</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Seek Help -->
    <div class="question-section">
      <label>Is there encouragement to seek mental health help?</label>
      <select name="seek_help">
        <option value="0">Don't know</option>
        <option value="1">No</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Anonymity -->
    <div class="question-section">
      <label>Is anonymity protected when seeking help?</label>
      <select name="anonymity">
        <option value="0">Don't know</option>
        <option value="1">No</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Leave -->
    <div class="question-section">
      <label>How easy is it to take mental health leave?</label>
      <select name="leave_policy">
        <option value="0">Don't know</option>
        <option value="1">Somewhat difficult</option>
        <option value="2">Somewhat easy</option>
        <option value="3">Very difficult</option>
        <option value="4">Very easy</option>
      </select>
    </div>

    <!-- Mental Health Consequence -->
    <div class="question-section">
      <label>Would discussing mental health negatively impact your job?</label>
      <select name="mental_health_consequence">
        <option value="0">Maybe</option>
        <option value="1">No</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Physical Health Consequence -->
    <div class="question-section">
      <label>Would discussing physical health impact your job?</label>
      <select name="phys_health_consequence">
        <option value="0">Maybe</option>
        <option value="1">No</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Coworkers -->
    <div class="question-section">
      <label>Would you discuss a mental health issue with coworkers?</label>
      <select name="coworkers">
        <option value="0">No</option>
        <option value="1">Some of them</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Supervisor -->
    <div class="question-section">
      <label>Would you discuss a mental health issue with your supervisor?</label>
      <select name="supervisor">
        <option value="0">No</option>
        <option value="1">Some of them</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Mental Health Interview -->
    <div class="question-section">
      <label>Would you mention mental health in an interview?</label>
      <select name="mental_health_interview">
        <option value="0">Maybe</option>
        <option value="1">No</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Physical Health Interview -->
    <div class="question-section">
      <label>Would you mention physical health in an interview?</label>
      <select name="phys_health_interview">
        <option value="0">Maybe</option>
        <option value="1">No</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Mental vs Physical -->
    <div class="question-section">
      <label>Do you think mental health is as important as physical health?</label>
      <select name="mental_vs_physical">
        <option value="0">Don't know</option>
        <option value="1">No</option>
        <option value="2">Yes</option>
      </select>
    </div>

    <!-- Observed Consequence -->
    <div class="question-section">
      <label>Have you ever faced consequences for discussing mental health?</label>
      <select name="obs_consequence">
        <option value="0">No</option>
        <option value="1">Yes</option>
      </select>
    </div>

    <button type="submit" class="btn">Submit</button>
  </form>
</div>

</body>
</html>
