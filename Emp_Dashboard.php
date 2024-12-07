<?php
include 'Emp_Connection.php';
session_start(); // Start a session for login tracking

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['employeeId']) && isset($_POST['password'])) {
        $employee_id = $_POST['employeeId'];
        $password = $_POST['password'];

        // Sanitize inputs
        $employee_id = $conn->real_escape_string($employee_id);
        $password = $conn->real_escape_string($password);

        if ($employee_id >= 1000 && $employee_id <= 3000) {
            $sql = "SELECT * FROM employee WHERE empno = '$employee_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if ($password === $user['password']) {
                    $_SESSION['logged_in'] = true; // Set session variable
                    $_SESSION['employee_name'] = $user['name']; // Optional: Store user details
                } else {
                    echo "<script>alert('Invalid Employee ID or Password.'); window.location.href = 'login.php';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Invalid Employee ID or Password.'); window.location.href = 'login.php';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Employee ID must be between 1000 and 3000.'); window.location.href = 'login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Employee ID and Password are required.'); window.location.href = 'login.php';</script>";
        exit;
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Performance Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        .navbar {
            background-color: #1a202c;
            padding: 15px 20px;
        }

        .navbar-brand,
        .nav-link {
            color: #f8f9fa !important;
            font-weight: 500;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        /* Header Section */
        .dashboard-header {
            text-align: center;
            margin: 30px 0;
            color: #1a202c;
        }

        .dashboard-header h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        .dashboard-header p {
            color: #495057;
        }

        /* Employee Details */
        .employee-card {
            background: #007bff;
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Icon Styling */
        .icon {
            font-size: 2rem;
            margin-bottom: 15px;
            color: #ffc107;
        }

        /* Cards Section */
        .card {
            border-radius: 15px;
            padding: 20px;
            background: white;
            border: 1px solid #dee2e6;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: #1a202c;
        }

        /* Chart Styling */
        canvas {
            max-height: 180px;
        }

        /* Footer */
        footer {
            background-color: #1a202c;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-chart-line"></i> Performance Tracker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-file-alt"></i> Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <div class="dashboard-header">
        <h1><i class="fas fa-user-circle"></i> Welcome, John Doe!</h1>
        <p>Your performance overview</p>
    </div>

    <!-- Employee Details -->
    <div class="container">
        <div class="employee-card">
            <h4>Employee Details</h4>
            <p><strong>ID:</strong> 1234 | <strong>Role:</strong> Software Engineer</p>
            <p><strong>Department:</strong> IT | <strong>Team:</strong> Development</p>
        </div>

        <!-- Performance Metrics -->
        <div class="row">
            <!-- Pie Chart -->
            <div class="col-md-6 mb-4">
                <div class="card text-center">
                    <div class="card-header"><i class="fas fa-chart-pie"></i> Overall Performance</div>
                    <canvas id="performancePieChart"></canvas>
                </div>
            </div>

            <!-- Bar Chart -->
            <div class="col-md-6 mb-4">
                <div class="card text-center">
                    <div class="card-header"><i class="fas fa-tasks"></i> Task Completion</div>
                    <canvas id="taskBarChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Additional Details -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card text-center">
                    <div class="card-header"><i class="fas fa-clock"></i> Recent Activities</div>
                    <ul>
                        <li>Completed Project A successfully</li>
                        <li>Attended a training session</li>
                        <li>Achieved Q4 target</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card text-center">
                    <div class="card-header"><i class="fas fa-calendar-alt"></i> Upcoming Deadlines</div>
                    <ul>
                        <li>Client meeting: Dec 12</li>
                        <li>Submit report: Dec 15</li>
                        <li>Team training: Dec 20</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 Employee Performance Tracker. All Rights Reserved.
    </footer>

    <!-- Charts -->
    <script>
        // Pie Chart for Overall Performance
        const performancePieCtx = document.getElementById('performancePieChart').getContext('2d');
        new Chart(performancePieCtx, {
            type: 'pie',
            data: {
                labels: ['Achieved', 'Remaining'],
                datasets: [{
                    data: [85, 15],
                    backgroundColor: ['#007bff', '#dee2e6']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Bar Chart for Task Completion
        const taskBarCtx = document.getElementById('taskBarChart').getContext('2d');
        new Chart(taskBarCtx, {
            type: 'bar',
            data: {
                labels: ['Completed', 'Pending'],
                datasets: [{
                    label: 'Tasks',
                    data: [20, 5],
                    backgroundColor: ['#007bff', '#dee2e6']
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
