<?php

require_once "conn.php";

$id_product = $_GET["id"];
$token = $_GET["token"];
$random = uniqid();

header("Cache-Control: no-cache, must-revalidate");
header("Location: ../homepage.php?timestamp=" . time() . "&rnd=".$random."");

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
