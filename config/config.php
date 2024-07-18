<?php
$servername = "localhost";
$db_username = "root"; // Your MySQL username
$db_password = ""; // Your MySQL password
$dbname = "attendance_system"; // Your database name

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
