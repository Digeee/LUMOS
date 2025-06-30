<?php
// Start the session
session_start();

// Check if the user is logged in, if not redirect to the login page

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="admin dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <!-- Banner Section -->
    <div class="banner">
        <img src="files/admin_banner.jpg" alt="Banner Image">
        <div class="banner-text">
            <h1>WELCOME BACK ADMIN</h1>
         
        </div>
    </div>
    <br>
    <br>
    <br>

    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="user interface.html"><i class="fas fa-home"></i> HOME</a></li>
            <li><a href="manage_users.php"><i class="fas fa-tachometer-alt"></i> USERS</a></li>
            <li><a href="categories_page.php"><i class="fas fa-info-circle"></i> CATEGORIES</a></li>
            <li><a href="auth.php"><i class="fas fa-sign-out-alt"></i> LOGOUT</a></li>
        </ul>
    </nav>
    <br>
    <br>

    <!-- Main Content -->
    <main>
        <div class="image-grid">
            <div class="item">
                <img src="files/lumos 1 copy.jpg" alt="Image 1">
                <a href="user interface.html"><button>HOME</button></a>
            </div>
            <div class="item">
                <img src="files/add.jpg" alt="Image 2">
                <a href="add_product.php"><button>MANAGE CATEGORIES</button></a>
            </div>
            <div class="item">
                <img src="files/deletes.jpg" alt="Image 3">
                <a href="manage_users.php"><button>MANAGE USERS</button></a>
            </div>
            <div class="item">
                <img src="files/delete.jpg" alt="Image 4">
                <a href="admin_messages.php"><button>USER MESSAGES</button></a>
            </div>
            <div class="item">
                <img src="files/logout.jpg" alt="Image 5">
                <a href="auth.php"><button>LOGOUT</button></a>
            </div>
            
        </div>
    </main>
    <br>
    <br>
    <br>
   



    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Lumos. All rights reserved.</p>
    </footer>

    <!-- JavaScript for Animations -->
    <script>
        $(document).ready(function() {
            // Fade in effect for the banner
            $('.banner').hide().fadeIn(1500);

            // Hover effect for grid items
            $('.item').hover(
                function() {
                    $(this).css('transform', 'scale(1.05)');
                },
                function() {
                    $(this).css('transform', 'scale(1)');
                }
            );
        });
    </script>
</body>
</html>