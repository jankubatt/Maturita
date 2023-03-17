<?php

require_once "conn.php";

$id_product = $_POST["id"];
$token = $_POST["token"];
$random = uniqid();

header("Cache-Control: no-cache, must-revalidate");
header('Content-type: text/html; charset=utf-8');
header('Expires: Mon, 20 Dec 1998 01:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

$sql = "SELECT id FROM users WHERE token=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row["id"];
    $sql = "INSERT INTO cart (id_user, id_product) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $id_product);
    if ($stmt->execute()) {
        echo "New record created successfully";
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$conn->close();

?>
