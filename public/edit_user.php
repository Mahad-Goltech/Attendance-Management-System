
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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $subject = $_POST['subject'];
    $shift = $_POST['shift'];
    $semester = $_POST['semester'];

    $sql = "UPDATE users SET username = ?, subject = ?, shift = ?, semester = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $subject, $shift, $semester, $id);

    if ($stmt->execute()) {
        header("Location: view_users.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <form method="post" action="edit_user.php">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?= $user['username'] ?>" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" value="<?= $user['subject'] ?>" required>
            </div>
            <div class="form-group">
                <label for="shift">Shift:</label>
                <select id="shift" name="shift" required>
                    <option value="morning" <?= $user['shift'] == 'morning' ? 'selected' : '' ?>>Morning</option>
                    <option value="afternoon" <?= $user['shift'] == 'afternoon' ? 'selected' : '' ?>>Afternoon</option>
                    <option value="evening" <?= $user['shift'] == 'evening' ? 'selected' : '' ?>>Evening</option>
                </select>
            </div>
            <div class="form-group">
                <label for="semester">Semester:</label>
                <input type="text" id="semester" name="semester" value="<?= $user['semester'] ?>" required>
            </div>
            <button type="submit">Update User</button>
        </form>
    </div>
</body>
</html>
