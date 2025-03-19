<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index2.php");
    exit;
}
include '../includes/db_connect.php';

// Fetch appointments with therapist details
$query = "SELECT a.*, t.name AS therapist_name 
          FROM appointments a 
          LEFT JOIN therapists t ON a.therapist_id = t.id 
          ORDER BY a.created_at DESC";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointments</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fffaf5;
      padding: 20px;
    }
    h2 {
      text-align: center;
      color: #5a5a5a;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #ffe6f0;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    .back-link {
      display: inline-block;
      margin-bottom: 20px;
      text-decoration: none;
      color: #ff99c8;
      font-weight: bold;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <a class="back-link" href="dashboard.php">&larr; Back to Dashboard</a>
  <h2>Appointments</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Therapist Name</th>
        <th>User ID</th>
        <th>User Name</th>
        <th>User Email</th>
        <th>User Phone</th>
        <th>Date</th>
        <th>Time Slot</th>
        <th>Session Type</th>
        <th>Primary Concern</th>
        <th>Referral</th>
        <th>Status</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <tr>
        <td><?php echo htmlspecialchars($row['id']); ?></td>
        <td><?php echo htmlspecialchars($row['therapist_name']); ?></td>
        <td><?php echo htmlspecialchars($row['user_id']); ?></td>
        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
        <td><?php echo htmlspecialchars($row['user_email']); ?></td>
        <td><?php echo htmlspecialchars($row['user_phone']); ?></td>
        <td><?php echo htmlspecialchars($row['date']); ?></td>
        <td><?php echo htmlspecialchars($row['time_slot']); ?></td>
        <td><?php echo htmlspecialchars($row['session_type']); ?></td>
        <td><?php echo htmlspecialchars($row['primary_concern']); ?></td>
        <td><?php echo htmlspecialchars($row['referral']); ?></td>
        <td><?php echo htmlspecialchars($row['status']); ?></td>
        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
