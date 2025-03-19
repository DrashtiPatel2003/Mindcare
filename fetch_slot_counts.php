<?php
include 'includes/db_connect.php';

// Enable error reporting (remove or comment out in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validate required GET parameters
if (!isset($_GET['therapist_id']) || !is_numeric($_GET['therapist_id']) || !isset($_GET['date'])) {
    echo json_encode(["error" => "Missing parameters"]);
    exit;
}

$therapist_id = intval($_GET['therapist_id']);
$date = trim($_GET['date']); // Expected format: yyyy-mm-dd

// Validate date format (simple check)
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo json_encode(["error" => "Invalid date format"]);
    exit;
}

// Prepare the statement to count only available (not booked) slots
$sql = "SELECT COUNT(*) AS available_slots 
        FROM therapist_slots 
        WHERE therapist_id = ? 
          AND DATE(slot_datetime) = ? 
          AND is_booked = 0";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => "Error preparing query: " . $conn->error]);
    exit;
}

$stmt->bind_param("is", $therapist_id, $date);

if (!$stmt->execute()) {
    echo json_encode(["error" => "Error executing query: " . $stmt->error]);
    exit;
}

$result = $stmt->get_result();
if (!$result) {
    echo json_encode(["error" => "Error fetching results: " . $stmt->error]);
    exit;
}

$row = $result->fetch_assoc();
$available_slots = isset($row['available_slots']) ? $row['available_slots'] : 0;

$stmt->close();
$conn->close();

echo json_encode(["date" => $date, "available_slots" => $available_slots], JSON_UNESCAPED_SLASHES);
?>
