<?php
session_start();
ob_start();

// Include PHPMailer classes via Composer autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; 
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Check if email exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare error: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);

        // Update OTP (and its generated time) in the database
        $updateSql = "UPDATE users SET otp = ?, otp_generated_at = NOW() WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        if (!$updateStmt) {
            die("Prepare error: " . $conn->error);
        }
        $updateStmt->bind_param("is", $otp, $email);
        if ($updateStmt->execute()) {
            // Save the email to session for later use in OTP verification and password reset
            $_SESSION['email'] = $email;
            
            // Initialize PHPMailer to send OTP email
            $mail = new PHPMailer(true);
            try {
                // SMTP server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'anandpatel99044@gmail.com';
                $mail->Password   = 'dsyn iuen xwzz yfxs'; // Replace with your actual SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Sender and recipient settings
                $mail->setFrom('anandpatel99044@gmail.com', 'MindCare');
                $mail->addAddress($email);

                // Email subject & body
                $mail->Subject = 'Your OTP Code';
                $mail->Body    = "Your OTP code is: $otp";

                // Send the email
                $mail->send();

                // Redirect to the OTP verification page
                header("Location: verify_otp.html");
                exit();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Failed to update OTP in the database.";
        }
        $updateStmt->close();
    } else {
        echo "Email not found.";
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}

ob_end_flush();
?>








