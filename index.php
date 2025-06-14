<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodpanda Clone - Homepage</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        .container { width: 90%; margin: auto; max-width: 1200px; }
        header { background: #ff2a44; color: white; padding: 10px 0; text-align: center; }
        header h1 { margin: 0; font-size: 2em; }
        nav { background: #333; padding: 10px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; font-size: 1.1em; }
        nav a:hover { text-decoration: underline; }
        .hero { background: url('https://via.placeholder.com/1200x400') no-repeat center; height: 400px; display: flex; align-items: center; justify-content: center; color: white; text-align: center; }
        .hero h2 { font-size: 2.5em; margin: 0; }
        .restaurants { padding: 20px 0; }
        .restaurants h2 { text-align: center; color: #333; }
        .restaurant-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .restaurant-card { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .restaurant-card img { width: 100%; height: 150px; object-fit: cover; }
        .restaurant-card h3 { margin: 10px; font-size: 1.2em; }
        .restaurant-card p { margin: 0 10px 10px; color: #666; }
        .btn { background: #ff2a44; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; }
        .btn:hover { background: #e0233d; }
        @media (max-width: 768px) { .hero h2 { font-size: 1.8em; } nav a { font-size: 1em; margin: 0 10px; } }
    </style>
</head>
<body>
    <header>
        <h1>Foodpanda Clone</h1>
    </header>
    <nav>
        <a href="index.php">Home</a>
        <a href="#" onclick="redirect('restaurants.php')">Restaurants</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="#" onclick="redirect('order_track.php')">Track Order</a>
            <a href="#" onclick="redirect('cart.php')">Cart</a>
            <a href="#" onclick="logout()">Logout</a>
        <?php else: ?>
            <a href="#" onclick="redirect('login.php')">Login</a>
            <a href="#" onclick="redirect('signup.php')">Signup</a>
        <?php endif; ?>
    </nav>
    <div class="hero">
        <h2>Order Delicious Food Now!</h2>
    </div>
    <div class="container restaurants">
        <h2>Featured Restaurants</h2>
        <div class="restaurant-grid">
            <?php
            $sql = "SELECT * FROM restaurants LIMIT 4";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<div class='restaurant-card'>
                        <img src='https://via.placeholder.com/250x150' alt='{$row['name']}'>
                        <h3>{$row['name']}</h3>
                        <p>{$row['cuisine']} - {$row['location']}</p>
                        <a href='#' onclick='redirect(\"menu.php?restaurant_id={$row['id']}\")' class='btn'>View Menu</a>
                      </div>";
            }
            ?>
        </div>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
        function logout() { redirect('logout.php'); }
    </script>
</body>
</html>
