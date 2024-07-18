<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <button onclick="location.href='add_student.php'">Add Student</button>
        <button onclick="location.href='add_user.php'">Add User</button>
        <button onclick="location.href='report.php'">View Reports</button>
        <button onclick="location.href='view_users.php'">View Users</button>
        <button onclick="location.href='customize_students.php'">Customize Students</button>

    </div>
</body>
</html>
