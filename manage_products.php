<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
            color: white;
            display: flex;
            justify-content: space-between; /* Align items to the start and end */
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add a subtle shadow for depth */
        }

        .logo {
            margin: 0;
            font-size: 24px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px;
            text-transform: uppercase;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }

        .btn-danger {
            background-color: #f44336;
            color: white;
        }

        .btn:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="icon">
            <h2 class="logo">Product Management</h2>
        </div>

        <div class="menu">
            <ul>
                <li><a href="admin.php">Home</a></li>
                <li><a href="admin_orders.php">Products</a></li>
                
            </ul>
        </div>
    </div>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "e com";

    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle product deletion
    if(isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        $product_id = $_GET['id'];

        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            echo "Product deleted successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Fetch all products
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display products in a table
        echo "<table>";
        echo "<tr><th>ID</th><th>Product Name</th><th>Description</th><th>Price</th><th>Image</th><th>Action</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["id"]."</td>";
            echo "<td>".$row["product_name"]."</td>";
            echo "<td>".$row["description"]."</td>";
            echo "<td>".$row["price"]."</td>";
            echo "<td><img src='".$row["image"]."' height='50'></td>";
            echo "<td><a class='btn btn-primary' href='edit_product.php?id=".$row["id"]."'>Edit</a> <a class='btn btn-danger' href='manage_products.php?action=delete&id=".$row["id"]."'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No products found";
    }

    $conn->close();
    ?>
</body>
</html>
