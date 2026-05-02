<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli("localhost","root","","cosmetics_db");

// ✅ Same user_id
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = rand(1000,9999);
}
$user_id = $_SESSION['user_id'];

if(isset($_POST['place_order'])){

    $phone = $_POST['phone'];

    // ✅ Get cart
    $cartQuery = $conn->query("
        SELECT c.*, p.price 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = $user_id
    ");

    if($cartQuery->num_rows == 0){
        echo "<script>alert('❌ Cart is empty');</script>";
    } else {

        $total = 0;

        while($item = $cartQuery->fetch_assoc()){
            $total += $item['price'] * $item['quantity'];
        }

        // ✅ Insert order
        $conn->query("
            INSERT INTO orders (user_id, total) 
            VALUES ($user_id, $total)
        ");

        $order_id = $conn->insert_id;

        // ✅ Insert order items
        $cartQuery = $conn->query("
            SELECT c.*, p.price 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = $user_id
        ");

        while($item = $cartQuery->fetch_assoc()){
            $conn->query("
                INSERT INTO order_items (order_id, product_id, quantity, price)
                VALUES ($order_id, {$item['product_id']}, {$item['quantity']}, {$item['price']})
            ");
        }

        // ✅ Clear cart
        $conn->query("DELETE FROM cart WHERE user_id = $user_id");

        echo "<script>
            alert('🎉 Order successfully saved!');
            window.location.href='index.php';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Checkout</title>
<style>
body{
    font-family: Arial;
    background: linear-gradient(135deg,#fbc2eb,#a6c1ee);
    padding:40px;
}
.container{
    background:white;
    padding:25px;
    width:400px;
    margin:auto;
    border-radius:12px;
}
input{
    width:100%;
    padding:10px;
    margin:10px 0;
}
button{
    background:#6a0572;
    color:white;
    padding:12px;
    border:none;
    width:100%;
}
</style>
</head>

<body>

<div class="container">
<h2>Checkout</h2>

<form method="POST">
<label>Phone Number</label>
<input type="text" name="phone" required>

<button type="submit" name="place_order">Place Order</button>
</form>

</div>

</body>
</html>