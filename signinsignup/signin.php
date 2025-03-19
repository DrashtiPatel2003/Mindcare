<?php
session_start(); // Start the session at the beginning of the script

include '../includes/db_connect.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize user input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        // Prepare the SQL statement to prevent SQL injection
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch user data
            $row = $result->fetch_assoc();

            // Verify the entered password against the hashed password in the database
            if (password_verify($password, $row['password'])) {
                // Set session variables after successful login
                $_SESSION['email'] = $email;
                $_SESSION['user_id'] = $row['id']; // Optional: store user ID in session

                // Redirect to index.php after successful login
                header("Location: ../index.php");
                exit(); // Always call exit after header to stop further script execution
            } else {
                echo "Incorrect password! Please try again.";
            }
        } else {
            echo "User not found! Please check your email.";
        }

        $stmt->close();
    } else {
        echo "Email or password cannot be empty.";
    }
} else {
    echo "Invalid request method.";
}

$conn->close();


?>