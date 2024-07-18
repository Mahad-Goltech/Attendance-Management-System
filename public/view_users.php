
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../config/config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link rel="stylesheet" href="view_users.css">
</head>
<body>
    <div class="container">
        <h2>View Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Subject</th>
                    <th>Shift</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['subject'] ?></td>
                        <td><?= $row['shift'] ?></td>
                        <td><?= $row['semester'] ?></td>
                        <td>
                            <a href="edit_user.php?id=<?= $row['id'] ?>">Edit</a>
                            <a href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>

