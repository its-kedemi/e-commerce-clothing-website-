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

// Handle form submission for adding a new customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_customer"])) {
    $customer_name = $_POST["customer_name"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    $sql = "INSERT INTO customers (customer_name, phone_number, email, address)
            VALUES (?, ?, ?, ?)"; // Using prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $customer_name, $phone_number, $email, $address);
    
    if ($stmt->execute()) {
        echo "New customer added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
            cursor: pointer;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar a.active {
            background-color: #4CAF50;
            color: white;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
<div class="navbar">
    <a href="admin.php">DASHBOARD</a>
</div>

<h2>Add Customers</h2>

<!-- Form for adding a new customer -->
<form method="post">
    <label for="customer_name">Customer Name:</label><br>
    <input type="text" id="customer_name" name="customer_name" required><br><br>
    <label for="phone_number">Phone Number:</label><br>
    <input type="text" id="phone_number" name="phone_number" required><br><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    <label for="address">Address:</label><br>
    <textarea id="address" name="address" required></textarea><br><br>
    <input type="submit" name="add_customer" value="Add Customer">
</form>

</body>
</html>
<?php
$conn->close();
?>
