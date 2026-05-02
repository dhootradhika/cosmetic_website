<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

$result = $conn->query("
    SELECT c.*, p.name, p.image
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id='$user_id'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>

    <style>
        body {
            font-family: Arial;
            background: #fff5f8;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #d63384;
        }

        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            padding: 15px;
            margin: 10px auto;
            width: 600px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .cart-item img {
            width: 60px;
            border-radius: 8px;
        }

        .cart-item h4 {
            flex: 1;
            margin-left: 15px;
        }

        .total {
            text-align: center;
            font-size: 22px;
            margin-top: 20px;
            color: #333;
        }

        .checkout-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background: #ff4d6d;
            color: white;
            text-align: center;
            border-radius: 8px;
            text-decoration: none;
        }
    </style>
</head>

<body>

<h2>Your Cart</h2>

<?php
$total = 0;

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
?>

<div class="cart-item">

    <img src="<?php echo $row['image']; ?>">

    <h4><?php echo $row['name']; ?></h4>

    <p>₹<?php echo $row['price']; ?> x <?php echo $row['quantity']; ?></p>

</div>

<?php
    }

} else {
    echo "<p style='text-align:center;'>Cart is empty</p>";
}
?>

<div class="total">
    Total: ₹<?php echo $total; ?>
</div>

<a class="checkout-btn" href="checkout.php">Checkout</a>

</body>
</html>