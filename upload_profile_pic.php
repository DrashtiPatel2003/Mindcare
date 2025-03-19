<?php
session_start();
include 'includes/db_connect.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signinsignup/signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Validate file upload
if (!isset($_FILES['profile_pic'])) {
    die("Error: File input field is missing.");
}
if ($_FILES['profile_pic']['error'] !== UPLOAD_ERR_OK) {
    die("Error: No file uploaded or an error occurred. Error Code: " . $_FILES['profile_pic']['error']);
}

$file = $_FILES['profile_pic'];
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$max_size = 2 * 1024 * 1024; // 2MB
$upload_dir = "uploads/";

// Validate file type
$file_type = mime_content_type($file['tmp_name']); // Get actual MIME type
if (!in_array($file_type, $allowed_types)) {
    die("Error: Only JPG, PNG, and GIF files are allowed.");
}

// Validate file size
if ($file['size'] > $max_size) {
    die("Error: File size exceeds 2MB.");
}

// Generate a unique filename
$file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$new_filename = "profile_" . $user_id . "_" . time() . "." . $file_extension;
$upload_path = $upload_dir . $new_filename;

// Remove old profile picture (except default)
$stmt = $conn->prepare("SELECT profile_pic FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($old_pic);
$stmt->fetch();
$stmt->close();

if ($old_pic && file_exists($old_pic) && $old_pic !== 'uploads/default.png') {
    unlink($old_pic);
}

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $upload_path)) {
    // Update database
    $stmt = $conn->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
    $stmt->bind_param("si", $upload_path, $user_id);
    if ($stmt->execute()) {
        header("Location: profile.php?upload=success");
        exit();
    } else {
        die("Error updating database: " . $conn->error);
    }
    $stmt->close();
} else {
    die("Error moving uploaded file.");
}

$conn->close();
?>
