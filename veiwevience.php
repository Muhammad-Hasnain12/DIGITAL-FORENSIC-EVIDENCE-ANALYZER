<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forensic_analyzer";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM evidence";
$result = $conn->query($sql);

echo "<h3>Evidence List:</h3>";
while($row = $result->fetch_assoc()) {
    echo "<div>" . $row['description'] . "</div>";
}

$conn->close();
?>
