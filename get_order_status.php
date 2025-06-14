<?php
include 'db.php';
$order_id = $_GET['order_id'];
$sql = "SELECT status FROM orders WHERE id = $order_id";
$result = $conn->query($sql)->fetch_assoc();
echo json_encode(['status' => $result['status']]);
?>
