<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure OTP fields are submitted as otp1, otp2, ... otp6
    if (isset($_POST['otp1'], $_POST['otp2'], $_POST['otp3'], 
              $_POST['otp4'], $_POST['otp5'], $_POST['otp6'])) {
        $otpInput = (int) ($_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'] . $_POST['otp6']);
        
        // Compare against OTP stored in session
        if ($otpInput === $_SESSION['otp']) {
            // Set the OTP verified flag
            $_SESSION['otp_verified'] = true;
            $_SESSION['otp_success'] = "  OTP verified successfully.";
            
            // Proceed to the next step (redirect to signup1.php)
            header("Location: signup1.php");
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
