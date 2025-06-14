<?php
session_start();
include 'db.php';
$restaurant_id = $_GET['restaurant_id'];
$sql = "SELECT * FROM restaurants WHERE id = $restaurant_id";
$restaurant = $conn->query($sql)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - <?php echo $restaurant['name']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        .container { width: 90%; margin: auto; max-width: 1200px; }
        header { background: #ff2a44; color: white; padding: 10px 0; text-align: center; }
        nav { background: #333; padding: 10px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; }
        nav a:hover { text-decoration: underline; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; padding: 20px 0; }
        .menu-item { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .menu-item img { width: 100%; height: 150px; object-fit: cover; }
        .menu-item h3 { margin: 10px; font-size: 1.2em; }
        .menu-item p { margin: 0 10px 10px; color: #666; }
        .btn { background: #ff2a44; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #e0233d; }
        @media (max-width: 768px) { .menu-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header>
        <h1><?php echo $restaurant['name']; ?> Menu</h1>
    </header>
    <nav>
        <a href="#" onclick="redirect('index.php')">Home</a>
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
    <div class="container">
        <div class="menu-grid">
            <?php
            $sql = "SELECT * FROM menu WHERE restaurant_id = $restaurant_id";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<div class='menu-item'>
                        <img src='https://via.placeholder.com/250x150' alt='{$row['name']}'>
                        <h3>{$row['name']}</h3>
                        <p>Rs. {$row['price']}</p>
                        <a href='#' onclick='addToCart({$row['id']})' class='btn'>Add to Cart</a>
                      </div>";
            }
            ?>
        </div>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
        function logout() { redirect('logout.php'); }
        function addToCart(itemId) {
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'item_id=' + itemId
            }).then(response => response.json()).then(data => {
                alert(data.message);
                if (data.success) redirect('cart.php');
            });
        }
    </script>
</body>
</html>
