<?php
session_start();
if (!isset($_SESSION['admin'])) {
    echo "Admin session not set. Redirecting...";
    // Debugging information
    echo "<br>Current Path: " . __FILE__;
    echo "<br>Session Data: ";
    print_r($_SESSION);
    exit;
}

include '../includes/db_connect.php';

$sql = "SELECT * FROM contacts ORDER BY created_at DESC";
$result = $conn->query($sql);

if (!$result) {
    echo "Database query failed: " . $conn->error;
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        header {
            background-color: #ff99c8;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-left: 10px;
        }
        header a:hover {
            text-decoration: underline;
        }
        section {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color:#cc6699;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <header>
        <h1>User Messages</h1>
        <a href="dashboard.php">Back to Dashboard</a>
    </header>
    <section>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['message']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No messages found.</p>
        <?php endif; ?>
    </section>
    <script>
        // Optional JavaScript Logic
        const rows = document.querySelectorAll("table tr");
        rows.forEach(row => {
            row.addEventListener("click", () => {
                alert("Row clicked: " + row.innerText);
            });
        });
    </script>
</body>
</html>
