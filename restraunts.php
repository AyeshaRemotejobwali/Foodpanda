<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurants - Foodpanda Clone</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        .container { width: 90%; margin: auto; max-width: 1200px; }
        header { background: #ff2a44; color: white; padding: 10px 0; text-align: center; }
        nav { background: #333; padding: 10px; }
        nav a { color: white; text-decoration: none; margin: 0 15px; }
        nav a:hover { text-decoration: underline; }
        .filter { margin: 20px 0; }
        .filter select { padding: 10px; border-radius: 5px; }
        .restaurant-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .restaurant-card { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .restaurant-card img { width: 100%; height: 150px; object-fit: cover; }
        .restaurant-card h3 { margin: 10px; font-size: 1.2em; }
        .restaurant-card p { margin: 0 10px 10px; color: #666; }
        .btn { background: #ff2a44; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: #e0233d; }
        @media (max-width: 768px) { .filter select { width: 100%; } }
    </style>
</head>
<body>
    <header>
        <h1>Restaurants</h1>
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
        <div class="filter">
            <select onchange="filterRestaurants(this.value)">
                <option value="">All Cuisines</option>
                <option value="Italian">Italian</option>
                <option value="Chinese">Chinese</option>
                <option value="Fast Food">Fast Food</option>
            </select>
        </div>
        <div class="restaurant-grid" id="restaurant-grid">
            <?php
            $sql = "SELECT * FROM restaurants";
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
        function filterRestaurants(cuisine) {
            let cards = document.querySelectorAll('.restaurant-card');
            cards.forEach(card => {
                let cardCuisine = card.querySelector('p').textContent.split(' - ')[0];
                card.style.display = (cuisine === '' || cardCuisine === cuisine) ? 'block' : 'none';
            });
        }
    </script>
</body>
</html>
