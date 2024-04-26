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

// Check if customer ID is provided in the URL
if (!isset($_GET['customer_id'])) {
    echo "Customer ID not provided";
    exit();
}

$customer_id = $_GET['customer_id'];

// Function to retrieve customer details by ID
function getCustomerDetails($conn, $customer_id) {
    $sql = "SELECT * FROM customers WHERE id = $customer_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

// Function to update customer details
function updateCustomerDetails($conn, $customer_id, $customer_name, $phone_number, $email, $address) {
    $sql = "UPDATE customers SET customer_name='$customer_name', phone_number='$phone_number', email='$email', address='$address' WHERE id=$customer_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_users.php");
        exit();
    } else {
        echo "Error updating customer details: " . $conn->error;
    }
}

// Function to delete customer
function deleteCustomer($conn, $customer_id) {
    $sql = "DELETE FROM customers WHERE id=$customer_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_users.php");
        exit();
    } else {
        echo "Error deleting customer: " . $conn->error;
    }
}

// Handle form submission for updating customer details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_customer"])) {
    $customer_name = $_POST["customer_name"];
    $phone_number = $_POST["phone_number"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    updateCustomerDetails($conn, $customer_id, $customer_name, $phone_number, $email, $address);
}

// Handle form submission for deleting a customer
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_customer"])) {
    deleteCustomer($conn, $customer_id);
}

// Retrieve customer details
$customer_details = getCustomerDetails($conn, $customer_id);

// Check if customer exists
if (!$customer_details) {
    echo "Customer not found";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
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
            margin-right: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .delete-button {
            background-color: #f44336;
        }

        .delete-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
<h2>Edit Customer</h2>

<form method="post">
    <label for="customer_name">Customer Name:</label><br>
    <input type="text" id="customer_name" name="customer_name" value="<?php echo $customer_details['customer_name']; ?>" required><br><br>
    <label for="phone_number">Phone Number:</label><br>
    <input type="text" id="phone_number" name="phone_number" value="<?php echo $customer_details['phone_number']; ?>" required><br><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?php echo $customer_details['email']; ?>" required><br><br>
    <label for="address">Address:</label><br>
    <textarea id="address" name="address" required><?php echo $customer_details['address']; ?></textarea><br><br>
    <input type="submit" name="update_customer" value="Update Customer">
    <input type="submit" name="delete_customer" value="Delete Customer" class="delete-button">
</form>

</body>
</html>
