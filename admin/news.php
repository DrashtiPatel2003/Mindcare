<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index2.php");
    exit;
}
include '../includes/db_connect.php';

$query = "SELECT * FROM newsletter_subscribers ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Newsletter Subscribers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fffaf5;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #c94b8c;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #ffe6f0;
            color: #5a5a5a;
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
    <h2>Newsletter Subscribers</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Subscription Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($subscriber = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($subscriber['id']); ?></td>
                <td><?php echo htmlspecialchars($subscriber['email']); ?></td>
                <td><?php echo htmlspecialchars($subscriber['created_at']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
