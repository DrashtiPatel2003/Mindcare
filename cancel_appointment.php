<?php
session_start();
include 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate appointment_id
    if (!isset($_POST['appointment_id']) || !is_numeric($_POST['appointment_id'])) {
        echo "Invalid appointment id.";
        exit;
    }
    $appointment_id = intval($_POST['appointment_id']);

    // Start transaction
    $conn->begin_transaction();

    // Retrieve the slot_id associated with this appointment (only if not already cancelled)
    $stmt = $conn->prepare("SELECT slot_id FROM appointments WHERE id = ? AND status != 'Cancelled' FOR UPDATE");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $stmt->bind_result($slot_id);
    if (!$stmt->fetch()) {
        echo "Appointment not found or already cancelled.";
        $stmt->close();
        $conn->rollback();
        exit;
    }
    $stmt->close();

    // Update appointment status to 'Cancelled'
    $stmt = $conn->prepare("UPDATE appointments SET status = 'Cancelled' WHERE id = ?");
    $stmt->bind_param("i", $appointment_id);
    if (!$stmt->execute()) {
        echo "Error updating appointment: " . $stmt->error;
        $stmt->close();
        $conn->rollback();
        exit;
    }
    $stmt->close();

    // Update therapist_slots: mark the slot as available (is_booked = 0)
    $stmt = $conn->prepare("UPDATE therapist_slots SET is_booked = 0 WHERE id = ?");
    $stmt->bind_param("i", $slot_id);
    if (!$stmt->execute()) {
        echo "Error updating slot: " . $stmt->error;
        $stmt->close();
        $conn->rollback();
        exit;
    }
    $stmt->close();

    $conn->commit();
    echo "Appointment cancelled successfully.";
} else {
    echo "Invalid request method.";
}
?>
