<?php
// process.php
include 'includes/db_connect.php';

// Retrieve form data (adjust field names as needed)
$age = $_POST['age'];
$gender = $_POST['gender'];
$self_employed = $_POST['self_employed'];
$family_history = $_POST['family_history'];
$work_interfere = $_POST['work_interfere'];
$no_employees = $_POST['no_employees'];
$remote_work = $_POST['remote_work'];
$tech_company = $_POST['tech_company'];
$benefits = $_POST['benefits'];
$care_options = $_POST['care_options'];
$wellness_program = $_POST['wellness_program'];
$seek_help = $_POST['seek_help'];
$anonymity = $_POST['anonymity'];
$leave_policy = $_POST['leave_policy'];
$mental_health_consequence = $_POST['mental_health_consequence'];
$phys_health_consequence = $_POST['phys_health_consequence'];
$coworkers = $_POST['coworkers'];
$supervisor = $_POST['supervisor'];
$mental_health_interview = $_POST['mental_health_interview'];
$phys_health_interview = $_POST['phys_health_interview'];
$mental_vs_physical = $_POST['mental_vs_physical'];
$obs_consequence = $_POST['obs_consequence'];

// Insert data into the responses table
$sql = "INSERT INTO responses (age, gender, self_employed, family_history, work_interfere, no_employees, remote_work, tech_company, benefits, care_options, wellness_program, seek_help, anonymity, leave_policy, mental_health_consequence, phys_health_consequence, coworkers, supervisor, mental_health_interview, phys_health_interview, mental_vs_physical, obs_consequence) 
VALUES ('$age', '$gender', '$self_employed', '$family_history', '$work_interfere', '$no_employees', '$remote_work', '$tech_company', '$benefits', '$care_options', '$wellness_program', '$seek_help', '$anonymity', '$leave_policy', '$mental_health_consequence', '$phys_health_consequence', '$coworkers', '$supervisor', '$mental_health_interview', '$phys_health_interview', '$mental_vs_physical', '$obs_consequence')";

if ($conn->query($sql) === TRUE) {
    // Redirect to result page
    header("Location: result.html");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>