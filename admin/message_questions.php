<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index2.php");
    exit;
}
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $conn->real_escape_string($_POST['question']);
    $sql = "INSERT INTO questions (question) VALUES ('$question')";
    $conn->query($sql);
}

$sql = "SELECT * FROM questions ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <header>
        <h1>Manage Questions</h1>
        <a href="dashboard.php">Back to Dashboard</a>
    </header>
    <section>
        <form method="POST">
            <label for="question">Add Question</label>
            <textarea name="question" required></textarea>
            <button type="submit">Add</button>
        </form>
        <h2>Existing Questions</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>{$row['question']} <a href='../process/delete_question.php?id={$row['id']}'>Delete</a></li>";
            }
            echo "</ul>";
        } else {
            echo "No questions found.";
        }
        ?>
    </section>
</body>
</html>
