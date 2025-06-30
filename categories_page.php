<?php
session_start(); // Start the session to track user login status

if (!isset($_SESSION['user_id'])) {
  $_SESSION['user_id'] = null; // Default to null if not set
}


// Connect to the database
$con = mysqli_connect("localhost", "root", "", "lumos_db", "3306");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all products from the database
$sql = "SELECT * FROM tbladvertisement WHERE publish = 1"; // Only fetch published items
$result = mysqli_query($con, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lumos Categories</title>
  <link rel="stylesheet" href="categories page csss.css">
</head>
<body>
 
  <div class="content-wrap">
    <header>
      <a class="header-logo">
    </br>
      <nav>
        <a class="nav-items active" href="user interface.html" target="_blank">Home</a>
        <a class="nav-items" href="user interface.html#about" target="_blank">about us</a>
        <a class="nav-items"  href="user interface.html#services" target="_blank">Services</a>
        <a class="nav-items"  href="contact us page.html" target="_blank">Contact Us</a>
        
       
      </nav>
    </header>
  </div>

 
  
<div class="video-container">
  <video autoplay muted loop playsinline class="background-video">
    <source src="files/lumos render.mp4" type="video/mp4">
    
  </video>
  <div class="video-overlay"></div>
</div>


  <header>
    <h1 style="text-align: center";>What Kind of Services You are Looking For 🤔</h1>
  </header>

  <?php
  echo '<div class="category-container">';
  while ($row = mysqli_fetch_assoc($result)) {
      echo '
      <div class="category-card">
          <img src="' . $row['imagePath'] . '" alt="' . $row['productName'] . '">
          <h2>' . $row['productName'] . '</h2>
          <p>Starting from $' . $row['price'] . '</p>';

          $user_role = $_SESSION['user_role'] ?? 'guest';
          if (!isset($_SESSION['user_id'])) {
            // If not logged in, show sign-in prompt buttons
            echo '
            <button class="add-to-cart-btn" onclick="redirectToSignIn()">Add to Cart</button>
            <button class="order-now-btn" onclick="redirectToSignIn()">Order Now</button>';
        } elseif ($_SESSION['user_role'] !== 'admin') {
            // If logged in as a regular user, show functional buttons
            echo '
            <button class="add-to-cart-btn" onclick="addToCart(event, \'' . htmlspecialchars($row['productName']) . '\', ' . htmlspecialchars($row['price']) . ')">Add to Cart</button>
            <button class="order-now-btn" onclick="orderNow(event, \'' . htmlspecialchars($row['productName']) . '\', ' . htmlspecialchars($row['price']) . ')">Order Now</button>';
        }
      echo '</div>';
  }
  echo '</div>'; // Close the category-container div
?>


</div>

<div id="modal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <img id="modal-image" src="" alt="Category Image">
      <h2 id="modal-title"></h2>
      <p id="modal-price"></p>
    </div>
  </div>

  <!-- Cart Icon and Counter -->
<div class="cart-icon" onclick="toggleCart()">
  <img src="files/cart.png" alt="Cart" />
  <span id="cart-counter">0</span>
</div>

<!-- Cart Modal -->
<!-- Cart Modal -->
<div id="cart-modal" class="cart-modal">
  <div class="cart-modal-content">
    <span class="close-cart" onclick="toggleCart()">&times;</span>
    <h2>Shopping Cart</h2>
    <ul id="cart-items"></ul>
    <p id="cart-total">Total: $0</p>
    <div class="cart-buttons">
      <button class="clear-cart-btn" onclick="clearCart()">Clear</button>
      <button class="checkout-btn" onclick="redirectToCheckout()">Checkout</button>
    </div>
  </div>
</div>

<br>
<br>
<br>

  <section id="footer">
    <div class="section-box">
      <div class="footer-grid">

        <div>
          <h3>Quick Links</h3>

          
          <a href="user interface.html" target="_blank" class="footer-items f1" >Home</a></br>
          <a href="user interface.html" target="_blank"  a class="footer-items f2">about us</a></br>
          <a href="user interface.html" target="_blank" a class="footer-items f3">Services</a></br>
          <a href="contact us page.html" target="_blank" a class="footer-items f4">Contact us</a></br>
        

        </div>

        <div>
          <h3>Contacts</h3>

          <a class="footer-items f1">(076) 2 353 312</a></br>
          <a class="footer-items f2">(076) 2 942 300</a></br>
          <a class="footer-items f3">info@Lumos.org</a></br>
          <a class="footer-items f4">Nallur Junction,Jaffna</a></br>
        </div>

        <div>
          <h3>Socials</h3>

          <a href="user interface.html" target="_blank" class="footer-items f1" >FaceBook</a></br>
          <a href="user interface.html" target="_blank"  a class="footer-items f2">Instagram</a></br>
          <a href="user interface.html" target="_blank" a class="footer-items f3">LinkedIn</a></br>
          <a href="contact us page.html" target="_blank" a class="footer-items f4">Twitter</a></br>
        
        </div>

      </div>

      <p class="copyrights">© LUMOS 2024  |  all rights reserved</p>
    </div>
  </section>

  
</body>



<script src="categories_script.js"></script>
<script>
function redirectToSignIn() {
    alert("You must be signed in to add items to the cart or place an order.");
    window.location.href = "auth.php"; // Change this to your actual sign-in page
}
</script>


</html>