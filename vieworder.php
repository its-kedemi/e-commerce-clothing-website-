<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        h1 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.php">DASHBOARD</a>
    <a href="home.php">STORE</a>
    <a href="vieworder.php">VIEW ORDERS</a>
</div>

<h1>View Orders</h1>

<?php
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

// Prepare SQL query to fetch orders
$sql = "SELECT orders.*, products.product_name 
        FROM orders 
        INNER JOIN products ON orders.product_id = products.id";

// Execute query
$result = $conn->query($sql);

// Check if any orders found
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Product Name</th><th>Price</th><th>Quantity</th><th>Total Price</th><th>Payment Method</th><th>Order Date</th></tr>";
    
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["product_name"] . "</td>";
        echo "<td>KSH" . $row["price"] . "</td>";
        echo "<td>" . $row["quantity"] . "</td>";
        echo "<td>KSH" . $row["total_price"] . "</td>";
        echo "<td>" . $row["payment_method"] . "</td>";
        echo "<td>" . $row["order_date"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No orders found.";
}

// Close database connection
$conn->close();
?>

</body>
</html>
