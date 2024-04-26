<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
</head>
<body>
    <h1>Place Your Order</h1>
    <form action="process_order.php" method="post">
        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" id="payment_method">
            <option value="MPESA">M-PESA</option>
            <option value="AIRTEL_MONEY">AIRTEL MONEY</option>
            <option value="DEBIT_CARD">DEBIT CARD</option>
            <option value="paypal">PayPal</option>
            <!-- Add more payment methods as needed -->
        </select>
        
        <label for="quantity">Quantity Needed:</label>
        <input type="number" name="quantity" id="quantity" required>

        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($_GET['product_id']); ?>">
        <input type="submit" value="Submit Order">
    </form>
</body>
</html>
