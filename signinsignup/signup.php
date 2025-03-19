<?php
include '../includes/db_connect.php';


$response = [];

// Check if the form is submitted and all fields are filled
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are provided
    if (!isset($_POST['name'], $_POST['phone'], $_POST['address'], $_POST['email'], $_POST['password'])) {
        echo "All fields are required.";
        exit;
    }

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Prepare the SQL statement using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (name, phone, address, email, password) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $phone, $address, $email, $password);

    // Execute the query and check if insertion was successful
    if ($stmt->execute()) {
        // Registration successful; redirect to signin.html
        header("Location: signin.html");
        exit();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $stmt->error;
    }
    

    // Close the statement and connection
    $stmt->close();
    $conn->close();
    echo json_encode($response);
}
?>
