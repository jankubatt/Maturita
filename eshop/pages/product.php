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

<body class="d-flex flex-column h-100" style="height: 100vh !important;">
<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
     
      <a class="navbar-brand">EShop</a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
        <a href="./homepage.php" class="nav-link">Kategorie</a>

        </li>
            </ul>
        
        <div class="">
            <a class="btn btn-light" href="./cart.php">
            
  <i class="fa-solid fa-cart-shopping">

            
            </i>
            <span class="badge rounded-pill bg-dark"><?php 
            $sql = "SELECT COUNT(id) AS count FROM cart WHERE id_user='$id_user'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // output data of each row
              while ($row = $result->fetch_assoc()) { 
                echo $row["count"];
              }}?></span>
          </a>
            
        </div>
        
    </div>
    </nav>

    <div class="container d-flex flex-wrap justify-content-center">
        <?php
            $category = $_GET["category"];
            $product = $_GET["product"];
            $sql = "SELECT products.*, categories.name AS c_name FROM products JOIN categories ON products.category = categories.id WHERE products.id='$product'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // output data of each row
              while ($row = $result->fetch_assoc()) {
                $timestamp = time();
                $random = uniqid();
                echo '
                <a href="./homepage.php" class="nav-item">Kategorie</a> / <a href="./products.php?category='.$category.'">'.$row["c_name"].'</a>
                aha toto je produkt: '.$row["name"].'<br/>
                <a href="#" class="add-to-cart" data-id='.$row["id"].' data-token='.$_COOKIE["login"].'>Do kosiku</a>';
              }
            }
            ?>

    </div>

    <footer class="footer mt-auto py-3 bg-dark">
  <div class="container">
    <span class="text-light">Honza</span>
  </div>
</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
  $(".add-to-cart").click(function(e) {
    e.preventDefault();
    var id = $(this).data("id");
    var token = $(this).data("token");
    $.ajax({
      url: "../script/add-to-cart.php",
      method: "POST",
      data: { id: id, token: token },
      success: function() {
        // Refresh the page to update the cart
        location.reload();
      }
    });
  });
});
</script>
</body>

</html>


<?php $conn->close();
?>