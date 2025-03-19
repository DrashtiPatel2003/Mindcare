<?php
include '../includes/db_connect.php';

// Fetch all therapists and their available slots (concatenated for display)
$sql = "SELECT t.*, GROUP_CONCAT(ts.slot_datetime ORDER BY ts.slot_datetime ASC SEPARATOR ', ') AS slots 
        FROM therapists t 
        LEFT JOIN therapist_slots ts ON t.id = ts.therapist_id 
        GROUP BY t.id";
$result = $conn->query($sql);

// Process deletion of a therapist if requested via GET parameter "delete"
if (isset($_GET['delete'])) {
    $therapist_id = $_GET['delete'];
    // (Optional) Debug: echo "Therapist ID: " . $therapist_id;
    $delete_sql = "DELETE FROM therapists WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $therapist_id);
    if ($stmt->execute()) {
        header("Location: therapist_admin.php?msg=Deleted Successfully");
        exit();
    } else {
        echo "<p class='error'>Error deleting therapist: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Therapists</title>
  <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #ffe4e1, #fff0f5);
        margin: 0;
        padding: 0;
        color: #333;
        text-align: center;
    }
    .container {
        max-width: 1100px;
        margin: 30px auto;
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }
    .therapist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }
    .therapist-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 2px solid #f48fb1;
        text-align: center;
    }
    .therapist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .therapist-card.selected {
        border: 3px solid #ff66b2;
        background-color: #fbeff5;
    }
    .therapist-card img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f48fb1;
        margin-bottom: 10px;
    }
    .therapist-card h3 {
        color: #d63384;
        font-size: 20px;
        margin-bottom: 5px;
    }
    .therapist-card p {
        font-size: 14px;
        color: #555;
        margin: 5px 0;
    }
    .btn {
        padding: 10px 15px;
        font-size: 14px;
        border: none;
        cursor: pointer;
        border-radius: 8px;
        transition: 0.3s;
        margin-top: 10px;
        display: inline-block;
        text-decoration: none;
        color: white;
    }
    .edit-btn { background: #f4a261; }
    .edit-btn:hover { background: #e76f51; }
    .delete-btn { background: #e63946; }
    .delete-btn:hover { background: #d62839; }
    .manage-btn { background: #4CAF50; }
    .manage-btn:hover { background: #45a049; }
  </style>
</head>
<body>

<h1>Available Therapists</h1>
<div class="container">
    <?php if (isset($_GET['msg'])) { ?>
      <p style="color: green;"><?php echo htmlspecialchars($_GET['msg']); ?></p>
    <?php } ?>
    <div class="therapist-grid">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div id="therapist-card-<?= $row['id'] ?>" class="therapist-card">
                <img src="../<?= htmlspecialchars($row['image']) ?>" alt="Therapist">
                <h3><?= htmlspecialchars($row['name']) ?></h3>
                <p><strong><?= htmlspecialchars($row['specialization']) ?></strong> | <?= htmlspecialchars($row['experience']) ?> Years</p>
                <p><strong>Session Type:</strong> <?= htmlspecialchars($row['session_type']) ?></p>
                
                <p><strong>Price:</strong> ₹<?= htmlspecialchars($row['price']) ?></p>
                
                <!-- Edit, Delete, and Manage Slots Buttons -->
                <a href="edit_therapist.php?id=<?= $row['id'] ?>" class="btn edit-btn">Edit</a>
                <a href="therapist_admin.php?delete=<?= $row['id'] ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this therapist?');">Delete</a>
                <a href="manage_therapist.php?therapist_id=<?= $row['id'] ?>" class="btn manage-btn">Manage Slots</a>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>
