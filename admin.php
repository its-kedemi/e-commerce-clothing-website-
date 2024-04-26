<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - MV&Co.</title>
    <link rel="stylesheet" href="style.css">
    <!-- Include Ionicons library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.3/css/ionicons.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .main {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .menu {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            box-sizing: border-box;
        }

        .logo {
            margin: 0;
            font-size: 24px;
        }

        .menu ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .menu ul li {
            margin-left: 20px;
        }

        .menu ul li:first-child {
            margin-left: 0;
        }

        .menu ul li a {
            color: white;
            text-decoration: none;
        }

        .menu-toggle {
            display: none;
        }

        .menu-toggle-icon {
            display: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .menu ul {
                display: none;
            }

            .menu-toggle {
                display: block;
            }

            .menu-toggle-icon {
                display: block;
            }

            .menu-toggle:checked + .menu ul {
                display: flex;
                flex-direction: column;
                background-color: #333;
                width: 100%;
                text-align: center;
                padding-top: 10px;
            }

            .menu-toggle:checked + .menu ul li {
                width: 100%;
                margin: 10px 0;
            }
        }

        .content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .card {
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
    color: #000; /* Set text color to black */
}

.card h2 {
    margin-bottom: 10px;
    color: #000; /* Set heading color to black */
}

.card p {
    margin: 0;
    color: #000; /* Set paragraph color to black */
}

    </style>
</head>
<body>
    <div class="main">
        <input type="checkbox" id="menu-toggle" class="menu-toggle">
        <div class="menu">
            <h2 class="logo">Admin Panel - MV&Co.</h2>
            <label for="menu-toggle" class="menu-toggle-icon"><ion-icon name="menu-outline"></ion-icon></label>
            <ul>
                <li><a href="admin.php">Dashboard</a></li>
                <li><a href="admin_products.php">Add Products</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="admin_orders.php">Manage Orders</a></li>
                <li><a href="admin_users.php">Add customers</a>
                </li><li><a href="manage_customers.php">Manage Customers</a></li>
                <li><a href="login.php">Logout</a></li>
            </ul>
        </div>
        <div class="content">
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

    // Fetch counts from the database
    $sql_orders = "SELECT COUNT(*) AS order_count FROM orders";
    $result_orders = $conn->query($sql_orders);
    $order_count = ($result_orders->num_rows > 0) ? $result_orders->fetch_assoc()['order_count'] : 0;

    $sql_customers = "SELECT COUNT(*) AS customer_count FROM customers";
    $result_customers = $conn->query($sql_customers);
    $customer_count = ($result_customers->num_rows > 0) ? $result_customers->fetch_assoc()['customer_count'] : 0;

    $sql_products = "SELECT COUNT(*) AS product_count FROM products";
    $result_products = $conn->query($sql_products);
    $product_count = ($result_products->num_rows > 0) ? $result_products->fetch_assoc()['product_count'] : 0;

    // Close database connection
    $conn->close();
    ?>

    <div class="card">
        <h2>Orders</h2>
        <p><?php echo $order_count; ?> orders</p>
    </div>

    <div class="card">
        <h2>Customers</h2>
        <p><?php echo $customer_count; ?> customers</p>
    </div>

    <div class="card">
        <h2>Products</h2>
        <p><?php echo $product_count; ?> products</p>
    </div>
</div>

        </div>
    </div>
</body>
</html>
