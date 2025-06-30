<?php
session_start();
include 'db.php'; // Ensure database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];

    // Check if product_name and price exist and are arrays
    if (isset($_POST['product_name']) && is_array($_POST['product_name']) &&
        isset($_POST['price']) && is_array($_POST['price'])) {

        try {
            // Begin transaction for multiple inserts
            $conn->beginTransaction();

            // Loop through all products
            for ($i = 0; $i < count($_POST['product_name']); $i++) {
                $product_name = $_POST['product_name'][$i] ?? '';
                $price = $_POST['price'][$i] ?? '';

                // Validate each input
                if (!empty($product_name) && !empty($price)) {
                    $stmt = $conn->prepare("INSERT INTO purchases (user_id, product_name, price) VALUES (?, ?, ?)");
                    $stmt->execute([$user_id, $product_name, $price]);
                }
            }

            // Commit transaction
            $conn->commit();

            // Redirect to dashboard with success message
            header("Location: user_dashboard.php?success=1");
            exit();
        } catch (PDOException $e) {
            $conn->rollBack(); // Rollback in case of an error
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Error: Missing product details.";
        exit();
    }
} else {
    echo "Invalid request.";
}
?>
