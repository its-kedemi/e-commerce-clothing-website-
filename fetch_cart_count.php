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

// Query to fetch the count of items in the cart
$sql = "SELECT COUNT(*) AS cart_count FROM cart";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the cart count from the result
    $row = $result->fetch_assoc();
    $cartCount = $row["cart_count"];
    echo $cartCount; // Output the cart count
} else {
    echo "0"; // Output 0 if no items are in the cart
}

// Close the database connection
$conn->close();
?>
