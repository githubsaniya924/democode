<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background-color: #343a40;
        }

        .navbar-brand, .nav-link {
            color: #fff !important;
        }

        .nav-link:hover {
            text-decoration: underline;
        }

        .container {
            margin-top: 20px;
        }

        .dashboard-heading {
            margin: 20px 0;
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .icon {
            font-size: 2.5rem;
            color: #6c63ff;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-custom {
            background-color: #6c63ff;
            color: white;
        }

        .btn-custom:hover {
            background-color: #4c46c4;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">HR Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Employee Performance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Survey Forms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Announcements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Workshops</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Heading -->
    <div class="container">
        <h2 class="dashboard-heading">HR Manager Dashboard</h2>

        <!-- Employee ID Form -->
        <div class="form-container mb-4">
            <h4>Check Employee Performance</h4>
            <form method="POST" action="InsertEmp_Data.php">
                <div class="mb-3">
                    <label for="employeeId" class="form-label">Employee ID</label>
                    <input type="text" class="form-control" id="employeeId" name="employeeId" placeholder="Enter Employee ID" required>
                </div>
                <button type="submit" class="btn btn-custom">Check Performance</button>
            </form>
        </div>

        <!-- HR Options -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <i class="icon bi bi-upload"></i>
                    <h5 class="card-title mt-2">Upload Survey Forms</h5>
                    <p class="card-text">Upload employee surveys to evaluate performance.</p>
                    <button class="btn btn-custom" onclick="uploadSurvey()">Upload</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <i class="icon bi bi-megaphone"></i>
                    <h5 class="card-title mt-2">Post Announcements</h5>
                    <p class="card-text">Share updates or new policies with employees.</p>
                    <button class="btn btn-custom" onclick="postAnnouncement()">Post</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center p-3">
                    <i class="icon bi bi-calendar-event"></i>
                    <h5 class="card-title mt-2">Workshops & Training</h5>
                    <p class="card-text">Manage and update training programs.</p>
                    <button class="btn btn-custom" onclick="updateWorkshops()">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function uploadSurvey() {
            alert("Redirecting to the survey upload page...");
            window.location.href = "upload_survey.php"; // Example redirection
        }

        function postAnnouncement() {
            alert("Redirecting to the announcements page...");
            window.location.href = "post_announcement.php"; // Example redirection
        }

        function updateWorkshops() {
            alert("Redirecting to the workshops management page...");
            window.location.href = "workshop_update.php"; // Example redirection
        }
    </script>
</body>
</html>
