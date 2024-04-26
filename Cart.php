<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - MV&Co.</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
        }

        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            margin: 0;
            font-size: 24px;
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        .content {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .cart-items {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .cart-item {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cart-item img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .cart-item h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .cart-item p {
            margin: 5px 0;
        }

        .cart-item p.price {
            font-weight: bold;
        }

        .empty-cart {
            text-align: center;
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
    <header>
        <h1 class="logo">MV&Co.</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cart.php">Cart</a></li>
                <!-- Add more menu items as needed -->
            </ul>
        </nav>
    </header>

    <div class="content">
        <h2>Your Cart</h2>
        <div class="cart-items">
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

// Fetch items from the cart table
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Output HTML for each item
        echo "<div class='cart-item'>";
        echo "<img src='" . $row["image"] . "' alt='" . $row["description"] . "'>";
        echo "<h3>" . $row["product_name"] . "</h3>";
        echo "<p>Description: " . $row["description"] . "</p>";
        echo "<p class='price'>Price: Ksh" . $row["price"] . "</p>";
        // Add delete button
        echo "<form method='post' action='delete_item.php'>";
        echo "<input type='hidden' name='item_id' value='" . $row["id"] . "'>";
        echo "<button type='submit'>Delete</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "<p class='empty-cart'>Your cart is empty.</p>";
}

// Close the database connection
$conn->close();
?>

