<?php
// Include database connection
include '../includes/db_connect.php';

// Start session and check if the user is logged in as admin
session_start();

// Fetch the list of users for selection (with email)
$query_users = "SELECT id, name, email FROM users";
$result_users = mysqli_query($conn, $query_users);
if (!$result_users) {
    die('Error fetching users: ' . mysqli_error($conn));
}

// Handle user selection (if any)
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

// Fetch mood data for the selected user
if ($user_id) {
    $query_moods = "SELECT um.id AS mood_id, um.mood, um.date, um.message, u.name 
                    FROM user_moods um 
                    JOIN users u ON um.user_id = u.id 
                    WHERE um.user_id = ? ORDER BY um.date DESC";
    $stmt = mysqli_prepare($conn, $query_moods);
    if ($stmt === false) {
        die('MySQL prepare error: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    $result_moods = mysqli_stmt_get_result($stmt);
} else {
    $result_moods = null;
}

// Handle delete request
if (isset($_GET['delete_mood_id'])) {
    $mood_id = $_GET['delete_mood_id'];
    $delete_query = "DELETE FROM user_moods WHERE id = ?";
    $delete_stmt = mysqli_prepare($conn, $delete_query);
    if ($delete_stmt === false) {
        die('MySQL prepare error: ' . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($delete_stmt, 'i', $mood_id);
    if (mysqli_stmt_execute($delete_stmt)) {
        // Redirect to the same page to refresh the mood list
        header("Location: manage_mood.php?user_id=$user_id");
        exit;
    } else {
        echo 'Error deleting mood entry: ' . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Moods</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fceef5; /* Soft pastel pink */
            color: #5e5c5c;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color:rgb(168, 93, 172); /* Elegant orange */
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        h2 {
            text-align: center;
            color:rgb(95, 7, 115);
            font-size: 28px;
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            display: block;
        }

        select {
            padding: 12px;
            margin: 10px 0;
            width: 100%;
            max-width: 500px;
            border: 2px solid #e67e22;
            border-radius: 8px;
            background-color: #fff;
            color: #333;
            font-size: 16px;
            font-weight: 600;
        }

        select option {
            padding: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        th {
            background-color: #f6b5d1; /* Soft pastel pink */
            color: #fff;
            font-weight: 700;
        }

        tr:nth-child(even) {
            background-color: #f9e0e8; /* Light pastel pink */
        }

        tr:hover {
            background-color: #f6d2e5; /* Slightly darker pink */
        }

        .no-moods {
            text-align: center;
            font-style: italic;
            color: #999;
        }

        .delete-button {
        padding: 6px 12px;
        font-size: 14px;
        background-color: #d7b4b1; /* Soft muted pink */
        color: #5e5c5c;
        border: 1px solid #d7b4b1;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
     
    }

    .delete-button:hover {
        background-color: #e0c3c1; /* Light muted pink */
        color: #ffffff;
        border-color: #e0c3c1;
    }
    .button {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            background-color: #e67e22;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 20px auto;
            display: block;
        }

    .button:hover {
            background-color: #d45c17;
        }
        .back-btn{
        padding: 6px 12px;
        font-size: 14px;
        background-color: #d7b4b1; /* Soft muted pink */
        color: #5e5c5c;
        border: 1px solid #d7b4b1;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        }

        .back-btn:hover {
        background-color: #e0c3c1; /* Light muted pink */
        color: #ffffff;
        border-color: #e0c3c1;
        }
    </style>
</head>
<body>

    <div class="container">
    <a href="javascript:history.back()" class="back-btn">Back</a>
        <h1>Manage User Moods</h1>
        
        <!-- User Selection Form -->
        <form action="manage_mood.php" method="GET">
            <label for="user">Select User:</label>
            <select name="user_id" id="user_id" onchange="this.form.submit()">
                <option value="">--Select User--</option>
                <?php while ($row = mysqli_fetch_assoc($result_users)): ?>
                    <option value="<?php echo $row['id']; ?>" <?php echo ($user_id == $row['id']) ? 'selected' : ''; ?>>
                        <?php echo $row['name']; ?> (ID: <?php echo $row['id']; ?>, <?php echo $row['email']; ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </form>
        
        <?php if ($user_id): ?>
            <?php
            // Fetch user name for mood log display
            $query_user_name = "SELECT name FROM users WHERE id = $user_id";
            $result_user_name = mysqli_query($conn, $query_user_name);
            if (!$result_user_name) {
                die('Error fetching user name: ' . mysqli_error($conn));
            }
            $user_name = mysqli_fetch_assoc($result_user_name)['name'];
            ?>
            <h2>Mood Log for <?php echo htmlspecialchars($user_name); ?></h2>
            
            <!-- Display Mood Data -->
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Mood</th>
                        <th>Message</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_moods && mysqli_num_rows($result_moods) > 0): ?>
                        <?php while ($mood = mysqli_fetch_assoc($result_moods)): ?>
                            <tr>
                                <td><?php echo date('d M Y', strtotime($mood['date'])); ?></td>
                                <td><?php echo htmlspecialchars($mood['mood']); ?></td>
                                <td><?php echo htmlspecialchars($mood['message']); ?></td>
                                <td>
                                    <a href="manage_mood.php?user_id=<?php echo $user_id; ?>&delete_mood_id=<?php echo $mood['mood_id']; ?>" 
                                       class="delete-button" 
                                       onclick="return confirm('Are you sure you want to delete this mood entry?');">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr class="no-moods">
                            <td colspan="4">No mood logs available for this user.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
