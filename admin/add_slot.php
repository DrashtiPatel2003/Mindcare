<?php
include __DIR__ . '/../includes/db_connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define time slots
$time_slots = ["09:00:00", "11:00:00", "14:00:00", "16:00:00"];

// Set the range: from tomorrow until 7 days ahead (a whole week)
$start_date = strtotime("+1 day");
$end_date = strtotime("+7 days");

// Fetch all therapist IDs into an array
$sql = "SELECT id FROM therapists";
$result = $conn->query($sql);
if (!$result) {
    die("❌ Error fetching therapists: " . $conn->error);
}

$therapists = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
         $therapists[] = $row["id"];
    }
} else {
    die("⚠️ No therapists found.");
}

// Loop through each day from start_date to end_date
for ($day = $start_date; $day <= $end_date; $day = strtotime("+1 day", $day)) {
    // If the day is Sunday (DAYOFWEEK returns 1 for Sunday), skip it
    if (date("w", $day) == 0) {
         echo "⚠️ Skipping Sunday: " . date("Y-m-d", $day) . "<br>";
         continue;
    }
    $current_date = date("Y-m-d", $day);
    
    // Loop through each therapist for the current date
    foreach ($therapists as $therapist_id) {
         // Loop through each defined time slot
         foreach ($time_slots as $time) {
              $slot_datetime = $current_date . " " . $time;  // e.g., "2025-02-24 09:00:00"
              
              // Check if the slot already exists for this therapist and datetime
              $check_sql = "SELECT id FROM therapist_slots WHERE therapist_id = ? AND slot_datetime = ?";
              $check_stmt = $conn->prepare($check_sql);
              if (!$check_stmt) {
                  die("❌ Error preparing check query: " . $conn->error);
              }
              $check_stmt->bind_param("is", $therapist_id, $slot_datetime);
              $check_stmt->execute();
              $check_stmt->store_result();
              $count = $check_stmt->num_rows;
              $check_stmt->close();
              
              // Insert slot if it does not exist
              if ($count == 0) {  
                  $sql_insert = "INSERT INTO therapist_slots (therapist_id, slot_datetime) VALUES (?, ?)";
                  $stmt = $conn->prepare($sql_insert);
                  if (!$stmt) {
                      die("❌ Error preparing insert query: " . $conn->error);
                  }
                  $stmt->bind_param("is", $therapist_id, $slot_datetime);
                  if (!$stmt->execute()) {
                      die("❌ Error inserting slot: " . $stmt->error);
                  } else {
                      echo "✅ Slot added for therapist ID $therapist_id at $slot_datetime<br>";
                  }
                  $stmt->close();
              } else {
                  echo "⚠️ Slot already exists for therapist ID $therapist_id at $slot_datetime<br>";
              }
         }
    }
}

echo "🎉 Slots added successfully for the week starting " . date("Y-m-d", $start_date);

// Remove duplicate slots (if any)
$delete_sql = "
    DELETE ts1 FROM therapist_slots ts1
    INNER JOIN therapist_slots ts2 
      ON ts1.therapist_id = ts2.therapist_id 
     AND ts1.slot_datetime = ts2.slot_datetime 
     AND ts1.id > ts2.id
";
if ($conn->query($delete_sql)) {
    echo "<br>🗑️ Duplicate slots removed successfully.";
} else {
    echo "<br>❌ Error removing duplicate slots: " . $conn->error;
}

// Remove any slots that fall on a Sunday (if any slipped through)
$delete_sunday_sql = "DELETE FROM therapist_slots WHERE DAYOFWEEK(slot_datetime) = 1";
if ($conn->query($delete_sunday_sql)) {
    echo "<br>🗑️ Sunday slots removed successfully.";
} else {
    echo "<br>❌ Error removing Sunday slots: " . $conn->error;
}

$conn->close();
?>
