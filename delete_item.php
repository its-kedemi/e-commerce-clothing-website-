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

// Check if item ID is set and not empty
if(isset($_POST['item_id']) && !empty($_POST['item_id'])) {
    // Sanitize item ID to prevent SQL injection
    $item_id = $conn->real_escape_string($_POST['item_id']);

    // Prepare SQL statement to delete item from cart
    $sql = "DELETE FROM cart WHERE id = '$item_id'";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        // Item deleted successfully
        $conn->close();
        header("Location: cart.php"); // Redirect to home.php
        exit();
    } else {
        // Error deleting item
        echo "Error: " . $conn->error;
    }
} else {
    // Item ID not provided or empty
    echo "Invalid item ID.";
}

// Close the database connection
$conn->close();
?>
