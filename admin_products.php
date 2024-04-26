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

// Directory for uploads
$target_dir = "uploads/";

// Create uploads directory if it doesn't exist
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true); // Creates the directory with full permissions (0777)
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // File uploaded successfully, proceed to insert data into database
        $product_name = $_POST["product_name"];
        $description = $_POST["description"];
        $price = $_POST["price"];

        $sql = "INSERT INTO products (product_name, description, price, image)
                VALUES ('$product_name', '$description', '$price', '$target_file')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Add Product</title>
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

        h2 {
            text-align: center;
            margin-top: 50px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        textarea,
        input[type="file"] {
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

        /* Style for invalid input */
        input:invalid {
            border-color: red;
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
            <li><a href="admin.php">DASHBOARD</a></li>
        </ul>
    </div>
</div>

<h2>Add New Product</h2>
<form method="post" enctype="multipart/form-data">
    <label for="product_name">Product Name:</label><br>
    <input type="text" id="product_name" name="product_name" required><br><br>
    <label for="description">Description:</label><br>
    <textarea id="description" name="description" required></textarea><br><br>
    <label for="price">Price:</label><br>
    <input type="number" id="price" name="price" min="0.01" step="0.01" required><br><br>
    <label for="image">Image:</label><br>
    <input type="file" id="image" name="image" required><br><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>
