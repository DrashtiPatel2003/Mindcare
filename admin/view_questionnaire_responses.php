<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index2.php");
    exit;
}
include '../includes/db_connect.php';

// Fetch questionnaire responses
$query = "SELECT * FROM responses ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Questionnaire Responses</title>
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
    /* Legend Styles */
    .legend {
      background-color: #f1f1f1;
      border: 1px solid #ddd;
      padding: 15px;
      margin-bottom: 20px;
    }
    .legend h3 {
      margin-top: 0;
      color: #5a5a5a;
    }
    .legend ul {
      list-style: none;
      padding-left: 0;
    }
    .legend li {
      margin-bottom: 5px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <a class="back-link" href="dashboard.php">&larr; Back to Dashboard</a>
  <h2>Questionnaire Responses</h2>
  
  <!-- Encoding Mapping Legend -->
  <div class="legend">
    <h3>Encoding Mapping Legend</h3>
    <ul>
      <li><strong>Gender:</strong> Female -> 0, Male -> 1, Others -> 2</li>
      <li><strong>Self Employed:</strong> No -> 0, Yes -> 1</li>
      <li><strong>Family History:</strong> No -> 0, Yes -> 1</li>
      <li><strong>Treatment:</strong> No -> 0, Yes -> 1</li>
      <li><strong>Work Interfere:</strong> Don't know -> 0, Never -> 1, Often -> 2, Rarely -> 3, Sometimes -> 4</li>
      <li><strong>No Employees:</strong> 1-5 -> 0, 100-500 -> 1, 26-100 -> 2, 500-1000 -> 3, 6-25 -> 4, More than 1000 -> 5</li>
      <li><strong>Remote Work:</strong> No -> 0, Yes -> 1</li>
      <li><strong>Tech Company:</strong> No -> 0, Yes -> 1</li>
      <li><strong>Benefits:</strong> Don't know -> 0, No -> 1, Yes -> 2</li>
      <li><strong>Care Options:</strong> No -> 0, Not sure -> 1, Yes -> 2</li>
      <li><strong>Wellness Program:</strong> Don't know -> 0, No -> 1, Yes -> 2</li>
      <li><strong>Seek Help:</strong> Don't know -> 0, No -> 1, Yes -> 2</li>
      <li><strong>Anonymity:</strong> Don't know -> 0, No -> 1, Yes -> 2</li>
      <li><strong>Leave Policy:</strong> Don't know -> 0, Somewhat difficult -> 1, Somewhat easy -> 2, Very difficult -> 3, Very easy -> 4</li>
      <li><strong>Mental Health Consequence:</strong> Maybe -> 0, No -> 1, Yes -> 2</li>
      <li><strong>Phys Health Consequence:</strong> Maybe -> 0, No -> 1, Yes -> 2</li>
      <li><strong>Coworkers:</strong> No -> 0, Some of them -> 1, Yes -> 2</li>
      <li><strong>Supervisor:</strong> No -> 0, Some of them -> 1, Yes -> 2</li>
      <li><strong>Mental Health Interview:</strong> Maybe -> 0, No -> 1, Yes -> 2</li>
      <li><strong>Phys Health Interview:</strong> Maybe -> 0, No -> 1, Yes -> 2</li>
      <li><strong>Mental vs Physical:</strong> Don't know -> 0, No -> 1, Yes -> 2</li>
      <li><strong>Obs Consequence:</strong> No -> 0, Yes -> 1</li>
    </ul>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Self Employed</th>
        <th>Family History</th>
        <th>Work Interfere</th>
        <th>No Employees</th>
        <th>Remote Work</th>
        <th>Tech Company</th>
        <th>Benefits</th>
        <th>Care Options</th>
        <th>Wellness Program</th>
        <th>Seek Help</th>
        <th>Anonymity</th>
        <th>Leave Policy</th>
        <th>Mental Health Consequence</th>
        <th>Phys Health Consequence</th>
        <th>Coworkers</th>
        <th>Supervisor</th>
        <th>Mental Health Interview</th>
        <th>Phys Health Interview</th>
        <th>Mental vs Physical</th>
        <th>Obs Consequence</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <tr>
        <td><?php echo htmlspecialchars($row['id']); ?></td>
        <td><?php echo htmlspecialchars($row['age']); ?></td>
        <td><?php echo htmlspecialchars($row['gender']); ?></td>
        <td><?php echo htmlspecialchars($row['self_employed']); ?></td>
        <td><?php echo htmlspecialchars($row['family_history']); ?></td>
        <td><?php echo htmlspecialchars($row['work_interfere']); ?></td>
        <td><?php echo htmlspecialchars($row['no_employees']); ?></td>
        <td><?php echo htmlspecialchars($row['remote_work']); ?></td>
        <td><?php echo htmlspecialchars($row['tech_company']); ?></td>
        <td><?php echo htmlspecialchars($row['benefits']); ?></td>
        <td><?php echo htmlspecialchars($row['care_options']); ?></td>
        <td><?php echo htmlspecialchars($row['wellness_program']); ?></td>
        <td><?php echo htmlspecialchars($row['seek_help']); ?></td>
        <td><?php echo htmlspecialchars($row['anonymity']); ?></td>
        <td><?php echo htmlspecialchars($row['leave_policy']); ?></td>
        <td><?php echo htmlspecialchars($row['mental_health_consequence']); ?></td>
        <td><?php echo htmlspecialchars($row['phys_health_consequence']); ?></td>
        <td><?php echo htmlspecialchars($row['coworkers']); ?></td>
        <td><?php echo htmlspecialchars($row['supervisor']); ?></td>
        <td><?php echo htmlspecialchars($row['mental_health_interview']); ?></td>
        <td><?php echo htmlspecialchars($row['phys_health_interview']); ?></td>
        <td><?php echo htmlspecialchars($row['mental_vs_physical']); ?></td>
        <td><?php echo htmlspecialchars($row['obs_consequence']); ?></td>
        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
