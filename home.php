<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - MV&Co.</title>
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

        .navbar {
            background-color: #333;
            color: white;
            display: flex;
            justify-content: space-between; /* Align items to the start and end */
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle shadow for depth */
        }

        .menu ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .menu ul li {
            display: inline;
            margin-right: 20px;
        }

        .menu ul li a {
            color: white;
            text-decoration: none;
        }

        .content {
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .product-item {
            width: 300px;
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .product-item img {
            max-width: 100%;
            height: 200px; /* Set a fixed height for all images */
            object-fit: cover; /* Ensure the aspect ratio is maintained */
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .product-item h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .product-item p {
            margin: 5px 0;
        }

        .buy-button {
            background-color: #008CBA;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
        }

        .buy-button:hover {
            background-color: #005f80;
        }

        .cart-icon {
            margin-right: 5px;
        }

        .add-to-cart-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            text-decoration: none;
            display: inline-block;
        }

        .add-to-cart-button:hover {
            background-color: #388e3c;
        }

        /* Notification styles */
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            display: none; /* Initially hide the notification */
            z-index: 999; /* Ensure it's above other elements */
        }

        .cart-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .cart-button:hover {
            background-color: #388e3c;
        }
    </style>
    
</head>
<body>
    <div class="navbar">
        <div class="icon">
            <h2 class="logo">MV&Co.</h2>
        </div>

        <div class="menu">
            <ul>
                <li><a href="index.php">DASHBOARD</a></li>
            </ul>
        </div>
    </div> 

    <div class="content">
        <div class="products">
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

            // Fetch items from the orders table
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);

            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    // Output HTML for each item
                    echo "<div class='product-item'>";
                    echo "<img src='" . $row["image"] . "' alt='" . $row["description"] . "'>";
                    echo "<h2>" . $row["product_name"] . "</h2>";
                    echo "<h2>" . $row["description"] . "</h2>";
                    echo "<p>Price: Ksh" . $row["price"] . "</p>";
                    echo "<a href='placeorder.php?product_id=" . $row["id"] . "' class='buy-button'>Buy Now</a>";
                    // Form with hidden fields for product data
                    echo "<form method='post' action='add_to_cart.php'>";
                    echo "<input type='hidden' name='product_name' value='" . $row["product_name"] . "'>";
                    echo "<input type='hidden' name='description' value='" . $row["description"] . "'>";
                    echo "<input type='hidden' name='price' value='" . $row["price"] . "'>";
                    echo "<input type='hidden' name='image' value='" . $row["image"] . "'>";
                    echo "<button type='submit' class='add-to-cart-button'><i class='fas fa-cart-plus cart-icon'></i> Add to Cart</button>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "No items found in the database.";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>

    <div class="content">
        <a href="cart.php" class="cart-button">View Cart</a>
    </div>

    <div class="notification" id="notification">Item added to cart successfully!</div>

    <!-- Your JavaScript code -->
    <script>
        // JavaScript function to add item to cart
        function addToCart(productName, description, price, image) {
            // Send AJAX request to add item to cart
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("notification").style.display = "block";
                    setTimeout(function(){ 
                        document.getElementById("notification").style.display = "none";
                    }, 3000); // Hide notification after 3 seconds
                }
            };
            xhttp.open("POST", "add_to_cart.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("product_name=" + productName + "&description=" + description + "&price=" + price + "&image=" + image);
        }
    </script>
</body>
</html>
