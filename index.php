<?php
session_start();
include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href = "style.css">
    <title>Cosmetics Website</title>
</head>
<body>
    <nav>
        <div class="container nav-container">
            <a href ="#home" class = "logo">
                <div>Aphrodite<span>    Cosmetics</span></div>
                <div>Where science meets beauty — premium cosmetics designed for every skin type</div>
            </a>
            <ul class="navlist">
                <li><a href="#home" class="active">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="products.html">Categories</a></li>
                <li><a href="#shop">Shop</a></li>
                <li><a href="#footer">Contact</a></li>
            </ul>
            <div class="nav-icons">
                    <a href = "wishlist.php">
                        <span class="lnr lnr-heart add-to-wishlist" style="color:white;"></span>
                    </a>
                    <a href="cart.php">
                        <span class="lnr lnr-cart" style="color:white;"></span>
                    </a>
                    <a href="cart_count.php"><span id="cart-count">0</span></a>
                    <div style="position:absolute; top:20px; right:20px;">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <a href="backend/logout.php">
                            <button style="padding:8px 15px; background:red; color:white; border:none; border-radius:8px; ">
                                Logout
                            </button>
                        </a>
                    <?php else: ?>
                        <a href="login.html">
                            <button style="padding:8px 15px;">Login</button>
                        </a>
                    <?php endif; ?>
                    </div>

                
            </div>
        </div>
    </nav>

    <!-- HOME -->
    <section class="home" id="home">
        <div class="home-container">
            <div class="swiper mySwiper home-swiper">
                <div class="swiper-wrapper">
                      <div class="swiper-slide slide1">
                        <div class="content">
                            <a href="products.html" style="
                              display: inline-block;
                              padding: 15px 30px;
                              font-size: 20px;
                              font-weight: bold;
                              color: #fff;
                              background-color: #e7367a;
                              text-decoration: none;
                              border-radius: 8px;
                              text-align: center;
                            ">
                              Shop Now
                            </a>
                        </div>
                      </div>
                      
                      <div class="swiper-slide slide3">
                        <div class="content">
                            <a href="products.html" style="
                              display: inline-block;
                              padding: 15px 30px;
                              font-size: 20px;
                              font-weight: bold;
                              color: #fff;
                              background-color: #e7367a;
                              text-decoration: none;
                              border-radius: 8px;
                              text-align: center;
                            ">
                              Shop Now
                            </a>
                        </div>
                      </div>
                </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                  </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section class="about" id="about">
        <h2>About Us</h2>
        <div class="container about-container">
            <div class="left">
                <div class="content">
                    <div class="title">
                        <h2>Where Beauty Becomes Divine</h2>
                    </div>
                    <p style="color: white;">At Aphrodite Cosmetics, 
                        beauty is more than appearance—it is an expression
                         of confidence, elegance, and individuality. 
                         Inspired by the timeless allure of Aphrodite, 
                         our collection brings together professional-quality 
                         cosmetics and skincare designed to enhance your 
                         natural radiance. Every product is crafted to help 
                         you feel empowered, graceful, and effortlessly 
                         beautiful in your own skin.</p>
                        <button class="btn">Learn more</button>
                </div>
            </div>
            <div class="right">
                <div class="image">
                    <img src = "uploads\ss2.jpeg" alt=""> 
                </div>
            </div>
        </div>
    </section>


    <!-- SHOP -->
     <section class="shop" id="shop">
        <div class="title">
            <h2>Our MOST Popular Products</h2>
        </div>
        <div class="container shop-container">
        <div class="swiper mySwiper shop-swiper">
            <div class="swiper-wrapper">

                <?php
                $result = mysqli_query($conn, "SELECT * FROM products");

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                ?>

                <div class="swiper-slide">
                    <div class="box"
                        data-id="<?php echo $row['id']; ?>"
                        data-name="<?php echo $row['name']; ?>"
                        data-price="<?php echo $row['price']; ?>"
                        data-image="<?php echo $row['image']; ?>">

                        <div class="image">
                            <img src="<?php echo $row['image']; ?>" alt="">
                            <div class="add">
                                <span class="lnr lnr-cart add-to-cart"></span>
                                <span class="lnr lnr-heart add-to-wishlist"></span>
                            </div>
                        </div>

                        <div class="info">
                            <p>Cosmetics</p>
                            <h4><?php echo $row['name']; ?></h4>
                            <span>₹<?php echo $row['price']; ?></span>
                        </div>

                    </div>
                </div>

                <?php
                    }
                } else {
                    echo "<p>No products found</p>";
                }
                ?>

            </div>
        </div>
    </div>
    <!-- CENTER BUTTON -->
    <div class="view-all-btn">
        <a href="products.html" class="btn">View All Products</a>
    </div>
</section>

   <!-- Footer -->
    <section class="footer" id = "footer">
        <div class="container footer-container">
            <div class="box">
                <a href="#home" class="logo">
                    <div>Make<span>up</span></div>
                    <div>Fashion Steps</div>
                </a>
                <p>true beauty comes from confidence—the confidence to be yourself, to embrace your uniqueness, and to shine unapologetically.
                     When you care for your skin and nurture your natural glow, you don’t just enhance your beauty—you elevate your confidence.
                      And that confidence is what makes you truly unforgettable.</p>
            </div>
            <!--
            <div class="box">
                <h4>Newsletter</h4>
                <p>Stay update with our latest products, news and discounts</p>
                <form action="" class="newsletter">
                    <input type="email" name="email" id="" placeholder="Enter Email">
                    <button type="submit" class="btn"><span class="lnr
                        lnr-arrow-right" ></span></button>
                </form>
            </div> -->
            <div class="box">
                <h4>Follow us</h4>
                <p>Follow us on social media platforms.</p>
                <div class="social">
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-linkedin"></i>
                </div>
            </div>
        </div>
    </section>
    <div class="copyright">
        <p>Copyright &copy; 2023 All rights reserved. this template is made with
            <i class="fa-solid fa-heart"></i> by Sophia Batch 2023
        </p>
    </div>
<script>
function logoutUser() {
    fetch("backend/logout.php")
    .then(() => {
        window.location.reload();
    });
}
document.querySelectorAll(".add-to-wishlist").forEach(btn => {

    btn.addEventListener("click", function(){

        let productBox = this.closest(".box");

        let name = productBox.getAttribute("data-name");
        let price = productBox.getAttribute("data-price");

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
                this.classList.add("active");
                alert("Added to wishlist!");
            } else if(data === "removed"){
                this.classList.remove("active");
                alert("Removed from wishlist!");
            } else if(data === "not_logged_in"){
                alert("Please login first!");
                window.location.href = "login.html";
            } else {
                alert(data);
            }
        });

    });

});
document.querySelectorAll(".add-to-cart").forEach(btn => {
    btn.addEventListener("click", function () {

        let box = this.closest(".box");

        if (!box) {
            console.log("BOX NOT FOUND");
            return;
        }

        let id = box.getAttribute("data-id");
        let price = box.getAttribute("data-price");

        console.log("CLICKED:", id, price);

        fetch("backend/add_to_cart.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}&price=${price}`
        })
        .then(res => res.text())
        .then(data => {
            console.log("SERVER:", data);

            if (data.trim() === "success") {
                alert("Added to cart!");
            } else {
                alert(data);
            }
        });

    });
});

</script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
    <script src="https://cdn.linearicons.com/free/1.0.0/svgembedder.min.js"></script>
    <script src = "script.js"></script>
</body>
</html>