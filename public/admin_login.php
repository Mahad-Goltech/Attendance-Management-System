<?php




session_start();
require '../config/config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Debug: Check input values
    echo "Debug - Username: $username, Password: $password<br>";

    // Prepare and bind
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch admin data
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        // Debug: Output the fetched password hash
        echo "Debug - Fetched password hash: " . $admin['password'] . "<br>";
        
        // Verify password
        if (password_verify($password, $admin['password'])) {
            // Debug: Output success message
            echo "Debug - Password verified!<br>";
            // Successful login
            $_SESSION['admin_id'] = $admin['id'];
            header("Location: ../admin_file/admin_dashboard.php");
            exit;
        } else {
            // Debug: Output failure message
            echo "Debug - Password verification failed!<br>";
            $error = "Invalid username or password";
        }
    } else {
        // Debug: Output failure message
        echo "Debug - User not found!<br>";
        $error = "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin_login.css">
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <form method="post" action="admin_login.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <button type="submit" name="submit">Login</button>
        </form>
    </div>
</body>
</html>
