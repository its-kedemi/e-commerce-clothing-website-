<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        form {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Edit Order</h1>
    <form action="updateorder.php" method="POST">
        <?php
        // Fetch order details from the database based on order_id
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

            $id = $_GET['id'];
            $sql = "SELECT * FROM orders WHERE id='$id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Display form to edit order details
                echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                echo "<label for='product_id'>Product ID:</label><br>";
                echo "<input type='text' id='product_id' name='product_id' value='" . $row['product_id'] . "'><br>";
                echo "<label for='price'>Price:</label><br>";
                echo "<input type='text' id='price' name='price' value='" . $row['price'] . "'><br>";
                echo "<label for='order_date'>Order Date:</label><br>";
                echo "<input type='text' id='order_date' name='order_date' value='" . $row['order_date'] . "'><br>";
                echo "<input type='submit' value='Update'>";
            } else {
                echo "Order not found.";
            }

            // Close database connection
            $conn->close();
        } else {
            // If order_id is not set, redirect the user back to the admin_orders.php page or any other appropriate page
            header("Location: admin_orders.php");
            exit(); // Ensure script execution stops after redirection
        }
        ?>
    </form>
</body>
</html>
