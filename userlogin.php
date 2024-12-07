<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "forensic_analyzer";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        
        // Verify the password using password_verify()
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['user_id'] = $user['id'];
            header("Location: evidenceManagement.php");
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Invalid credentials.');</script>";
        }
    } else {
        // Username not found
        echo "<script>alert('Invalid credentials.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling with background image */
        body {
            font-family: Arial, sans-serif;
            background-image: url('Images/my-image.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 350px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.6s ease-in-out;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #4CAF50;
            outline: none;
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

        /* Animation for the container */
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
    <h2>User Login</h2>

    <!-- Login Form -->
    <form action="userlogin.php" method="POST" onsubmit="return validateForm()">
        <input type="text" name="username" placeholder="Username" id="username" required>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="usersignup.php">Sign up here</a></p>
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
