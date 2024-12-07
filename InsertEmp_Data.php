<?php
// Database credentials
$host = "localhost";
$dbname = "EmployeeData";
$username = "root";
$password = "";

// Create connection using mysqli
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message variable
$message = "";
$employee = null;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if employee ID is provided
    if (isset($_POST['employeeId'])) {
        $employeeId = $_POST['employeeId'];

        // Query to fetch employee details based on employeeId
        $query = "SELECT * FROM employee WHERE empno = '$employeeId'";
        $result = mysqli_query($conn, $query);
        
        // Check if the employee exists
        if (mysqli_num_rows($result) > 0) {
            // Employee exists, fetch the details
            $employee = mysqli_fetch_assoc($result);

            // Check if performance and task completion are submitted
            if (isset($_POST['performanceCredits']) && isset($_POST['tasksCompleted'])) {
                $performanceCredits = $_POST['performanceCredits'];
                $tasksCompleted = $_POST['tasksCompleted'];

                // Update employee performance and task completion in the database
                $updateQuery = "UPDATE employee SET performance_credits = '$performanceCredits', tasks_completed = '$tasksCompleted' WHERE empno = '$employeeId'";
                if (mysqli_query($conn, $updateQuery)) {
                    $message = "Employee performance updated successfully!";
                } else {
                    $message = "Error updating employee performance: " . mysqli_error($conn);
                }
            }
        } else {
            // Employee not found
            $message = "Employee ID not found. Please check the ID and try again.";
        }
    } else {
        $message = "Employee ID is required.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Performance Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #6c63ff;
            color: white;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">HR Dashboard</a>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Employee Performance Details</h2>

    <!-- Display success or error message -->
    <?php if (!empty($message)) { ?>
        <div class="alert alert-info">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <!-- Employee Details Form -->
    <form method="POST" action="">

        <!-- Display Employee ID Input if Employee not found yet -->
        <?php if (!$employee) { ?>
            <div class="mb-3">
                <label for="employeeId" class="form-label">Employee ID</label>
                <input type="text" class="form-control" id="employeeId" name="employeeId" required><br>
                <button type="submit" class="btn btn-custom">Check</button>
            </div>
        <?php } ?>

        <!-- Display employee details if found -->
        <?php if ($employee) { ?>
            <!--<div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Employee: <?php echo $employee['name']; ?></h5>
                    <p><strong>Designation:</strong> <?php echo $employee['designation']; ?></p>
                    <p><strong>Department:</strong> <?php echo $employee['department']; ?></p>
                </div>
            </div>-->

            <!-- Form to update performance and task completion -->
            <div class="mb-3">
                <label for="performanceCredits" class="form-label">Performance Credits</label>
                <input type="number" class="form-control" id="performanceCredits" name="performanceCredits" required>
            </div>
            <div class="mb-3">
                <label for="tasksCompleted" class="form-label">Tasks Completed</label>
                <input type="number" class="form-control" id="tasksCompleted" name="tasksCompleted" required>
            </div>
            <button type="submit" class="btn btn-custom">Update Performance</button>
        <?php } ?>

    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
