<?php
include 'includes/db_connect.php';

if (!isset($_GET['date']) || !isset($_GET['therapist_id']) || !is_numeric($_GET['therapist_id'])) {
    echo json_encode([]);
    exit;
}

$date = $_GET['date']; // Expected to be in dd-mm-yyyy or yyyy-mm-dd format
$therapist_id = intval($_GET['therapist_id']);

// Determine date format and convert if necessary
if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    $mysqlDate = $date;
} elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $date)) {
    $dateObj = DateTime::createFromFormat('d-m-Y', $date);
    $mysqlDate = $dateObj ? $dateObj->format('Y-m-d') : date('Y-m-d');
} else {
    $mysqlDate = date('Y-m-d');
}

// Updated SQL: Only fetch slots that are available (is_booked = 0)
$sql = "SELECT id, 
               DATE_FORMAT(slot_datetime, '%H:%i:%s') AS raw_time,
               DATE_FORMAT(slot_datetime, '%h:%i %p') AS slot_datetime 
        FROM therapist_slots 
        WHERE therapist_id = ? 
          AND DATE(slot_datetime) = ? 
          AND is_booked = 0";

$stmt = $conn->prepare($sql);
if (!$stmt) { 
    echo json_encode([]);
    exit;
}

$stmt->bind_param("is", $therapist_id, $mysqlDate);
$stmt->execute();
$result = $stmt->get_result();

$slots = [];
while ($row = $result->fetch_assoc()) {
    $slots[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($slots);
?>
