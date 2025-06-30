<?php
session_start();
include 'db.php'; // Database connection

// Ensure only the admin can access this page


// Handle User Deletion
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $_SESSION['success'] = "User deleted successfully!";
    header("Location: manage_users.php");
    exit();
}

// Handle User Addition
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']); 
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $password, $role]);
    $_SESSION['success'] = "User added successfully!";
    header("Location: manage_users.php");
    exit();
}

// Fetch all users from the database
$stmt = $conn->prepare("SELECT id, name, email, role FROM users ORDER BY id DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Users</title>
    <link rel="stylesheet" href="manage_users.css"> <!-- External CSS -->
</head>
<nav class="navbar">
    <div class="nav-container">
      <img src="files/png copy.png" alt="Lumos Logo" class="navbar-logo">
      <ul class="nav-links">
        <li><a href="user interface.html">HOME</a></li>
        <li><a href="admin_dashboard.html>ADMIN PAGE</a></li>
        <li><a href="contact us page.html"></a></li>
        <li><a href="categories page.html">Categories</a></li>
      </ul>
    </div>
  </nav>
<body>



<div class="container">
    <h2>Admin Dashboard - Manage Users</h2>

    <!-- Display Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php endif; ?>

    <!-- User Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <a class="delete-btn" href="manage_users.php?delete=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add User Form -->
    <h3>Add New User</h3>
    <form action="manage_users.php" method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit">Add User</button>
    </form>

    <a href="sign in page.html" class="logout-btn">Logout</a>
</div>

</body>

    <footer>
        <p>&copy; 2025 Lumos. All rights reserved.</p>
    </footer>

</html>
