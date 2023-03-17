<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

header('Content-type: text/html; charset=utf-8');
header('Expires: Mon, 20 Dec 1998 01:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
?>
