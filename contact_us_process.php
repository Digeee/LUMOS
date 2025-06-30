<?php
// Connect to MySQL
$con = mysqli_connect("localhost", "root", "", "lumos_db", "3306");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Insert data into database
    $sql = "INSERT INTO contact_messages (name, email, subject, message) 
            VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Message sent successfully!'); window.location.href='contact us page.html';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
// close connection
mysqli_close()