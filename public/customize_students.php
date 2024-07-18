<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../config/config.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch all students
$sql = "SELECT * FROM students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Students</title>
    <link rel="stylesheet" href="customize_students.css">
</head>
<body>
    <div class="container">
        <h2>Customize Students</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <!-- <th>Student ID</th> -->
                    <th>Student Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['student_name']) ?></td>
                        
                        <td>
                            <a href="edit_student.php?id=<?= $row['id'] ?>">Edit</a>
                            <a href="delete_student.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
