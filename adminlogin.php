<?php
session_start(); // Start session to check logged in status or redirect

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forensic_analyzer";

// Establish connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminUsername = $_POST['username'];
    $adminPassword = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
    $stmt->bind_param("ss", $adminUsername, $adminPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if credentials match
    if ($result->num_rows > 0) {
        $_SESSION['admin'] = true; // Set session variable
        header("Location: adminveiw.php"); // Redirect to admin dashboard
        exit();
    } else {
        $errorMessage = "Invalid credentials."; // Error message
    }

    $stmt->close(); // Close the statement
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('Images/my-image.jpg'); /* Background Image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        /* Login Wrapper */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        /* Container for the form */
        .login-container {
            background-color: rgba(0, 0, 0, 0.6); /* Dark background with transparency */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        /* Animation for container */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Logo/Icon */
        .login-icon {
            width: 80px;
            margin-bottom: 20px;
        }

        /* Header */
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #fff;
        }

        /* Form Inputs */
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background-color: rgba(255, 255, 255, 0.7);
            color: #333;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #4CAF50;
            background-color: #fff;
        }

        /* Button Styling */
        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        /* Error message */
        .error-msg {
            color: red;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-container">
            <img src="Images/my-image.jpg" alt="Admin Icon" class="login-icon">
            <h2>Admin Login</h2>

            <?php
                if (isset($errorMessage)) {
                    echo "<p class='error-msg'>$errorMessage</p>";
                }
            ?>

            <form method="POST" action="adminlogin.php">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

</body>
</html>
