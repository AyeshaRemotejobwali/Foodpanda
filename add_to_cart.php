<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to add items to cart']);
    exit;
}
$item_id = $_POST['item_id'];
$user_id = $_SESSION['user_id'];
$sql = "INSERT INTO cart (user_id, menu_id, quantity) VALUES ($user_id, $item_id, 1) ON DUPLICATE KEY UPDATE quantity = quantity + 1";
if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Item added to cart']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error adding to cart']);
}
?>
