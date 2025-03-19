<?php
session_start();
ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Check if email already exists in the users table
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare error: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
         echo "Email already registered.";
         exit();
    }
    $stmt->close();

    // Email is new; generate a random 6-digit OTP
    $otp = rand(100000, 999999);

    // Store OTP and signup data in session for later verification
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;
    $_SESSION['signup_data'] = [
         'name'             => isset($_POST['name']) ? $_POST['name'] : "",
         'phone'            => isset($_POST['phone']) ? $_POST['phone'] : "",
         'address'          => isset($_POST['address']) ? $_POST['address'] : "",
         'email'            => $email,
         'password'         => isset($_POST['password']) ? $_POST['password'] : "",
         'confirm_password' => isset($_POST['confirm-password']) ? $_POST['confirm-password'] : ""
    ];

    // Send OTP via PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.mail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your email';
        $mail->Password   = 'your key';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom('your_email@example.com', 'MindCare');
        $mail->addAddress($email);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "Your OTP code is: $otp";
        $mail->send();

        header("Location: verify_otp_signup.html");
        exit();
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
ob_end_flush();
?>
