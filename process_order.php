<?php
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

    // Prepare data for insertion
    $product_id = $_POST['product_id'];
    $order_date = date("Y-m-d H:i:s"); // Current date and time
    $payment_method = $_POST['payment_method'];
    $quantity = $_POST['quantity'];

    // Fetch price from the database based on the product_id
    $sql_price = "SELECT price FROM products WHERE id='$product_id'";
    $result_price = $conn->query($sql_price);
    if ($result_price->num_rows > 0) {
        $row_price = $result_price->fetch_assoc();
        $price = $row_price['price'];
        $total_price = $price * $quantity;

        // Insert order into database
        $sql = "INSERT INTO orders (product_id, price, quantity, total_price, payment_method, order_date) VALUES ('$product_id', '$price', '$quantity', '$total_price', '$payment_method', '$order_date')";
        if ($conn->query($sql) === TRUE) {
            // Redirect user to home.php
            header("Location: home.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No price found for the product.";
    }

    // Close database connection
    $conn->close();
} else {
    // If accessed directly without submitting the form, redirect the user back to the home page
    header("Location: index.php");
    exit(); // Ensure script execution stops after redirection
}
?>
