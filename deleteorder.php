<?php
// Check if order_id is set in the URL
if(isset($_GET['id'])) {
    // Set up database connection
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

    // Fetch order details from the database based on order_id
    $order_id = $_GET['id'];
    
    // Delete order from the database
    $sql = "DELETE FROM orders WHERE id='$order_id'";
    if ($conn->query($sql) === TRUE) {
        // Redirect user to admin_orders.php
        header("Location: admin_orders.php");
        exit();
    } else {
        echo "Error deleting order: " . $conn->error;
    }

    // Close database connection
    $conn->close();
} else {
    // If order_id is not set, redirect the user back to the admin_orders.php page or any other appropriate page
    header("Location: admin_orders.php");
    exit(); // Ensure script execution stops after redirection
}
?>
