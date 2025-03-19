<?php
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $specialization = $_POST["specialization"];
    $experience = $_POST["experience"];
    $contact = $_POST["contact"];
    $bio = $_POST["bio"];
    $price = $_POST["price"];
    $session_type = $_POST["session_type"];
    $slots = $_POST["slots"]; // Multiple Slots with date and time

    // Handle Image Upload
    $imagePath = ""; 
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "../assets/images/"; // Ensure correct path
        $imageFileName = time() . "_" . basename($_FILES["image"]["name"]);
        $imagePath = $targetDir . $imageFileName;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
            // Image successfully uploaded
            $imagePath = "assets/images/" . $imageFileName; // Save correct path in DB
        } else {
            echo "<p class='error'>Failed to upload image.</p>";
        }
    }

    // Insert therapist data
    $sql = "INSERT INTO therapists (name, specialization, experience, contact, bio, image, price, session_type)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssds", $name, $specialization, $experience, $contact, $bio, $imagePath, $price, $session_type);

    if ($stmt->execute()) {
        $therapist_id = $stmt->insert_id; // Get inserted therapist ID
        
        // Insert multiple slots into `therapist_slots`
        $slot_sql = "INSERT INTO therapist_slots (therapist_id, slot_datetime) VALUES (?, ?)";
        $slot_stmt = $conn->prepare($slot_sql);
        
        foreach ($slots as $slot_datetime) {
            $slot_stmt->bind_param("is", $therapist_id, $slot_datetime);
            $slot_stmt->execute();
        }
        
        echo "<p class='success'>Therapist added successfully with multiple slots!</p>";
    } else {
        echo "<p class='error'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $slot_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Therapist</title>
  <style>
    /* General Styles */
body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #ffe4e1, #fff0f5); /* Soft pastel gradient */
    margin: 0;
    padding: 0;
    color: #333;
    text-align: center;
}

/* Page Title */
h1 {
    color: #d63384;
    margin-top: 20px;
    font-size: 32px;
    font-weight: bold;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
}

/* Form Container */
.container {
    max-width: 500px;
    margin: 30px auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;
}

.container:hover {
    transform: translateY(-2px); /* Slight lift effect on hover */
}

/* Input Fields & Select Boxes */
input, select, textarea {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: 2px solid #d63384;
    border-radius: 10px;
    font-size: 16px;
    box-sizing: border-box;
    background-color: #fff;
    transition: border 0.3s ease, box-shadow 0.3s ease;
}

/* Focus Effect */
input:focus, textarea:focus, select:focus {
    outline: none;
    border-color: #e76c8b;
    box-shadow: 0 0 10px rgba(228, 112, 134, 0.4);
}

/* Textarea */
textarea {
    resize: vertical;
    min-height: 120px;
}

/* Buttons */
.btn {
    background: linear-gradient(to right, #d63384, #ff66b2);
    color: #fff;
    border: none;
    padding: 14px 20px;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 10px;
    transition: all 0.3s ease-in-out;
    width: 100%;
    margin-top: 15px;
    box-shadow: 0 5px 10px rgba(214, 51, 132, 0.3);
}

/* Button Hover Effect */
.btn:hover {
    background: linear-gradient(to right, #e63988, #ff77c0);
    box-shadow: 0 8px 18px rgba(214, 51, 132, 0.4);
    transform: scale(1.02);
}

/* Dashboard Button */
.dashboard-btn {
    display: inline-block;
    background: linear-gradient(to right, #ff85a2, #ffb6c1);
    color: white;
    text-decoration: none;
    padding: 12px 25px;
    border-radius: 10px;
    margin-top: 25px;
    font-weight: bold;
    font-size: 16px;
    transition: background 0.3s ease, transform 0.2s ease-in-out;
    box-shadow: 0 4px 10px rgba(255, 133, 162, 0.4);
}

/* Dashboard Button Hover Effect */
.dashboard-btn:hover {
    background: linear-gradient(to right, #ff6f9f, #ffa8b6);
    transform: scale(1.05);
    box-shadow: 0 6px 15px rgba(255, 133, 162, 0.5);
}

/* Mobile Responsiveness */
@media screen and (max-width: 600px) {
    .container {
        width: 90%;
        padding: 20px;
    }
    
    h1 {
        font-size: 28px;
    }
    
    .btn {
        font-size: 16px;
        padding: 12px;
    }
}

  </style>
</head>
<body>

<a href="dashboard.php" class="dashboard-btn">Go to Dashboard</a>

<h1>Add a Therapist</h1>
<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="specialization" placeholder="Specialization" required>
        <input type="number" name="experience" placeholder="Experience (Years)" required>
        <input type="email" name="contact" placeholder="Contact Email" required>
        <textarea name="bio" placeholder="Bio" required></textarea>
        
        <!-- Image Upload -->
        <label>Upload Profile Picture:</label>
        <input type="file" name="image" accept="image/*">

        <!-- Price -->
        <input type="number" name="price" placeholder="Session Price (INR)" step="0.01" required>

        <!-- Session Type -->
        <select name="session_type" required>
            <option value="Online">Online</option>
            <option value="In-Person">In-Person</option>
            <option value="Both">Both</option>
        </select>

        <!-- Multiple Date and Time Slots -->
        <label>Select Available Time Slots (with Date & Time):</label>
        <div id="slots-container">
            <!-- Initial Slot Input -->
            <input type="datetime-local" name="slots[]" required>
        </div>
        <button type="button" class="btn" onclick="addSlotField()">Add Another Slot</button>

        <button type="submit" class="btn">Add Therapist</button>
    </form>
</div>

<script>
    function addSlotField() {
        // Create a new slot field (datetime-local input) with a delete button
        var newSlotField = document.createElement("div");
        newSlotField.classList.add("slot-field");

        newSlotField.innerHTML = `
            <input type="datetime-local" name="slots[]" required>
            <button type="button" onclick="removeSlotField(this)" class="btn delete-btn">Delete</button>
        `;
        
        // Append it to the slots container
        document.getElementById("slots-container").appendChild(newSlotField);
    }

    function removeSlotField(button) {
        // Remove the parent div of the clicked delete button (which is the slot input)
        button.parentElement.remove();
    }
</script>

</body>
</html>
