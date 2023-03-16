<?php
require_once "./script/conn.php";
if (!isset($_COOKIE["login"])) {
  header("Location: " . "index.html");
  exit();
}
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

    <title>Login system</title>
</head>

<body>
    <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">ESHOP</a>
        <a class="nav-item">Kategorie</a>
        <div class="d-flex">
            <a href="./cart.php">Cart</a>
        </div>
    </div>
    </nav>

    <div class="container d-flex flex-wrap justify-content-center">
        <?php
            $category = $_GET["category"];
            $sql = "SELECT * FROM products WHERE category='$category'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // output data of each row
              while ($row = $result->fetch_assoc()) {
                $timestamp = time();
                $random = uniqid();
                echo '
                  
                    <a href="/category?name='.$row["name"].'">
                    <div class="card m-2" style="width: 18rem;">
                <img src="./product.webp" class="card-img-top" alt="product">
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