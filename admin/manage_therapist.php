<?php
include '../includes/db_connect.php';

// Validate therapist_id
if (!isset($_GET['therapist_id']) || !is_numeric($_GET['therapist_id'])) {
    header("Location: therapist_admin.php");
    exit;
}
$therapist_id = intval($_GET['therapist_id']);

// PROCESS: Update therapist details if form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_therapist'])) {
    $name = $_POST['name'] ?? '';
    $specialization = $_POST['specialization'] ?? '';
    $experience = $_POST['experience'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $price = $_POST['price'] ?? '';
    $session_type = $_POST['session_type'] ?? '';
    $bio = $_POST['bio'] ?? '';
    
    $update_stmt = $conn->prepare("UPDATE therapists SET name = ?, specialization = ?, experience = ?, contact = ?, price = ?, session_type = ?, bio = ? WHERE id = ?");
    $update_stmt->bind_param("ssissssi", $name, $specialization, $experience, $contact, $price, $session_type, $bio, $therapist_id);
    $update_stmt->execute();
    $update_stmt->close();
    header("Location: manage_therapist.php?therapist_id=" . $therapist_id . "&msg=Details Updated");
    exit();
}

// PROCESS: Add new slot if form submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_slot'])) {
    $slot_datetime = $_POST['slot_datetime'] ?? '';
    if (!empty($slot_datetime)) {
        // Convert from datetime-local format (YYYY-MM-DDTHH:MM) to MySQL datetime (YYYY-MM-DD HH:MM:00)
        $slot_datetime = str_replace("T", " ", $slot_datetime) . ":00";
        $insert_stmt = $conn->prepare("INSERT INTO therapist_slots (therapist_id, slot_datetime) VALUES (?, ?)");
        $insert_stmt->bind_param("is", $therapist_id, $slot_datetime);
        $insert_stmt->execute();
        $insert_stmt->close();
        header("Location: manage_therapist.php?therapist_id=" . $therapist_id . "&msg=Slot Added");
        exit();
    }
}

// PROCESS: Delete a slot if requested
if (isset($_GET['delete_slot']) && is_numeric($_GET['delete_slot'])) {
    $slot_id = intval($_GET['delete_slot']);
    $delete_stmt = $conn->prepare("DELETE FROM therapist_slots WHERE id = ? AND therapist_id = ?");
    $delete_stmt->bind_param("ii", $slot_id, $therapist_id);
    $delete_stmt->execute();
    $delete_stmt->close();
    header("Location: manage_therapist.php?therapist_id=" . $therapist_id . "&msg=Slot Deleted");
    exit();
}

// FETCH: Get therapist details
$stmt = $conn->prepare("SELECT * FROM therapists WHERE id = ?");
$stmt->bind_param("i", $therapist_id);
$stmt->execute();
$result = $stmt->get_result();
$therapist = $result->fetch_assoc();
$stmt->close();

if (!$therapist) {
    die("Therapist not found.");
}

// FETCH: Get all slots for this therapist ordered by datetime
$slots_result = $conn->query("SELECT * FROM therapist_slots WHERE therapist_id = $therapist_id ORDER BY slot_datetime ASC");
$slots = [];
while ($row = $slots_result->fetch_assoc()) {
    $slots[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Therapist - <?php echo htmlspecialchars($therapist['name']); ?></title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 900px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    h1, h2 {
      text-align: center;
    }
    .msg {
      text-align: center;
      color: green;
      margin-bottom: 15px;
    }
    form {
      margin-bottom: 30px;
    }
    .form-group {
      margin: 10px 0;
    }
    label {
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"],
    input[type="number"],
    textarea,
    input[type="datetime-local"] {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .btn {
      padding: 10px 15px;
      font-size: 14px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
      margin: 5px 0;
      display: inline-block;
      text-decoration: none;
      color: white;
    }
    .update-btn { background: #4CAF50; }
    .delete-btn { background: #e63946; }
    .add-btn { background: #f48fb1; }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
    }
    th {
      background: #f48fb1;
      color: white;
    }
  </style>
</head>
<body>
<div class="container">
  <h1>Manage Therapist</h1>
  <?php if (isset($_GET['msg'])) { ?>
    <p class="msg"><?php echo htmlspecialchars($_GET['msg']); ?></p>
  <?php } ?>

  <!-- Therapist Details Form -->
  <h2>Edit Therapist Details</h2>
  <form action="manage_therapist.php?therapist_id=<?php echo $therapist_id; ?>" method="POST">
    <input type="hidden" name="update_therapist" value="1">
    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($therapist['name']); ?>" required>
    </div>
    <div class="form-group">
      <label for="specialization">Specialization</label>
      <input type="text" name="specialization" id="specialization" value="<?php echo htmlspecialchars($therapist['specialization']); ?>" required>
    </div>
    <div class="form-group">
      <label for="experience">Experience (Years)</label>
      <input type="number" name="experience" id="experience" value="<?php echo htmlspecialchars($therapist['experience']); ?>" required>
    </div>
    <div class="form-group">
      <label for="contact">Contact</label>
      <input type="text" name="contact" id="contact" value="<?php echo htmlspecialchars($therapist['contact']); ?>" required>
    </div>
    <div class="form-group">
      <label for="price">Price per session</label>
      <input type="number" step="0.01" name="price" id="price" value="<?php echo htmlspecialchars($therapist['price']); ?>" required>
    </div>
    <div class="form-group">
      <label for="session_type">Session Type</label>
      <input type="text" name="session_type" id="session_type" value="<?php echo htmlspecialchars($therapist['session_type']); ?>" required>
    </div>
    <div class="form-group">
      <label for="bio">Bio</label>
      <textarea name="bio" id="bio" rows="4" required><?php echo htmlspecialchars($therapist['bio']); ?></textarea>
    </div>
    <button type="submit" class="btn update-btn">Update Details</button>
  </form>

  <!-- Slot Management Section -->
  <h2>Manage Slots</h2>
  
  <h3>Existing Slots</h3>
  <?php if (count($slots) > 0) { ?>
    <table>
      <tr>
        <th>Slot ID</th>
        <th>Date & Time</th>
        <th>Action</th>
      </tr>
      <?php foreach ($slots as $slot) { ?>
        <tr>
          <td><?php echo $slot['id']; ?></td>
          <td><?php echo date("d-m-Y h:i A", strtotime($slot['slot_datetime'])); ?></td>
          <td>
            <a href="manage_therapist.php?therapist_id=<?php echo $therapist_id; ?>&delete_slot=<?php echo $slot['id']; ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this slot?');">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </table>
  <?php } else { ?>
    <p>No slots available.</p>
  <?php } ?>

  <h3>Add New Slot</h3>
  <form action="manage_therapist.php?therapist_id=<?php echo $therapist_id; ?>" method="POST">
    <div class="form-group">
      <label for="slot_datetime">Slot Date & Time</label>
      <input type="datetime-local" name="slot_datetime" id="slot_datetime" required>
    </div>
    <input type="hidden" name="add_slot" value="1">
    <button type="submit" class="btn add-btn">Add Slot</button>
  </form>
  
  <p><a href="therapist_admin.php">Back to Therapist Admin</a></p>
</div>
</body>
</html>
