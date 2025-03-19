<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['new-password']) && !empty($_POST['new-password'])) {
        $newPassword = trim($_POST['new-password']);
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Retrieve email from session
        if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
            $email = $_SESSION['email'];
        } else {
            die("Session expired. Please log in again.");
        }

        // Prepare SQL to update the password
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        if (!$stmt) {
            die("Prepare error: " . $conn->error);
        }
        $stmt->bind_param("ss", $hashedPassword, $email);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "✅ Password updated successfully!";
            } else {
                echo "⚠️ No changes made (perhaps the new password is the same as the old one).";
            }
        } else {
            echo "❌ Error updating password: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "⚠️ Password cannot be empty.";
    }
} else {
    echo "❌ Invalid request method.";
}
?>
