<?php
// Include database connection
include 'includes/db_connect.php';

// Start session and check if the user is logged in
session_start();
$user_id = $_SESSION['user_id']; // Assuming the user_id is stored in session

// Fetch user details (name and email)
$query_user = "SELECT name, email FROM users WHERE id = ?";
$stmt_user = mysqli_prepare($conn, $query_user);
mysqli_stmt_bind_param($stmt_user, 'i', $user_id);
mysqli_stmt_execute($stmt_user);
$result_user = mysqli_stmt_get_result($stmt_user);
$user = mysqli_fetch_assoc($result_user);

// Default date range (Current month)
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01');
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-t');

// Get mood filter (if selected)
$mood_filter = isset($_POST['mood_filter']) ? $_POST['mood_filter'] : '';

// Base SQL query (fetch all moods by default)
$query_moods = "SELECT mood, date FROM user_moods WHERE user_id = ? AND date BETWEEN ? AND ?";

// Apply mood filter only if selected
if (!empty($mood_filter)) {
    $query_moods .= " AND mood = ?";
}

// Prepare and execute query
$stmt = mysqli_prepare($conn, $query_moods);
if (!empty($mood_filter)) {
    mysqli_stmt_bind_param($stmt, 'ssss', $user_id, $start_date, $end_date, $mood_filter);
} else {
    mysqli_stmt_bind_param($stmt, 'sss', $user_id, $start_date, $end_date);
}
mysqli_stmt_execute($stmt);
$result_moods = mysqli_stmt_get_result($stmt);

// Prepare data for Chart.js
$moods = [];
$dates = [];

// Mapping moods to numerical values for visualization
$mood_map = ['Happy' => 4, 'Neutral' => 3, 'Sad' => 2, 'Stressed' => 1];
while ($row = mysqli_fetch_assoc($result_moods)) {
    $moods[] = $mood_map[$row['mood']] ?? 0;
    $dates[] = date('d M', strtotime($row['date']));
}

// Default Graph Type
$graph_type = isset($_POST['graph_type']) ? $_POST['graph_type'] : 'bar';

// Mood Colors
$color_map = [
    4 => '#FFEB3B',   // Happy → Yellow
    3 => '#9E9E9E',   // Neutral → Grey
    2 => '#2196F3',   // Sad → Blue
    1 => '#FF5722'    // Stressed → Orange
];

$colors = array_map(fn($mood) => $color_map[$mood] ?? '#E0E0E0', $moods);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fdf1f5; 
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 50px;
            text-align: center;
        }
        .user-info {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #FF61A6, #FF95C8);
            color: white;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .user-info h2 {
            margin: 0;
            font-size: 1.8em;
        }
        .user-info p {
            margin: 5px 0;
            font-size: 1.2em;
        }
        h1 {
            text-align: center;
            font-size: 2.5em;
            color: #FF61A6;
            margin-bottom: 20px;
        }
        label {
            font-size: 1.1em;
            margin-bottom: 5px;
            display: inline-block;
            color: #FF61A6;
        }
        input, select, button {
            width: 94%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }
        button {
            width: 100px;
            background-color: #FF61A6;
            color: white;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #e05599;
        }
        .mood-form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        .mood-form div {
            flex: 1;
            min-width: 200px;
        }
        canvas {
            max-width: 100%;
            margin-top: 20px;
            border: 2px solid #FF61A6;
            border-radius: 10px;
            background-color: #fff;
        }
        .section{
            width: 100px;
            background-color: #FF61A6;
            color: white;
            cursor: pointer;
            font-size: 1.1em;
          

        }
        .graph-container {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Display User Info -->
    <div class="user-info">
        <h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>
    </div>

    <h1>User Dashboard</h1>

    <form action="user_dashboard.php" method="POST" class="mood-form">
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
        </div>
        <div>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
        </div>
        <div>
            <label for="mood_filter">Mood Filter:</label>
            <select name="mood_filter" id="mood_filter">
                <option value="">--Show All Moods--</option>
                <option value="Happy" <?php echo ($mood_filter == 'Happy') ? 'selected' : ''; ?>>Happy</option>
                <option value="Sad" <?php echo ($mood_filter == 'Sad') ? 'selected' : ''; ?>>Sad</option>
                <option value="Neutral" <?php echo ($mood_filter == 'Neutral') ? 'selected' : ''; ?>>Neutral</option>
                <option value="Stressed" <?php echo ($mood_filter == 'Stressed') ? 'selected' : ''; ?>>Stressed</option>
            </select>
        </div>
        <div>
            <label for="graph_type">Graph Type:</label>
            <select name="graph_type" id="graph_type">
                <option value="bar" <?php echo ($graph_type == 'bar') ? 'selected' : ''; ?>>Bar</option>
                <option value="line" <?php echo ($graph_type == 'line') ? 'selected' : ''; ?>>Line</option>
                <option value="radar" <?php echo ($graph_type == 'radar') ? 'selected' : ''; ?>>Radar</option>
                <option value="doughnut" <?php echo ($graph_type == 'doughnut') ? 'selected' : ''; ?>>Doughnut</option>
                <option value="pie" <?php echo ($graph_type == 'pie') ? 'selected' : ''; ?>>Pie</option>
            </select>
        </div>
        <div>
            <button type="submit">Update Graph</button>
        <section>
            <a href="index.php" class="home">Home</a>
        </section>
        </div>
    </form>

    <div class="graph-container">
        <canvas id="moodChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('moodChart').getContext('2d');
        var moodChart = new Chart(ctx, {
            type: '<?php echo $graph_type; ?>',
            data: {
                labels: <?php echo json_encode($dates); ?>,
                datasets: [{
                    label: 'User Mood',
                    data: <?php echo json_encode($moods); ?>,
                    backgroundColor: <?php echo json_encode($colors); ?>
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</div>

</body>
</html>
