/* ================= HOME ================= */
var homeSwiper = new Swiper(".home-swiper", {
  spaceBetween: 30,
  centeredSlides: true,
  autoplay: {
    delay: 4500,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
});

/* ================= SHOP ================= */
var shopSwiper = new Swiper(".shop-swiper", {
  slidesPerView: 1,
  spaceBetween: 10,
  breakpoints: {
    640: { slidesPerView: 2 },
    768: { slidesPerView: 3 },
    1200: { slidesPerView: 4 },
  },
});

/* ================= NAVBAR ================= */
const menuBtn = document.querySelector(".menu-btn");
const navList = document.querySelector(".navlist");

if (menuBtn) {
  menuBtn.onclick = function () {
    menuBtn.classList.toggle("lnr-chevron-up");
    navList.classList.toggle("active");
  };
}

/* ================= USER HELPER ================= */
function getUser() {
  let user = localStorage.getItem("user");
  if (!user) return null;
  return user.trim().toLowerCase();
}

/* ================= CART COUNT ================= */
function updateCartCount() {
  const countEl = document.getElementById("cart-count");
  if (!countEl) return;

  const user = getUser();

  if (!user) {
    countEl.innerText = 0;
    return;
  }

  let cart = JSON.parse(localStorage.getItem("cart_" + user)) || [];

  let total = 0;
  cart.forEach(item => total += item.quantity);

  countEl.innerText = total;
}

updateCartCount();

/* ================= ADD TO CART ================= */
function addToCart(product) {

  const user = getUser();

  if (!user) {
    alert("Please login first!");
    return;
  }

  let key = "cart_" + user;
  let cart = JSON.parse(localStorage.getItem(key)) || [];

  let existing = cart.find(item => item.id === product.id);

  if (existing) {
    existing.quantity++;
  } else {
    product.quantity = 1; // ✅ IMPORTANT FIX
    cart.push(product);
  }

  localStorage.setItem(key, JSON.stringify(cart));

  updateCartCount();
  alert("Added to cart!");
}

/* ================= LOGIN / LOGOUT ================= */

const loginBtn = document.getElementById("loginBtn");

if (loginBtn) {

  const user = getUser();

  if (user) {
    loginBtn.innerText = "Logout";

    loginBtn.onclick = logout;

  } else {
    loginBtn.innerText = "Login";

    loginBtn.onclick = () => {
      window.location.href = "login.html";
    };
  }
}

/* ================= CLICK HANDLER ================= */

document.addEventListener("click", function(e) {

  const cartBtn = e.target.closest(".add-to-cart");
  const wishBtn = e.target.closest(".add-to-wishlist");

  if (!cartBtn && !wishBtn) return;

  const box = e.target.closest(".box");
  if (!box) return;

  const id = parseInt(box.getAttribute("data-id"));

  if (!id) {
    console.error("❌ Product ID missing!", box);
    return;
  }

  const product = {
    id: id,
    name: box.getAttribute("data-name"),
    price: parseFloat(box.getAttribute("data-price")),
    image: box.getAttribute("data-image"),
    quantity: 1
  };

  if (wishBtn) {
    e.stopPropagation();
    addToWishlist(product);
    return;
  }

  if (cartBtn) {
    e.stopPropagation();
    console.log("ADDING TO CART:", product);
    addToCart(product);
  }
});

/* ================= WISHLIST ================= */

function addToWishlist(product) {

  fetch("backend/check_login.php", {   // ✅ FIXED PATH
    credentials: "include"
  })
  .then(res => res.text())
  .then(user => {

    if (user.trim() === "not_logged_in") {
      alert("Please login first!");
      window.location.href = "login.html";
      return;
    }

    user = user.trim().toLowerCase();
    localStorage.setItem("user", user);

    let key = "wishlist_" + user;
    let wishlist = JSON.parse(localStorage.getItem(key)) || [];

    let exists = wishlist.find(item => item.name === product.name);

    if (exists) {
      alert("Already in wishlist ❤️");
    } else {
      wishlist.push(product);
      localStorage.setItem(key, JSON.stringify(wishlist));
      alert(product.name + " added to wishlist ❤️");
    }
  });
}

function removeFromWishlist(index) {

  fetch("backend/check_login.php", {   // ✅ FIXED PATH
    credentials: "include"
  })
  .then(res => res.text())
  .then(user => {

    user = user.trim().toLowerCase();

    let key = "wishlist_" + user;
    let wishlist = JSON.parse(localStorage.getItem(key)) || [];

    wishlist.splice(index, 1);

    localStorage.setItem(key, JSON.stringify(wishlist));

    location.reload();
  });
}

/* ================= LOGOUT ================= */

function logout() {
  fetch("backend/logout.php", {
    credentials: "include"
  })
  .then(res => res.text())
  .then(data => {

    if (data.trim() === "success") {

      localStorage.removeItem("user");

      alert("Logged out!");
      window.location.href = "login.html";

    } else {
      alert("Logout failed");
    }
  });
}