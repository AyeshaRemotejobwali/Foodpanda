<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = 'login.php';</script>";
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking - Foodpanda Clone</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        .container { width: 90%; margin: auto; max-width: 1200px; }
        header { background: #ff2a44; color: white; padding: 10px 0; text-align: center; }
        nav { background: #333; padding: 10px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; font-size: 1.1em; }
        nav a:hover { text-decoration: underline; }
        .tracking { margin: 20px 0; }
        .tracking h2 { color: #333; text-align: center; }
        .order-card { background: white; border-radius: 10px; padding: 15px; margin-bottom: 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .order-card h3 { margin: 0 0 10px; color: #ff2a44; }
        .order-card p { margin: 5px 0; color: #333; }
        .status { font-weight: bold; color: #ff2a44; }
        .btn { background: #ff2a44; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .btn:hover { background: #e0233d; }
        @media (max-width: 768px) { 
            .order-card { padding: 10px; }
            .order-card h3 { font-size: 1.2em; }
            nav a { font-size: 1em; margin: 0 10px; }
        }
    </style>
</head>
<body>
    <header>
        <h1>Order Tracking</h1>
    </header>
    <nav>
        <a href="#" onclick="redirect('index.php')">Home</a>
        <a href="#" onclick="redirect('restaurants.php')">Restaurants</a>
        <a href="#" onclick="redirect('cart.php')">Cart</a>
        <a href="#" onclick="logout()">Logout</a>
    </nav>
    <div class="container tracking">
        <h2>Your Orders</h2>
        <div id="order-list">
            <?php
            $sql = "SELECT o.id, o.status, o.created_at, o.address, GROUP_CONCAT(m.name) as items 
                    FROM orders o 
                    JOIN order_items oi ON o.id = oi.order_id 
                    JOIN menu m ON oi.menu_id = m.id 
                    WHERE o.user_id = $user_id 
                    GROUP BY o.id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='order-card'>
                            <h3>Order #{$row['id']}</h3>
                            <p><strong>Status:</strong> <span class='status'>{$row['status']}</span></p>
                            <p><strong>Items:</strong> {$row['items']}</p>
                            <p><strong>Address:</strong> {$row['address']}</p>
                            <p><strong>Ordered On:</strong> {$row['created_at']}</p>
                          </div>";
                }
            } else {
                echo "<p>No orders found.</p>";
            }
            ?>
        </div>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
        function logout() { redirect('logout.php'); }
        function refreshOrders() {
            fetch('get_orders.php')
                .then(response => response.json())
                .then(data => {
                    let orderList = document.getElementById('order-list');
                    orderList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(order => {
                            let card = document.createElement('div');
                            card.className = 'order-card';
                            card.innerHTML = `
                                <h3>Order #${order.id}</h3>
                                <p><strong>Status:</strong> <span class='status'>${order.status}</span></p>
                                <p><strong>Items:</strong> ${order.items}</p>
                                <p><strong>Address:</strong> ${order.address}</p>
                                <p><strong>Ordered On:</strong> ${order.created_at}</p>`;
                            orderList.appendChild(card);
                        });
                    } else {
                        orderList.innerHTML = '<p>No orders found.</p>';
                    }
                });
        }
        setInterval(refreshOrders, 5000);
        refreshOrders(); // Initial load
    </script>
</body>
</html>
