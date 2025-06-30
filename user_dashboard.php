<?php
session_start();
include 'db.php'; // Ensure database connection is included

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// Fetch past purchases from database
$stmt = $conn->prepare("SELECT * FROM purchases WHERE user_id = ? ORDER BY purchased_at DESC");
$stmt->execute([$user_id]);
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="user_dashboard_css.css">
</head>
<body>

<nav>
    <div class="logo">
        <h4>LUMOS</h4>
    </div>
    <ul class="nav-links">
        <a href="user interface.html">HOME</a>
        <a href="categories_page.php">CATEGORIES</a>
        <a href="profile.php">CONTACT US</a>
        <a href="auth.php">LOG-OUT</a>
    </ul>
</nav>
<br>
<br>
<br>
<br>


<div class="dashboard-container">
    <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
    <p>Email: <?php echo htmlspecialchars($user_email); ?></p>

    <h3>Your Past Purchases</h3>
    <?php if (count($purchases) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Purchase Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchases as $purchase): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($purchase['product_name']); ?></td>
                        <td>$<?php echo number_format($purchase['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($purchase['purchased_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No past purchases found.</p>
    <?php endif; ?>
</div>

<br>
<br>
<br>
<br>
<br>
<br>
<br>

<footer>
    <p>&copy; 2025 Lumos. All rights reserved.</p>
</footer>

</body>
</html>
