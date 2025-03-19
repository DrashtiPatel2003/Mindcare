<?php
include 'includes/db_connect.php';

$sql = "SELECT * FROM therapists";
$result = $conn->query($sql);

$therapists = [];
while ($row = $result->fetch_assoc()) {
    $therapists[] = $row;
}

echo json_encode($therapists);
$conn->close();
?>
