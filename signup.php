<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address = $_POST['address'];
    $sql = "INSERT INTO users (name, email, password, address) VALUES ('$name', '$email', '$password', '$address')";
    if ($conn->query($sql)) {
        echo "<script>alert('Signup successful! Please login.'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Foodpanda Clone</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-container { background: awhite; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px; }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #333; }
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .btn { background: #ff2a44; color: white; padding: 10px; border: none; border-radius: 5px; width: 100%; cursor: pointer; }
        .btn:hover { background: #e0233d; }
        a { color: #ff2a44; text-decoration: none; display: block; text-align: center; margin-top: 10px; }
        a:hover { text-decoration: underline; }
        @media (max-width: 768px) { .form-container { padding: 15px; } }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Signup</h2>
        <form method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" required>
            </div>
            <button type="submit" class="btn">Signup</button>
        </form>
        <a href="#" onclick="redirect('login.php')">Already have an account? Login</a>
    </div>
    <script>
        function redirect(url) { window.location.href = url; }
    </script>
</body>
</html>
