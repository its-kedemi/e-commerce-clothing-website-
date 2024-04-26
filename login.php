<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e com";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate math question
function generateMathQuestion() {
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $operator = ['+', '-', '*'][rand(0, 2)];
    $question = "$num1 $operator $num2";
    $answer = eval("return $num1 $operator $num2;");
    return [$question, $answer];
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather login user inputs
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_answer = $_POST['answer'];
    $correct_answer = $_POST['correct_answer'];

    // Check if the math question is answered correctly
    if ($user_answer == $correct_answer) {
        // SQL to check user credentials
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Check user role and redirect accordingly
                if ($row['role'] == 'admin') {
                    header("Location: admin.php");
                    exit();
                } else {
                    header("Location: index.php");
                    exit();
                }
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "Incorrect answer to math question.";
    }
}

// Generate math question
list($math_question, $correct_answer) = generateMathQuestion();

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
        }
        form {
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">

            <label for="question"><?php echo $math_question; ?> = ?</label>
            <input type="text" id="answer" name="answer">

            <input type="hidden" name="correct_answer" value="<?php echo $correct_answer; ?>">

            <input type="submit" value="Login">
        </form>

        <div class="register-link">
            <p>Don't have an account yet? <a href="register.php">Register here</a>.</p>
        </div>
    </div>
</body>
</html>
