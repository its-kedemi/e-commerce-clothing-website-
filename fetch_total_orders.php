<?php
// Establish a connection to the MySQL database
$servername = "localhost"; // Change this to your MySQL server hostname
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "e com"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch the total number of orders placed
$sql = "SELECT COUNT(*) AS total_orders FROM orders";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the total number of orders from the result
    $row = $result->fetch_assoc();
    $totalOrders = $row["total_orders"];
    echo $totalOrders; // Output the total number of orders
} else {
    echo "0"; // Output 0 if no orders are placed
}

// Close the database connection
$conn->close();
?>
