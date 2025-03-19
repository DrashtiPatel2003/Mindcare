<?php
include '../includes/db_connect.php';

// Deleting a user
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];  // Get user ID from the URL

    // SQL query to delete the user
    $sql = "DELETE FROM users WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully.";
        // Redirect to the same page after deletion
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// Fetching and displaying users
$sql = "SELECT * FROM users";  // Query to fetch all users
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff0f5; /* Pastel pink background */
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            color: #d45d6f; /* Pastel pink color */
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #d45d6f; /* Pastel pink border */
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f7d7e8; /* Light pastel pink */
        }
        tr:nth-child(even) {
            background-color: #f9f0f4; /* Very light pastel pink */
        }
        a {
            color: #d45d6f; /* Pastel pink */
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            color: #e7a6bb; /* Slightly darker pastel pink on hover */
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .back-btn {
            background-color: #d45d6f;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .back-btn:hover {
            background-color: #e7a6bb;
        }
        img.profile-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="javascript:history.back()" class="back-btn">Back</a>
    <h1>Manage Users</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Email</th>
                <th>Emergency Contact</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Profile Pic</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";  // Display user ID
            echo "<td>" . $row['name'] . "</td>";  // Display user name
            echo "<td>" . $row['phone'] . "</td>";  // Display user phone
            echo "<td>" . $row['address'] . "</td>";  // Display user address
            echo "<td>" . $row['email'] . "</td>";  // Display user email
            echo "<td>" . ($row['emergency_contact'] ?? 'N/A') . "</td>";  // Display emergency contact
            echo "<td>" . ($row['dob'] ? $row['dob'] : 'N/A') . "</td>";  // Display DOB
            echo "<td>" . ($row['gender'] ? $row['gender'] : 'N/A') . "</td>";  // Display gender
            echo "<td>";
            if (!empty($row['profile_pic'])) {
                echo "<img src='" . $row['profile_pic'] . "' alt='Profile Pic' class='profile-thumb'>";
            } else {
                echo "N/A";
            }
            echo "</td>";
            echo "<td>" . $row['created_at'] . "</td>";  // Display created date
            echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?id=" . $row['id'] . "'>Delete</a></td>";  // Link to delete the user
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found!</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
