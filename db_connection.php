<?php
$servername = "localhost"; // Change to your MySQL server hostname (usually "localhost")
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password (if you have set any)
$database = "e com"; // Change to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>
