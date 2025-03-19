<?php
session_start();
include 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $therapist_id = isset($_POST['therapist_id']) ? intval($_POST['therapist_id']) : 0;
    $slot_id = isset($_POST['slot_id']) ? intval($_POST['slot_id']) : 0;
    $user_id   = isset($_POST['user_id'])   ? intval($_POST['user_id'])   : 0;
    $user_name = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
    $user_email = isset($_POST['user_email']) ? trim($_POST['user_email']) : '';
    $user_phone = isset($_POST['user_phone']) ? trim($_POST['user_phone']) : '';
    $session_type = isset($_POST['session_type']) ? trim($_POST['session_type']) : 'Online';
    $primary_concern = isset($_POST['primary_concern']) ? trim($_POST['primary_concern']) : '';
    $referral = isset($_POST['referral']) ? trim($_POST['referral']) : '';
    $status = 'Pending';

    // Validate required fields
    if (!$therapist_id) $errors[] = "Therapist ID is required.";
    if (!$slot_id) $errors[] = "Slot ID is required.";
    if (!$user_id) $errors[] = "User ID is required.";
    if (!$user_name) $errors[] = "User name is required.";
    if (!$user_email) $errors[] = "User email is required.";
    if (!$user_phone) $errors[] = "User phone number is required.";

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
        exit;
    }

    // Start transaction
    $conn->begin_transaction();

    // Check if the slot is already booked
    $check_slot = $conn->prepare("SELECT is_booked FROM therapist_slots WHERE id = ? AND therapist_id = ? FOR UPDATE");
    $check_slot->bind_param("ii", $slot_id, $therapist_id);
    $check_slot->execute();
    $check_slot->bind_result($is_booked);
    $check_slot->fetch();
    $check_slot->close();

    if ($is_booked) {
        echo "<p style='color: red;'>This slot is already booked.</p>";
        $conn->rollback();
        exit;
    }

    // Retrieve the slot's datetime from therapist_slots table
    $get_slot = $conn->prepare("SELECT slot_datetime FROM therapist_slots WHERE id = ?");
    $get_slot->bind_param("i", $slot_id);
    $get_slot->execute();
    $get_slot->bind_result($slot_datetime);
    $get_slot->fetch();
    $get_slot->close();

    if (!$slot_datetime) {
        echo "<p style='color: red;'>Unable to retrieve slot datetime.</p>";
        $conn->rollback();
        exit;
    }

    // Extract the date and datetime values
    $date_value = date('Y-m-d', strtotime($slot_datetime));
    $time_slot_value = date('Y-m-d H:i:s', strtotime($slot_datetime));

    // Insert appointment including the user_id, date, and time_slot columns
    $stmt = $conn->prepare("INSERT INTO appointments (therapist_id, slot_id, user_id, user_name, user_email, user_phone, date, time_slot, session_type, primary_concern, referral, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisssssssss", $therapist_id, $slot_id, $user_id, $user_name, $user_email, $user_phone, $date_value, $time_slot_value, $session_type, $primary_concern, $referral, $status);

    if ($stmt->execute()) {
        // Mark slot as booked
        $update_slot = $conn->prepare("UPDATE therapist_slots SET is_booked = 1 WHERE id = ?");
        $update_slot->bind_param("i", $slot_id);
        $update_slot->execute();
        $update_slot->close();

        // Commit transaction
        $conn->commit();

        echo "<p style='color: green;'>Appointment booked successfully!</p>";
    } else {
        $conn->rollback();
        echo "<p style='color: red;'>Error booking appointment: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    die("<p style='color: red;'>Invalid request.</p>");
}
?>
