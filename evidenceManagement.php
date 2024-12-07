<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: userlogin.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forensic_analyzer";

$conn = new mysqli($servername, $username, $password, $dbname);

// Handle evidence deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Fetch file path of the evidence to be deleted
    $deleteQuery = "SELECT file FROM evidence WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->bind_result($filePath);
    $stmt->fetch();
    $stmt->close();

    // Delete evidence record from the database
    $deleteQuery = "DELETE FROM evidence WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    // Delete file from the server if it exists
    if ($filePath && file_exists($filePath)) {
        unlink($filePath);  // Delete the file
    }

    echo "Evidence removed successfully!";
    header("Location: evidenceManagement.php"); // Redirect to refresh the page
    exit();
}

// Handle form submission for new evidence
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and retrieve form inputs
    $evidenceDescription = mysqli_real_escape_string($conn, $_POST['evidence']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $submittedBy = mysqli_real_escape_string($conn, $_POST['submitted_by']);
    $userId = $_SESSION['user_id'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileDestination = 'uploads/' . $fileName;

    // Upload file if present
    if ($fileName) {
        move_uploaded_file($fileTmpName, $fileDestination);
    } else {
        $fileDestination = NULL;
    }

    // Prepare SQL to insert data into evidence table
    $stmt = $conn->prepare("INSERT INTO evidence (description, category, file, user_id, submitted_by) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $evidenceDescription, $category, $fileDestination, $userId, $submittedBy);
    $stmt->execute();
    $stmt->close();

    echo "Evidence added successfully!";
}

// Fetch evidence data
$sql = "SELECT * FROM evidence WHERE user_id = " . $_SESSION['user_id'];
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evidence Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-container {
            margin-bottom: 30px;
        }

        textarea, select, input[type="text"], input[type="file"], button {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .evidence-list {
            margin-top: 20px;
        }

        .evidence-item {
            background-color: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .evidence-item a {
            color: #4CAF50;
            text-decoration: none;
        }

        .evidence-item a:hover {
            text-decoration: underline;
        }

        .delete-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .delete-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Evidence Management</h2>

    <!-- Evidence Form -->
    <div class="form-container">
        <form action="evidenceManagement.php" method="POST" enctype="multipart/form-data">
            <textarea name="evidence" placeholder="Enter evidence description" required></textarea>
            <select name="category" required>
                <option value="">Select Category</option>
                <option value="Incident">Incident</option>
                <option value="Cybercrime">Cybercrime</option>
                <option value="Theft">Theft</option>
                <!-- Add more categories as needed -->
            </select>
            <input type="text" name="submitted_by" placeholder="Submitted By" required>
            <input type="file" name="file">
            <button type="submit">Add Evidence</button>
        </form>
    </div>

    <!-- Display Evidence List -->
    <h3>Your Evidence List:</h3>
    <div class="evidence-list">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="evidence-item">
                <strong>Category:</strong> <?php echo $row['category']; ?><br>
                <strong>Description:</strong> <?php echo $row['description']; ?><br>
                <strong>Submitted By:</strong> <?php echo $row['submitted_by']; ?><br>
                <?php if ($row['file']) { ?>
                    <strong>File:</strong> <a href="<?php echo $row['file']; ?>" target="_blank">View File</a><br>
                <?php } ?>
                <a href="evidenceManagement.php?delete_id=<?php echo $row['id']; ?>" 
                   onclick="return confirm('Are you sure you want to delete this evidence?');">
                   <button class="delete-button">Delete</button>
                </a>
                <hr>
            </div>
        <?php } ?>
    </div>
</div>
<style>
body {
    font-family: Arial, sans-serif;
    background-image: url('Images/my-image.jpg'); /* Path to your background image */
    background-size: cover; /* Makes the image cover the entire screen */
    background-position: center; /* Centers the background image */
    background-repeat: no-repeat; /* Prevents the image from repeating */
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 30px auto;
    background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background for readability */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>


</body>
</html>
