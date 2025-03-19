<?php
// Database connection settings // include '../includes/db_connect.php';
$host = 'localhost'; // Database host (use the appropriate value for your server)
$username = 'root'; // Database username (use the correct username)
$password = ''; // Database password (use the correct password)
$dbname = 'mindcare'; // Database name (change this to your actual database name)

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Exit the script if connection fails
}

// Set the character set to UTF-8 for better compatibility with special characters
$conn->set_charset("utf8");

// Optional: Set a timezone for consistency in date/time operations
date_default_timezone_set('Asia/Kolkata'); // Adjust the timezone according to your location
?>
