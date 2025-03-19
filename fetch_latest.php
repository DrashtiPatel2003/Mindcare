<?php
include 'includes/db_connect.php';

$sql = "SELECT age, gender, self_employed, family_history, work_interfere,
               no_employees, remote_work, tech_company, benefits, care_options,
               wellness_program, seek_help, anonymity, leave_policy,
               mental_health_consequence, phys_health_consequence, coworkers,
               supervisor, mental_health_interview, phys_health_interview,
               mental_vs_physical, obs_consequence
        FROM responses
        ORDER BY id DESC LIMIT 1"; // Fetch latest entry

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode(["error" => "No records found"]);
}

$conn->close();
?>