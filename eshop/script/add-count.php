<?php
require_once('./conn.php');
// Retrieve user ID based on provided token
$user_token = $_POST["token"];
$sql = "SELECT id FROM users WHERE token = '$user_token'";
$result = $conn->query($sql);
$random = uniqid();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row["id"];
} else {
    // User not found
    die("User not found");
}

// Retrieve product ID based on provided parameter
$product_id = $_POST["id"];

// Insert product into cart table with user ID and product ID
$sql = "INSERT INTO cart (id_user, id_product) VALUES ($user_id, $product_id)";
if ($conn->query($sql) === TRUE) {
    echo "Product added to cart successfully";
    header('Content-type: text/html; charset=utf-8');
    header('Expires: Mon, 20 Dec 1998 01:00:00 GMT');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').'GMT');
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header("Cache-Control: no-cache, must-revalidate");
} else {
    echo "Error adding product to cart: " . $conn->error;
}

// Close database connection
$conn->close();
?>