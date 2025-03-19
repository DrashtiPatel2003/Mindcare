<?php
include '../includes/db_connect.php';

if (isset($_GET['id'])) {
    $therapist_id = $_GET['id'];
    
    // Fetch therapist details
    $stmt = $conn->prepare("SELECT * FROM therapists WHERE id = ?");
    $stmt->bind_param("i", $therapist_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $therapist = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $specialization = $_POST["specialization"];
    $experience = $_POST["experience"];
    $contact = $_POST["contact"];
    $bio = $_POST["bio"];
    $price = $_POST["price"];
    $session_type = $_POST["session_type"];

    $update_sql = "UPDATE therapists SET name=?, specialization=?, experience=?, contact=?, bio=?, price=?, session_type=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssissdsi", $name, $specialization, $experience, $contact, $bio, $price, $session_type, $therapist_id);

    if ($stmt->execute()) {
        header("Location:therapist_admin.php?msg=Updated Successfully");
        exit();
    } else {
        echo "<p class='error'>Error updating therapist: " . $stmt->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Therapist</title>

<style>

    body {
        font-family: 'Arial', sans-serif;
        background-color: #fdf1f5; 
        color: #333;
        margin: 0;
        padding: 0;
    }

    form {
        background-color: #fff;
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    input, textarea, select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #e1e1e1;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 1rem;
        background-color: #f9f9f9;
        color: #333;
    }

    input[type="text"], input[type="email"], input[type="number"], select {
        font-size: 1rem;
    }

    textarea {
        height: 150px;
    }

    select {
        appearance: none;
        background-color: #f9f9f9;
    }

    button {
        background-color: #e65b9f;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        width: 100%;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #d54e88;
    }

    /* Focus effects */
    input:focus, textarea:focus, select:focus {
        border-color: #e65b9f;
        outline: none;
    }
</style>

</style>
</head>
<body>

<h1>Edit Therapist</h1>
<form method="POST">
    <input type="text" name="name" value="<?= $therapist['name'] ?>" required>
    <input type="text" name="specialization" value="<?= $therapist['specialization'] ?>" required>
    <input type="number" name="experience" value="<?= $therapist['experience'] ?>" required>
    <input type="email" name="contact" value="<?= $therapist['contact'] ?>" required>
    <textarea name="bio"><?= $therapist['bio'] ?></textarea>
    <input type="number" name="price" value="<?= $therapist['price'] ?>" required>
    <select name="session_type">
        <option value="Online" <?= $therapist['session_type'] == 'Online' ? 'selected' : '' ?>>Online</option>
        <option value="In-Person" <?= $therapist['session_type'] == 'In-Person' ? 'selected' : '' ?>>In-Person</option>
    </select>
    <button type="submit">Update</button>
</form>

</body>
</html>
