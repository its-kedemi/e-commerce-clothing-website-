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

// Check if product ID is set and not empty
if(isset($_POST['product_id']) && !empty($_POST['product_id'])) {
    // Sanitize product ID to prevent SQL injection
    $product_id = $conn->real_escape_string($_POST['product_id']);

    // Prepare SQL statement to delete product from the database
    $sql = "DELETE FROM products WHERE id = '$id'";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Product deleted successfully
        header("Location: manage_products.php"); // Redirect back to manage_products.php
        exit();
    } else {
        // Error deleting product
        echo "Error: " . $conn->error;
    }
} else {
    // Product ID not provided or empty
    echo "Invalid product ID.";
}

// Close the database connection
$conn->close();
?>
