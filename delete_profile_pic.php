<?php
session_start();
include 'includes/db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signinsignup/signin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve the current profile picture path for the user
$sql = "SELECT profile_pic FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare error: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($profile_pic);
$stmt->fetch();
$stmt->close();

// Delete the file from the server if it exists and if a profile picture is set
if (!empty($profile_pic) && file_exists($profile_pic)) {
    if (!unlink($profile_pic)) {
        $_SESSION['error'] = "Error deleting profile picture file.";
        header("Location: profile.php");
        exit();
    }
}

// Update the user's record to remove the profile picture reference
$sql_update = "UPDATE users SET profile_pic = NULL WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
if (!$stmt_update) {
    die("Prepare error: " . $conn->error);
}
$stmt_update->bind_param("i", $user_id);
if ($stmt_update->execute()) {
    $_SESSION['message'] = "Profile picture deleted successfully.";
} else {
    $_SESSION['error'] = "Error updating profile picture in database.";
}
$stmt_update->close();
$conn->close();

// Redirect back to the profile page
header("Location: profile.php");
exit();
?>
