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
} else {
    // Connection is successful
    // echo "Connected successfully to the database"; // For testing
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $employee_id = $_POST['employeeId'];  // Change this from 'empno' to 'employeeId'
    $password = $_POST['password'];  // This is fine as is

    // Sanitize the input data to prevent SQL injection
    $employee_id = $conn->real_escape_string($employee_id);
    $password = $conn->real_escape_string($password);

    // Check if employee_id is within the valid range
    if ($employee_id > 3000 && $employee_id < 4000) {
        // Query the database for the employee ID, with the range check
        $sql = "SELECT * FROM employee WHERE empno = '$employee_id'";
        $result = $conn->query($sql);

        // Check if the query returned a result
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc(); // Fetch the employee data

            //Verify the password
            if ($password === $user['password']) {
                // Successful login
                //echo "Login successful!";
                // You can redirect or set session variables here
                // header('Location: dashboard.php');
            } else {
                // Invalid password
                echo "Invalid Employee ID or Password.";
            }
            
        } else {
            // Employee not found
            echo "Invalid Employee ID or Password.";
        }
    } else {
        echo "Employee ID must be between 1000 and 3000.";
    }
}

// Close connection
$conn->close();
?>
