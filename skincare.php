<?php
include("db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Skincare</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background: linear-gradient(135deg,#f9d5ec,#fddde6,#fbc2eb);
    padding:20px;
}

h1{
    text-align:center;
    font-family:'Playfair Display',serif;
    font-size:42px;
    color:#6a0572;
}
.tagline{
    text-align:center;
    font-size:18px;
    margin-top:8px;
    margin-bottom:25px;
    color:#6a0572;
    font-weight:500;
    letter-spacing:1px;

    /* Gradient Text */
    background: linear-gradient(90deg,#ff4d6d,#6a0572);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;

    /* Animation */
    animation: fadeGlow 2s ease-in-out infinite alternate;
}

/* Glow animation */
@keyframes fadeGlow{
    from{
        opacity:0.7;
        transform:translateY(0px);
    }
    to{
        opacity:1;
        transform:translateY(-3px);
    }
}

.subtitle{
    text-align:center;
    margin-bottom:20px;
    color:#555;
}

.controls{
    text-align:center;
    margin:20px;
}

input,select{
    padding:10px;
    border-radius:20px;
    border:none;
    outline:none;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

.card{
    background:rgba(255,255,255,0.6);
    backdrop-filter:blur(15px);
    border-radius:20px;
    padding:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
    transition:0.4s;
    position:relative;
    overflow:hidden;
}

.card:hover{
    transform:translateY(-10px) scale(1.02);
}

.card img{
    width:100%;
    height:230px;
    object-fit:cover;
    border-radius:15px;
}

.card h3{
    margin:10px 0;
    color:#6a0572;
}

.price{
    color:#ff2e63;
    font-weight:bold;
}

.actions{
    display:flex;
    justify-content:space-between;
    margin-top:10px;
}

button{
    padding:8px 12px;
    border:none;
    border-radius:20px;
    cursor:pointer;
}

.cart{
    background:#6a0572;
    color:white;
}

.wishlist{
    background:#ff4d6d;
    color:white;
}

.remove{
    background:#222;
    color:white;
}

.back{
    text-decoration:none;
    color:#6a0572;
    font-weight:bold;
}
.wishlist.active {
    background: black;
    color: white;
    transform: scale(1.2);
}

.controls{
    text-align:center;
    margin:20px;
}

input,select{
    padding:10px;
    border-radius:20px;
    border:none;
    outline:none;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}
</style>
</head>

<body>

<a href="products.html" class="back">⬅ Back</a>

<h1>Skincare Collection</h1>
<p class="tagline">Nourish your skin, reveal your natural glow ✨</p>

<div class="controls">
    <input type="text" id="search" placeholder="Search..." onkeyup="filterProducts()">
    
    <select id="priceFilter" onchange="filterProducts()">
        <option value="all">All Prices</option>
        <option value="1000">Below ₹1000</option>
        <option value="2000">Below ₹2000</option>
    </select>
</div>
<div class="container">

<?php
$result = mysqli_query($conn, "SELECT * FROM products WHERE category='Skincare'");

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
?>

<div class="card">
    <img src="<?php echo $row['image']; ?>">
    <h3><?php echo $row['name']; ?></h3>
    <p>₹<?php echo $row['price']; ?></p>

    <button onclick="addToCart(<?php echo $row['id']; ?>, <?php echo $row['price']; ?>)">
    Add
</button>
    <button class="wishlist"
            onclick='toggleWishlist(this, <?php echo json_encode($row["name"]); ?>, <?php echo $row["price"]; ?>)'>
            ❤
    </button>
    <button class="remove" onclick="removeFromCart('<?php echo $row['name']; ?>')">
            Remove
    </button>
</div>

<?php
    }
} else {
    echo "<p>No skincare products found</p>";
}
?>

</div>

<script>
    function filterProducts(){
    let search=document.getElementById("search").value.toLowerCase();
    let price=document.getElementById("priceFilter").value;
    let cards=document.querySelectorAll(".card");

    cards.forEach(card=>{
        let text=card.innerText.toLowerCase();
        let cardPrice=parseInt(card.dataset.price);

        let matchSearch=text.includes(search);
        let matchPrice=(price==="all"||cardPrice<=price);

        card.style.display=(matchSearch && matchPrice)?"":"none";
    });
}

function addToCart(productId, price) {

    fetch("backend/add_to_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${productId}&price=${price}`
    })
    .then(res => res.text())
    .then(data => {

        console.log("SERVER:", data);

        if (data.trim() === "success") {
            alert("Added to cart!");
            updateCartCount();
        } 
        else if (data.trim() === "not_logged_in") {
            alert("Please login first!");
            window.location.href = "login.html";
        } 
        else {
            alert(data);
        }
    });
}
function removeFromCart(productId){

    fetch("backend/remove_from_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${productId}`
    })
    .then(res => res.text())
    .then(data => {

        if(data.trim() === "success"){
            alert("Removed from cart!");
        }
        else if(data.trim() === "not_logged_in"){
            alert("Please login first!");
            window.location.href = "login.html";
        }
        else{
            alert(data);
        }
    });
}

function toggleWishlist(btn, name, price){

    fetch("backend/add_wishlist.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `name=${name}&price=${price}`
    })
    .then(res => res.text())
    .then(data => {
        console.log(data);

        if(data === "success"){
            btn.classList.add("active");
            alert("Added to wishlist!");
        } else if(data === "removed"){
            btn.classList.remove("active");
            alert("Removed from wishlist!");
        } else {
            alert(data);
        }
    });

}

window.onload = function () {
    let user = localStorage.getItem("user");
    let wishlist = JSON.parse(localStorage.getItem("wishlist_" + user)) || [];

    document.querySelectorAll(".card").forEach(card => {
        let name = card.querySelector("h3").innerText;
        let btn = card.querySelector(".wishlist");

        if (wishlist.find(item => item.name === name)) {
            btn.classList.add("active");
        }
    });
};
</script>

</body>
</html>