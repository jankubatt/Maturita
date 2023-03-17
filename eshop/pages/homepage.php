<?php
require_once "../script/conn.php";
if (!isset($_COOKIE["login"])) {
  header("Location: " . "index.html");
  exit();
}

$token = $_COOKIE["login"];
$id_user = 69;
$sql = "SELECT id FROM users WHERE token='$token'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // output data of each row
              while ($row = $result->fetch_assoc()) {
$id_user = $row["id"];

              }}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>EShop</title>
</head>

<body>
    <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">EShop</a>
        <a href="./homepage.php" class="nav-item">Kategorie</a>
        <div class="d-flex">
            <a href="./cart.php">Cart</a><?php 
            $sql = "SELECT COUNT(id) AS count FROM cart WHERE id_user='$id_user'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // output data of each row
              while ($row = $result->fetch_assoc()) { 
                echo $row["count"];
              }}?>
        </div>
    </div>
    </nav>

    <div class="container d-flex flex-wrap justify-content-center">
        <?php
            $sql = "SELECT * FROM categories ORDER BY name ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // output data of each row
              while ($row = $result->fetch_assoc()) {
                $timestamp = time();
                $random = uniqid();
                echo '
                  
                    <a href="./products.php?category='.$row["id"].'">
                    <div class="card m-2" style="width: 18rem;">
                <img src="../img/product.webp" class="card-img-top" alt="product">
                <div class="card-body">
                    <h5 class="card-title">' .
                  $row["name"] .
                  '</h5>
                    <div class="d-flex justify-content-between">
                    </div>
                    
                </div>
                </div>
                </a>
                    ';
              }
            }
            ?>

    </div>

    <div class="footer h-100 bg-dark">
        <p>Ahoj</p>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
</body>

</html>


<?php $conn->close();
?>