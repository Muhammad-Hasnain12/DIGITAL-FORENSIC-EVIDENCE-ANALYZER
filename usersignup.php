<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forensic_analyzer";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate the form data
    $userUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $userPassword = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password for security
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

    // Insert query
    $sql = "INSERT INTO users (username, password) VALUES ('$userUsername', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        $successMessage = "New user created successfully.";
    } else {
        $errorMessage = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('Images/my-image.jpg'); /* Add the path to your image here */
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 400px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1.2rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }

        .success-message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Optional animation for container */
        .container {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Sign Up</h2>

    <?php
    // Display success or error messages
    if ($successMessage != "") {
        echo "<p class='success-message'>$successMessage</p>";
    }
    if ($errorMessage != "") {
        echo "<p class='error-message'>$errorMessage</p>";
    }
    ?>

    <!-- Signup Form -->
    <form action="usersignup.php" method="POST" onsubmit="return validateForm()">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit">Sign Up</button>
    </form>

    <br>
    <p>Already have an account? <a href="userlogin.php">Login here</a></p>
</div>

<script>
    // JavaScript for form validation
    function validateForm() {
        let username = document.getElementById('username').value;
        let password = document.getElementById('password').value;
        
        if (username == "" || password == "") {
            alert("Please fill in both fields.");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
