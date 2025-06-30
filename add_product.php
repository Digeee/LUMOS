<?php
session_start(); // Start session at the top

// Database connection
$con = mysqli_connect("localhost", "root", "", "lumos_db", "3306");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize $editRow to null
$editRow = null;

// Fetch advertisement details for editing
if (isset($_GET['edit'])) {
    $id = mysqli_real_escape_string($con, $_GET['edit']);
    $sql = "SELECT * FROM `tbladvertisement` WHERE `id`='$id'";
    $result = mysqli_query($con, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $editRow = mysqli_fetch_assoc($result);
    }
}

// Handle Add, Update, Delete operations
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["btnSubmit"])) {
        // Add Product
        $productname = mysqli_real_escape_string($con, $_POST["txtTitle"]);
        $price = mysqli_real_escape_string($con, $_POST["txtPrice"]);
        $status = isset($_POST["chkPublish"]) ? 1 : 0;

        // File Upload Handling
        $target_dir = "uploads/";
        $image = $target_dir . basename($_FILES["imageFile"]["name"]);
        $imageFileType = strtolower(pathinfo($image, PATHINFO_EXTENSION));

        if ($_FILES["imageFile"]["size"] > 500000000000000) {
            $message = "<p class='error'>File is too large.</p>";
        } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            $message = "<p class='error'>Only JPG, JPEG, PNG & GIF files are allowed.</p>";
        } else {
            if (move_uploaded_file($_FILES["imageFile"]["tmp_name"], $image)) {
                $sql = "INSERT INTO `tbladvertisement` (`productName`, `price`, `publish`, `imagePath`) 
                        VALUES ('$productname','$price', '$status', '$image')";
                if (mysqli_query($con, $sql)) {
                    $message = "<p class='success'>Advertisement uploaded successfully!</p>";
                } else {
                    $message = "<p class='error'>Error: " . mysqli_error($con) . "</p>";
                }
            } else {
                $message = "<p class='error'>Error uploading image.</p>";
            }
        }
    } elseif (isset($_POST["btnUpdate"])) {
        // Update Product
        $id = mysqli_real_escape_string($con, $_POST["id"]);
        $productname = mysqli_real_escape_string($con, $_POST["txtTitle"]);
        $price = mysqli_real_escape_string($con, $_POST["txtPrice"]);
        $status = isset($_POST["chkPublish"]) ? 1 : 0;

        $sql = "UPDATE `tbladvertisement` 
                SET `productName`='$productname', `price`='$price', `publish`='$status' 
                WHERE `id`='$id'";
        if (mysqli_query($con, $sql)) {
            $message = "<p class='success'>Advertisement updated successfully!</p>";
        } else {
            $message = "<p class='error'>Error: " . mysqli_error($con) . "</p>";
        }
    } elseif (isset($_POST["btnDelete"])) {
        // Delete Product
        $id = mysqli_real_escape_string($con, $_POST["id"]);
        $sql = "DELETE FROM `tbladvertisement` WHERE `id`='$id'";
        if (mysqli_query($con, $sql)) {
            $message = "<p class='success'>Advertisement deleted successfully!</p>";
        } else {
            $message = "<p class='error'>Error: " . mysqli_error($con) . "</p>";
        }
    }
}

// Fetch all advertisements for the table
$sql = "SELECT * FROM `tbladvertisement`";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color:rgb(155, 206, 188);
            color: #333;
        }

        nav {
            background: #2c3e50;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        nav .logo h4 {
            color: #fff;
            margin: 0;
            font-size: 24px;
        }

        nav .nav-links a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
            transition: color 0.3s;
        }

        nav .nav-links a:hover {
            color: #1abc9c;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .form-style-5 {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .form-style-5 fieldset {
            border: none;
            margin-bottom: 20px;
        }

        .form-style-5 legend {
            font-size: 18px;
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .form-style-5 input[type="text"],
        .form-style-5 input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-style-5 input[type="checkbox"] {
            margin-right: 10px;
        }

        .form-style-5 input[type="submit"] {
            background: #1abc9c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }

        .form-style-5 input[type="submit"]:hover {
            background: #16a085;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2c3e50;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .actions a {
            color: #1abc9c;
            text-decoration: none;
            margin-right: 10px;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .success {
            color: #27ae60;
            background: #e9f7ef;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .error {
            color: #e74c3c;
            background: #fde8e8;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #2c3e50;
            color: #fff;
            margin-top: 40px;
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">
        <h4>LUMOS</h4>
    </div>
    <ul class="nav-links">
        <a href="user interface.html">Home</a>
        <a href="admin_dashboard.php">My Account</a>
        <a href="categories_page.php">All Items</a> 
        <a href="auth.php">Log-Out</a> 
    </ul>
</nav>

<div class="container">
    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <div class="form-style-5">
        <form action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend><span class="number">1</span> Product Info</legend>
                <input type="hidden" name="id" value="<?php echo isset($editRow['id']) ? $editRow['id'] : ''; ?>">
                <input type="text" name="txtTitle" placeholder="Product Name *" value="<?php echo isset($editRow['productName']) ? $editRow['productName'] : ''; ?>" required>
                <input type="text" name="txtPrice" placeholder="Price *" value="<?php echo isset($editRow['price']) ? $editRow['price'] : ''; ?>" required>
                <input type="file" name="imageFile" <?php echo !isset($editRow) ? 'required' : ''; ?>>
            </fieldset>

            <fieldset>
                <label>
                    Publish the Advertisement:
                    <input type="checkbox" name="chkPublish" <?php echo (isset($editRow['publish']) && $editRow['publish'] == 1) ? 'checked' : ''; ?>>
                </label>
            </fieldset>

            <?php if (isset($editRow)): ?>
                <input type="submit" value="Update Post" name="btnUpdate"/>
            <?php else: ?>
                <input type="submit" value="Add Post" name="btnSubmit"/>
            <?php endif; ?>
        </form>
    </div>

    <!-- Display Advertisements in a Table -->
    <h2>Advertisement List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Publish</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['productName']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><?php echo $row['publish'] ? 'Yes' : 'No'; ?></td>
                    <td><img src="<?php echo $row['imagePath']; ?>" width="50" height="50"></td>
                    <td class="actions">
                        <a href="?edit=<?php echo $row['id']; ?>">Edit</a>
                        <form action="" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="btnDelete" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; 2025 Lumos. All rights reserved.</p>
</footer>

</body>
</html>

<?php
// Close database connection
mysqli_close($con);
?>