<?php
session_start();
include 'includes/db_connect.php';

$user_id = $_SESSION['user_id'];  // Assumes a logged-in user
$date = $_GET['date'];  // Expected format: YYYY-MM-DD

$sql = "SELECT mood FROM user_moods WHERE user_id = ? AND DATE(date) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $date);
$stmt->execute();
$result = $stmt->get_result();

$moods = [];
while ($row = $result->fetch_assoc()) {
    $moods[] = $row['mood'];
}

echo json_encode($moods);

$stmt->close();
$conn->close();
?>
