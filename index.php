<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MV&Co. Clothes Shopping</title>
    <link rel="stylesheet" href="style.css">
    <!-- Include Ionicons library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.3/css/ionicons.min.css">
    <style>
        .navbar {
            position: relative; /* Set position relative for navbar */
        }

        .contact-section {
            position: absolute;
            top: 100%; /* Position right below navbar */
            left: 0;
            z-index: 1; /* Ensure contact dropdown appears above other content */
            background-color: #333; /* Set background color for contact section */
            color: white; /* Set text color for contact section */
            padding: 20px; /* Add padding for better spacing */
            width: 100%; /* Make contact section full width */
            text-align: center; /* Center-align content */
        }
        
        .dropdown-content p {
            color: white; /* Set text color for contact information */
            padding: 12px 0; /* Adjust padding for contact information */
            margin: 0; /* Remove default margin */
        }

        .icons {
            margin-top: 20px; /* Add margin to separate icons from contact information */
        }

        .icons a {
            color: white; /* Set color for icons */
            margin-right: 10px; /* Add margin between icons */
        }

        /* Style for the logo */
        .logo-icon {
            font-size: 28px; /* Adjust font size for the logo */
            margin-right: 5px; /* Add margin to separate logo from text */
        }

        /* Style for cards */
        .card {
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 200px; /* Set fixed width for the cards */
            display: block; /* Display cards as block elements */
            cursor: pointer; /* Add cursor pointer */
        }

        .card h2 {
            margin-bottom: 10px;
            color: black; /* Set color of h2 to black */
        }

        .card p {
            color: black; /* Set color of p to black */
        }
    </style>
</head>
<body>
    <div class="main">
        <nav class="navbar">
            <!-- Cart Logo -->
            <div class="icon">
                <ion-icon name="cart-outline" class="logo-icon"></ion-icon>
                <h2 class="logo">MV&Co.</h2>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="home.php" id="home-link">STORE</a></li>
                    <li><a href="vieworder.php" id="vieworder-link">VIEW ORDER</a></li>
                    <li><a href="Cart.php" id="Cart-link">CART</a></li>
                    <li><a href="about.php" id="">ABOUT</a></li>
                    <li><a href="login.php" id="login-link">LOGIN</a></li> 
                </ul>
            </div>
        </nav>
        <div class="content">
            <h1>E-COMMERCE <br><span>CLOTHES SHOPPING</span> <br>MANAGEMENT SYSTEM</h1>
            <!-- Cards for displaying total number of items in the cart and total number of orders placed -->
            <div class="card" id="cart-card">
                <h2>CART</h2>
                <p id="cart-items-count">0</p>
            </div>
            <div class="card" id="total-orders-card">
                <h2>ORDERS PLACED</h2>
                <p id="total-orders">0</p>
            </div>
        </div>
    </div>

    <script>
        // Function to fetch cart count from the database
        function fetchCartCount() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var cartCount = parseInt(this.responseText);
                    displayCartCount(cartCount);
                }
            };
            xhttp.open("GET", "fetch_cart_count.php", true); // Modify the URL to your server endpoint
            xhttp.send();
        }

        // Function to display cart count on the card
        function displayCartCount(cartCount) {
            document.getElementById("cart-items-count").textContent = cartCount;
        }

        // Function to fetch total orders from the database
        function fetchTotalOrders() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var totalOrders = parseInt(this.responseText);
                    displayTotalOrders(totalOrders);
                }
            };
            xhttp.open("GET", "fetch_total_orders.php", true); // Modify the URL to your server endpoint
            xhttp.send();
        }

        // Function to display total orders on the card
        function displayTotalOrders(totalOrders) {
            document.getElementById("total-orders").textContent = totalOrders;
        }

        // Call functions to fetch and display cart count and total orders placed
        fetchCartCount();
        fetchTotalOrders();

        // Redirect to Cart page when clicking on Cart card
        document.getElementById("cart-card").addEventListener("click", function() {
            window.location.href = "Cart.php";
        });

        // Redirect to View Order page when clicking on Total Orders card
        document.getElementById("total-orders-card").addEventListener("click", function() {
            window.location.href = "vieworder.php";
        });
    </script>
</body>
</html>
