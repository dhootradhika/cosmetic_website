<?php
session_start();
include("db.php");

// ✅ CHECK LOGIN
if(!isset($_SESSION['user_id'])){
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ FETCH WISHLIST
$result = $conn->query("SELECT * FROM wishlist WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Wishlist</title>

<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #fff5f8;
    padding: 20px;
}

h2 {
    text-align: center;
    color: #d63384;
    margin-bottom: 20px;
}

#wishlist-items {
    display: block !important;
}

.wishlist-item {
    width: 450px !important;
    max-width: 90% !important;
    margin: 12px auto !important;  /* ✅ force center */
}

/* Wishlist Item Card */
.wishlist-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    background: #ffffff;
    width: 550px !important;
    padding: 18px 24px !important;
    max-width: 95% !important;
    margin: 12px 0;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.wishlist-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
}

/* Product Name */
.wishlist-item h4 {
    margin: 0;
    color: #333;
    font-size: 18px;
    flex: 2;
}

/* Price */
.wishlist-item p {
    margin: 0;
    color: #d63384;
    font-weight: 600;
    font-size: 16px;
}

/* Button Container */
.actions {
    display: flex;
    gap: 12px;
}

/* Buttons */
.wishlist-item button {
    background: linear-gradient(135deg, #ff4d6d, #ff758f);
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.2s ease;
    padding: 10px 16px;   /* ⬅️ bigger */
    font-size: 14px;      /* ⬅️ bigger text */
    border-radius: 10px;
}


.wishlist-item button:hover {
    background: linear-gradient(135deg, #e63956, #ff4d6d);
    transform: scale(1.05);
}

/* Optional: different colors for buttons */

.remove-btn {
    background: linear-gradient(135deg, #ff4d6d, #ff758f);
}

/* Empty message */
#wishlist-items p {
    text-align: center;
    color: #888;
}
</style>
</head>

<body>

<h2>Your Wishlist</h2>

<?php
if($result->num_rows == 0){
    echo "<p style='text-align:center;'>Your wishlist is empty.</p>";
}

while($row = $result->fetch_assoc()){
?>
    <div class="wishlist-item">
        <div>
            <h4><?php echo $row['product_name']; ?></h4>
            <p>₹<?php echo number_format($row['price']); ?></p>
        </div>

        <div>

            <a href="backend/remove_wishlist.php?id=<?php echo $row['id']; ?>">
                <button class="remove-btn">Remove</button>
            </a>
        </div>
    </div>
<?php } ?>

</body>
</html>