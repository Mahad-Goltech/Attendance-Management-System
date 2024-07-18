<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../config/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Function to get student attendance report
function getStudentReport($conn) {
    $sql = "SELECT students.student_id, students.student_name, 
                   SUM(attendance.status = 'present') AS presents,
                   SUM(attendance.status = 'absent') AS absents
            FROM students
            LEFT JOIN attendance ON students.id = attendance.student_id
            GROUP BY students.id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Student Attendance Report</h2>";
        echo "<table>";
        echo "<tr><th>Student ID</th><th>Student Name</th><th>Presents</th><th>Absents</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['student_id']}</td>
                    <td>{$row['student_name']}</td>
                    <td>{$row['presents']}</td>
                    <td>{$row['absents']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No data found.";
    }
}

// Function to get total subject absents and presents
function getSubjectReport($conn) {
    $sql = "SELECT users.subject,
                   SUM(attendance.status = 'present') AS presents,
                   SUM(attendance.status = 'absent') AS absents
            FROM users
            LEFT JOIN attendance ON users.id = attendance.user_id
            GROUP BY users.subject";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Subject Attendance Report</h2>";
        echo "<table>";
        echo "<tr><th>Subject</th><th>Presents</th><th>Absents</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['subject']}</td>
                    <td>{$row['presents']}</td>
                    <td>{$row['absents']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No data found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Attendance Report</h1>
        <button onclick="location.href='?report=student'">Student Report</button>
        <button onclick="location.href='?report=subject'">Subject Report</button>
        <button onclick="location.href='index.php'">back to index</button>

        <?php
        if (isset($_GET['report'])) {
            if ($_GET['report'] == 'student') {
                getStudentReport($conn);
            } elseif ($_GET['report'] == 'subject') {
                getSubjectReport($conn);
            }
        }
        ?>
    </div>
</body>
</html>
