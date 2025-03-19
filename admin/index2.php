<?php
// Include database connection
include '../includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <style>
    /* General Body Styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #fffaf5; /* Light pastel pink background */
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh; /* Full-screen height */
    }

    /* Login Container */
    .login-container {
      background-color: #ffe6f0; /* Pastel pink background */
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    /* Heading Style */
    .login-container h2 {
      color: #5a5a5a; /* Neutral grey text */
      margin-bottom: 20px;
    }

    /* Form Label Style */
    label {
      display: block;
      text-align: left;
      margin-bottom: 5px;
      font-size: 14px;
      color: #5a5a5a;
    }

    /* Input Fields Style */
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #d3a4c1; /* Pastel pink border */
      border-radius: 5px;
      box-sizing: border-box;
      font-size: 14px;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      outline: none;
      border-color: #ff99c8; /* Highlighted pastel pink */
      box-shadow: 0 0 5px rgba(255, 153, 200, 0.5);
    }

    /* Login Button Style */
    button[type="submit"] {
      background-color: #ff99c8; /* Bright pastel pink */
      color: white;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #cc6699; /* Darker pastel pink on hover */
    }

    /* Responsive Design */
    @media (max-width: 480px) {
      .login-container {
        padding: 20px;
      }

      input[type="text"],
      input[type="password"] {
        font-size: 13px;
      }

      button[type="submit"] {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Admin Login</h2>
    <form action="../process/admin_login.php" method="POST">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
