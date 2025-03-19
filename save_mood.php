<?php
session_start();
include 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id']; // Get the logged-in user's ID
        $mood = $_POST['mood']; // Mood selected by the user
        $note = $_POST['note']; // Optional note
        $date = $_POST['mood_date']; // Selected date

        // Prepare the SQL query to insert the mood data
        $sql = "INSERT INTO user_moods (user_id, mood, date, message) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $user_id, $mood, $date, $note);

        if ($stmt->execute()) {
            echo "Mood saved successfully!";
        } else {
            echo "Error saving mood: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Please log in to save your mood.";
    }
}
?>
