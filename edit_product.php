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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        form {
            display: inline-block;
        }

        input[type="number"] {
            width: 70px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        img {
            max-width: 50px;
            max-height: 50px;
        }

        h2 {
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        input[type="number"] {
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
    </style>
</head>
<body>
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

    // Handle product update
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $product_id = $_POST['product_id'];
        $price = $_POST['price'];

        $sql = "UPDATE products SET price = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $price, $product_id);

        if ($stmt->execute()) {
            echo "Product price updated successfully";
            // Redirect to manage products page after updating
            header("Location: manage_products.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Fetch individual product if ID is provided
    if(isset($_GET['id'])) {
        $product_id = $_GET['id'];
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Display product details in a form
            $row = $result->fetch_assoc();
            echo "<h2>Edit Product</h2>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='product_id' value='".$row["id"]."'>";
            echo "<label for='product_name'>Product Name:</label><br>";
            echo "<input type='text' name='product_name' value='".$row["product_name"]."' disabled><br><br>";
            echo "<label for='description'>Description:</label><br>";
            echo "<textarea name='description' disabled>".$row["description"]."</textarea><br><br>";
            echo "<label for='price'>Price:</label><br>";
            echo "<input type='number' name='price' value='".$row["price"]."' required><br><br>";
            echo "<input type='submit' name='update' value='Update'>";
            echo "</form>";
        } else {
            echo "Product not found";
        }

        $stmt->close();
    } else {
        echo "No product ID provided";
    }

    $conn->close();
    ?>
</body>
</html>
