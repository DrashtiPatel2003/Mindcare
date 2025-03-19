<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure all six OTP fields are present
    if (
        isset($_POST['otp1'], $_POST['otp2'], $_POST['otp3'], 
              $_POST['otp4'], $_POST['otp5'], $_POST['otp6'])
    ) {
        // Combine the OTP fields into one string and cast to integer
        $otpInput = (int) ($_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'] . $_POST['otp6']);
        
        // Retrieve email from session; if not set, try from POST (and store it in session)
        if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
            $email = $_SESSION['email'];
        } elseif (isset($_POST['email']) && !empty($_POST['email'])) {
            $email = $_POST['email'];
            $_SESSION['email'] = $email;
        } else {
            die("Email is not set. Please try again.");
        }
        
        // Fetch the stored OTP from the database for this email
        $sql = "SELECT otp FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare error: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($storedOtp);
        $stmt->fetch();
        $stmt->close();
        
        // Cast stored OTP to integer to ensure a proper comparison
        $storedOtp = (int)$storedOtp;
        
        if ($otpInput === $storedOtp) {
            echo "OTP verified successfully.";
            // Redirect to a password reset page (or next step) as needed
            header("Location: reset_password.html");
            exit();
        } else {
            echo "Invalid OTP.";
        }
    } else {
        echo "All OTP fields are required.";
    }
} else {
    echo "Invalid request method.";
}
?>
