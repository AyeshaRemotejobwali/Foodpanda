<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
}
$user_id = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $sql = "INSERT INTO orders (user_id, address, payment_method, status) VALUES ($user_id, '$address', '$payment_method', 'Processing')";
    if ($conn->query($sql)) {
        $order_id = $conn->insert_id;
        $sql = "INSERT INTO order_items (order_id, menu_id, quantity) SELECT $order_id, menu_id, quantity FROM cart WHERE user_id = $user_id";
        $conn->query($sql);
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");
        echo "<script>window.location.href = 'order_track.php?order_id=$order_id';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Foodpanda Clone</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        .container { width: 90%; margin: auto; max-width: 1200px; }
        header { background: #ff2a44; color: white; padding: 10px 0; text-align: center; }
        nav { background: #333; padding: 10px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; }
        nav a:hover { text-decoration: underline; }
        .cart-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .cart-table th, .cart-table td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .btn { background: #ff2a44; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #e0233d; }
        @media (max-width: 768px) { .cart-table th, .cart-table td { font-size: 0.9em; } }
    </style>
</head>
<body>
    <header>
        <h1>Your Cart</h1>
    </header>
    <nav>
        <a href="#" onclick="redirect('index.php')">Home</a>
        <a href="#" onclick="redirect('restaurants.php')">Restaurants</a>
        <a href="#" onclick="redirect('order_track.php')">Track Order</a>
        <a href="#" onclick="logout()">Logout</a>
    </nav>
    <div class="container">
        <table class="cart-table">
            <tr><th>Item</th><th>Price</th><th>Quantity</th><th>Total</th></tr>
            <?php
            $sql = "SELECT m.name, m.price, c.quantity FROM cart c JOIN menu m ON c.menu_id = m.id WHERE c.user_id = $user_id";
            $result = $conn->query($sql);
            $total = 0;
            while ($row = $result->fetch_assoc()) {
                $subtotal = $row['price'] * $row['quantity'];
                $total += $subtotal;
                echo "<tr><td>{$row['name']}</td><td>Rs. {$row['price']}</td><td>{$row['quantity']}</td><td>Rs. $subtotal</td></tr>";
            }
            ?>
            <tr><td colspan="3">Total</td><td>Rs. <?php echo $total; ?></td></tr>
        </table>
        <form method="POST">
            <div class="form-group">
                <label>Delivery Address</label>
                <input type="text" name="address" required>
            </div>
            <div class="form-group">
                <label>Payment Method</label>
                <select name="payment_method" required>
                    <option value="COD">Cash on Delivery</option>
                    <option value="Online">Online Payment</option>
                </select>
            </div>
            <button type="submit" class="btn">Place Order</button>
        </form>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
        function logout() { redirect('logout.php'); }
    </script>
</body>
</html>
