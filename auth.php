<?php
session_start(); 


include 'db.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['signin'])) {
        // Sign-in logic
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Validate inputs
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Email and password are required.";
            header("Location: auth.php"); // Redirect back to the same page
            exit();
        }

        // Fetch user from the database
        try {
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $password === $user['password']) { // Directly compare raw passwords
                // Store user data in session
                $_SESSION['user_id'] = $user['id']; // Store user ID
                $_SESSION['user_name'] = $user['name']; // Store user name
                $_SESSION['user_email'] = $user['email']; // Store email
                $_SESSION['user_role'] = $user['role']; // Store role (e.g., 'admin' or 'user')
                $_SESSION['isLoggedIn'] = true; // Set session variable to indicate user is logged in

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    $_SESSION['success'] = "Welcome, " . $_SESSION['user_name'] . "!";
                    header("Location: admin_dashboard.php"); // Redirect to admin page
                } else {
                    $_SESSION['success'] = "Welcome, " . $_SESSION['user_name'] . "!";
                    header("Location: user_dashboard.php"); // Redirect to user page
                }
                exit();
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header("Location: auth.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: auth.php");
            exit();
        }
    } elseif (isset($_POST['signup'])) {
        // Sign-up logic
        $name = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        // Validate inputs
        if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = "All fields are required.";
            header("Location: auth.php");
            exit();
        }

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: auth.php");
            exit();
        }

        // Insert user into the database
        try {
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'user')");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password); // Store raw password (not recommended for production)
            $stmt->execute();

            $_SESSION['success'] = "Registration successful! Please sign in.";
            header("Location: auth.php");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("Location: auth.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lumos - Sign In / Sign Up</title>
  <link rel="stylesheet" href="sign in css.css">
</head>
<body>

  <nav class="navbar">
    <div class="nav-container">
      <img src="files/png copy.png" alt="Lumos Logo" class="navbar-logo">
      <ul class="nav-links">
        <li><a href="user interface.html">Home</a></li>
        <li><a href="user interface.html#about">About</a></li>
        <li><a href="contact us page.html">Contact</a></li>
        <li><a href="categories page.html">Categories</a></li>
      </ul>
    </div>
  </nav>

  <div class="container">
    <div class="auth-box">
      <img src="files/png copy.png" alt="Lumos Logo" class="company-logo">

      <div class="tabs">
        <button class="tab active" onclick="showForm('sign-in')">Sign In</button>
        <button class="tab" onclick="showForm('sign-up')">Sign Up</button>
      </div>

      <!-- Display error/success messages -->
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
      <?php endif; ?>
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
      <?php endif; ?>

      <!-- Sign In Form -->
      <div id="sign-in" class="form-content active">
        <h2>Sign In</h2>
        <form id="signInForm" action="auth.php" method="POST">
          <label for="email">Email</label>
          <input type="email" id="signInEmail" name="email" placeholder="Enter your email" required>
          
          <label for="password">Password</label>
          <input type="password" id="signInPassword" name="password" placeholder="Enter your password" required>
      
          <button type="submit" name="signin" class="auth-button">Sign In</button>
        </form>
      </div>

      <!-- Sign Up Form -->
      <div id="sign-up" class="form-content">
        <h2>Sign Up</h2>
        <form id="signUpForm" action="auth.php" method="POST">
          <label for="username">Username</label>
          <input type="text" id="signUpUsername" name="username" placeholder="Enter your username" required>
      
          <label for="email">Email</label>
          <input type="email" id="signUpEmail" name="email" placeholder="Enter your email" required>
      
          <label for="password">Password</label>
          <input type="password" id="signUpPassword" name="password" placeholder="Enter your password" required>
      
          <label for="confirm-password">Confirm Password</label>
          <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
      
          <button type="submit" name="signup" class="auth-button">Sign Up</button>
        </form>
      </div>
    </div>
  </div>

  <footer>
    <p>&copy; 2025 Lumos. All rights reserved.</p>
  </footer>

  <script>
    // Function to switch between Sign In and Sign Up forms
    function showForm(formId) {
      document.querySelectorAll('.form-content').forEach((form) => {
        form.classList.remove('active');
      });
      document.querySelectorAll('.tab').forEach((tab) => {
        tab.classList.remove('active');
      });
      document.getElementById(formId).classList.add('active');
      document.querySelector(`button[onclick="showForm('${formId}')"]`).classList.add('active');
    }
    function validateSignIn() {
      const email = document.getElementById("signInEmail").value;
      const password = document.getElementById("signInPassword").value;

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return;
      }
      
      if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return;
      }

      window.location.href = "user_dashboard.php";
    }

    // Validation for Sign Up
    function validateSignUp() {
      const username = document.getElementById("signUpUsername").value;
      const email = document.getElementById("signUpEmail").value;
      const password = document.getElementById("signUpPassword").value;
      const confirmPassword = document.getElementById("confirmPassword").value;

      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      if (username.length < 3) {
        alert("Username must be at least 3 characters long.");
        return;
      }
      
      if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return;
      }
      
      if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return;
      }
      
      if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return;
      }

      window.location.href = "user_dashboard.php";
    }

  </script>
</body>
</html>