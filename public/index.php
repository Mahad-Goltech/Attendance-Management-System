<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $date = date('Y-m-d');

    foreach ($_POST['attendance'] as $student_id => $status) {
        $sql = "INSERT INTO attendance (student_id, user_id, date, status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $student_id, $user_id, $date, $status);

        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit;
        }
    }

    echo "Attendance record added successfully.";
}

$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>PSU Student Attendance</h2>
        <form method="post" action="index.php">
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['student_id'] ?></td>
                            <td><?= $row['student_name'] ?></td>
                            <td>
                                <label>
                                    <input type="radio" name="attendance[<?= $row['id'] ?>]" value="present" checked> Present
                                </label>
                                <label>
                                    <input type="radio" name="attendance[<?= $row['id'] ?>]" value="absent"> Absent
                                </label>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit">Submit Attendance</button>
        </form>
        <br>
        <button onclick="location.href='report.php'">View Reports</button>
    </div>
</body>
</html>
