<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// get cart items (IMPORTANT: must include product_id)
$cart = $conn->query("SELECT * FROM cart WHERE user_id='$user_id'");

if($cart->num_rows == 0){
    echo "Cart is empty!";
    exit();
}

$total = 0;

// calculate total
while($item = $cart->fetch_assoc()){
    $total += $item['price'] * $item['quantity'];
}

// create order
$conn->query("INSERT INTO orders (user_id, total) VALUES ('$user_id', '$total')");
$order_id = $conn->insert_id;

// insert order items
$cart = $conn->query("SELECT * FROM cart WHERE user_id='$user_id'");

while($item = $cart->fetch_assoc()){
    $conn->query("INSERT INTO order_items (order_id, product_id, quantity)
    VALUES ('$order_id','{$item['product_id']}','{$item['quantity']}')");
}

// clear cart
$conn->query("DELETE FROM cart WHERE user_id='$user_id'");

echo "<script>alert('Order placed!'); window.location.href='index.php';</script>";
?>