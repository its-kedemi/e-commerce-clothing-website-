<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "e com"; // Corrected the database name

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to display customer details for editing
function displayCustomerDetailsForEditing($customer_id) {
    echo '<form method="post">';
    echo '<input type="hidden" name="customer_id" value="'.$customer_id.'">';
    echo '<input type="submit" name="edit_customer" value="Edit">';
    echo '</form>';
}

// Handle form submission for editing a customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_customer"])) {
    $customer_id = $_POST["customer_id"];
    // Redirect to the customer editing page with the customer ID
    header("Location: edit_customer.php?customer_id=$customer_id");
    exit();
}

// Handle form submission for deleting a customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_customer"])) {
    $customer_id = $_POST["customer_id"];
    // Delete the customer from the database
    $sql = "DELETE FROM customers WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customer_id);
    
    if ($stmt->execute()) {
        echo "Customer deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Manage Customers</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #4CAF50;
            overflow: hidden;
            font-size: 1.2em;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            cursor: pointer;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar a.active {
            background-color: #3e8e41;
            color: white;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            color: #4CAF50;
        }

        table {
            width: 90%; /* Reduced width */
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Reduced box shadow */
        }

        th,
        td {
            padding: 6px; /* Reduced padding */
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 0.9em; /* Reduced font size */
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
        }

        input[name="edit_customer"],
        input[name="delete_customer"] {
            padding: 4px 8px; /* Reduced padding */
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 0.8em; /* Reduced font size */
        }

        input[name="edit_customer"] {
            background-color: #4CAF50;
            color: white;
        }

        input[name="delete_customer"] {
            background-color: #f44336;
            color: white;
        }

        input[name="edit_customer"]:hover {
            background-color: #45a049;
        }

        input[name="delete_customer"]:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="admin.php">DASHBOARD</a>
</div>

<table>
    <thead>
    <tr>
        <th>Customer ID</th>
        <th>Customer Name</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Address</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Ensure $conn is defined and not null
    if ($conn) {
        // Retrieve customers from the database and display them
        $sql = "SELECT * FROM customers";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["customer_name"] . "</td>";
                echo "<td>" . $row["phone_number"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["address"] . "</td>";
                echo "<td class='action-buttons'>";
                displayCustomerDetailsForEditing($row["id"]);
                echo '<form method="post">';
                echo '<input type="hidden" name="customer_id" value="'.$row["id"].'">';
                echo '<input type="submit" name="delete_customer" value="Delete">';
                echo '</form>';
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No customers found.</td></tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Database connection failed.</td></tr>";
    }
    ?>
    </tbody>
</table>

</body>
</html>

<?php
$conn->close();
?>
