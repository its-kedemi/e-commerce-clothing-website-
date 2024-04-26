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

// Fetch the data from the POST request
$product_name = $_POST["product_name"];
$description = $_POST["description"];
$price = $_POST["price"];
$image = $_POST["image"];

// Insert into the cart table
$sql = "INSERT INTO cart (product_name, description, price, image) VALUES ('$product_name', '$description', '$price', '$image')";
if ($conn->query($sql) === TRUE) {
    // Close the database connection
    $conn->close();

    // JavaScript code to display notification and redirect
    echo "<script>";
    echo "alert('Item added to cart successfully!');";
    echo "window.location.href = 'home.php';";
    echo "</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
