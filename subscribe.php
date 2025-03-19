<?php
session_start();
include 'includes/db_connect.php'; // Adjust the path if needed

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the email field is provided
    if (isset($_POST['email'])) {
        // Trim whitespace from the email
        $email = trim($_POST['email']);

        // Validate the email format
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Escape the email string to protect against SQL injection
            $emailEscaped = mysqli_real_escape_string($conn, $email);

            // Insert the email into the newsletter_subscribers table
            $sql = "INSERT INTO newsletter_subscribers (email) VALUES ('$emailEscaped')";
            if (mysqli_query($conn, $sql)) {
                // Redirect to a thank-you page after successful subscription
                header("Location: thankyou.php");
                exit;
            } else {
                // In production, you might log the error and show a friendly message instead
                echo "Database error: " . mysqli_error($conn);
            }
        } else {
            echo "Invalid email address. Please go back and try again.";
        }
    } else {
        echo "No email provided.";
    }
} else {
    // If not a POST request, redirect to the homepage or subscription form page
    header("Location: index.php");
    exit;
}
?>
