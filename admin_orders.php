<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            color: white;
            padding: 10px;
        }
        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .navbar li {
            float: left;
        }
        .navbar li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar li a:hover {
            background-color: #111;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .action-buttons a {
            text-decoration: none;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            margin-right: 5px;
            transition: background-color 0.3s;
        }
        .edit-btn {
            background-color: #4CAF50;
        }
        .delete-btn {
            background-color: #f44336;
        }
        .edit-btn:hover, .delete-btn:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="admin.php">DASHBOARD</a></li>
        </ul>
    </div>

    <h1>Admin - Manage Orders</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product ID</th>
                <th>Price</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Establish a connection to the MySQL database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "e com";

            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch orders from the orders table
            $sql = "SELECT * FROM orders";
            $result = $conn->query($sql);

            // Output orders data in table rows
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["product_id"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td>" . $row["order_date"] . "</td>";
                    echo "<td class='action-buttons'>";
                    echo "<a class='edit-btn' href='editorder.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to edit this order?\")'>Edit</a>";
                    echo "<a class='delete-btn' href='deleteorder.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this order?\")'>Delete</a>";                    
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No orders found.</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>
