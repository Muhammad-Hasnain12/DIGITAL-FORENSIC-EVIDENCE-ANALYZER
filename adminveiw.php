<?php  
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminlogin.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forensic_analyzer";

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT users.username, COUNT(evidence.id) as evidence_count FROM users
        LEFT JOIN evidence ON users.id = evidence.user_id
        GROUP BY users.id";
$result = $conn->query($sql);

$usernames = [];
$evidence_counts = [];

while ($row = $result->fetch_assoc()) {
    $usernames[] = $row['username'];
    $evidence_counts[] = $row['evidence_count'];
}

// Fetch evidence types for dynamic chart data
$sql = "SELECT type, COUNT(*) as count FROM evidence GROUP BY type";
$typeResult = $conn->query($sql);

$evidence_types = [];
$evidence_type_counts = [];

while ($row = $typeResult->fetch_assoc()) {
    $evidence_types[] = $row['type'];
    $evidence_type_counts[] = $row['count'];
}

// Fetch evidence descriptions for table display
$sql = "SELECT users.username, evidence.description FROM users LEFT JOIN evidence ON users.id = evidence.user_id";
$tableResult = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Users and Evidence</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            overflow-x: auto;
        }

        /* Container for the whole content */
        .container {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 20px;
            width: 100%;
        }

        h3 {
            text-align: center;
            color: #2980b9;
            font-size: 1.5em;
            margin-bottom: 20px;
            width: 100%;
        }

        /* Chart container */
        .chart-container {
            width: 48%;
            margin: 10px 0;
        }

        canvas {
            width: 100%;
            max-width: 100%;
            margin: 10px auto;
            display: block;
        }

        /* Table Styles */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2980b9;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e0e0e0;
        }

        /* Responsive styles */
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
                align-items: center;
            }

            .chart-container {
                width: 80%;
            }
        }

        /* Scrollable container styles */
        .scrollable-container {
            display: flex;
            overflow-x: scroll;
            justify-content: flex-start;
            align-items: flex-start;
            width: 100%;
            padding-bottom: 20px;
        }

        /* Fancy hover effect */
        .chart-container:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }

    </style>
</head>
<body>

<div class="container">
    <h2>Admin Dashboard</h2>
    
    <!-- Scrollable Container for Charts -->
    <div class="scrollable-container">
        <div class="chart-container">
            <h3>Evidence Count per User</h3>
            <canvas id="evidenceChart" height="200"></canvas>
        </div>

        <div class="chart-container">
            <h3>Evidence Type Distribution</h3>
            <canvas id="evidenceTypeChart" height="200"></canvas>
        </div>

        <div class="chart-container">
            <h3>Evidence Count vs Evidence Type</h3>
            <canvas id="evidenceVsTypeChart" height="200"></canvas>
        </div>
    </div>

    <!-- Table for Users and Evidence -->
    <h3>User Evidence Details</h3>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Evidence Description</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $tableResult->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    // Evidence Count per User Chart
    var ctx = document.getElementById('evidenceChart').getContext('2d');
    var evidenceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($usernames); ?>,  // Dynamic user names from PHP
            datasets: [{
                label: 'Evidence Count',
                data: <?php echo json_encode($evidence_counts); ?>,  // Dynamic evidence count from PHP
                backgroundColor: 'rgba(46, 204, 113, 0.2)',
                borderColor: 'rgba(46, 204, 113, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Evidence Type Distribution
    var evidenceTypeCtx = document.getElementById('evidenceTypeChart').getContext('2d');
    var evidenceTypeChart = new Chart(evidenceTypeCtx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($evidence_types); ?>, // Dynamic evidence types from PHP
            datasets: [{
                data: <?php echo json_encode($evidence_type_counts); ?>, // Dynamic evidence type counts from PHP
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF5733'],
                hoverBackgroundColor: ['#FF4567', '#56A5FF', '#FFDA56', '#3FA0A1', '#FF6F39']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
            }
        }
    });

    // Evidence Count vs Evidence Type Chart
    var evidenceVsTypeCtx = document.getElementById('evidenceVsTypeChart').getContext('2d');
    var evidenceVsTypeChart = new Chart(evidenceVsTypeCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($evidence_types); ?>, // Dynamic evidence types
            datasets: [{
                label: 'Evidence Count by Type',
                data: <?php echo json_encode($evidence_type_counts); ?>, // Dynamic evidence type counts
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF5733'],
                borderColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF5733'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>
