<?php
// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Prepare data for update
    $order_id = $_POST['id'];
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    $order_date = $_POST['order_date'];

    // Update order in the database
    $sql = "UPDATE orders SET product_id='$product_id', price='$price', order_date='$order_date' WHERE id='$order_id'";
    if ($conn->query($sql) === TRUE) {
        // Redirect user to admin_orders.php
        header("Location: admin_orders.php");
        exit();
    } else {
        echo "Error updating order: " . $conn->error;
    }

    // Close database connection
    $conn->close();
} else {
    // If form data is not submitted via POST method, redirect the user back to the editorder.php page or any other appropriate page
    header("Location: editorder.php");
    exit(); // Ensure script execution stops after redirection
}
?>
