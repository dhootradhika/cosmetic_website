<?php
$conn = new mysqli("localhost","root","","cosmetics_db");

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

$orders = $conn->query("SELECT * FROM orders ORDER BY id DESC");

echo "<h2 style='text-align:center;'>🧾 Admin Orders</h2>";

if($orders->num_rows == 0){
    echo "<p style='text-align:center;'>No orders found</p>";
}

while($order = $orders->fetch_assoc()){

    $order_id = $order['id'];

    echo "<div style='border:2px solid #6a0572; padding:15px; margin:15px; border-radius:10px;'>
            <h3>Order ID: $order_id</h3>
            <p><strong>Total:</strong> ₹".$order['total']."</p>
            <hr>";

    $items = $conn->query("
        SELECT oi.*, p.name 
        FROM order_items oi
        LEFT JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = $order_id
    ");

    if($items->num_rows == 0){
        echo "<p style='color:red;'>No items found</p>";
    } else {
        while($item = $items->fetch_assoc()){
            echo "<p>
                <strong>Product:</strong> ".($item['name'] ?? 'N/A')."<br>
                <strong>Price:</strong> ₹".$item['price']."<br>
                <strong>Quantity:</strong> ".$item['quantity']."
            </p>";
        }
    }

    echo "</div>";
}
?>