<?php
require_once "../script/conn.php";
if (!isset($_COOKIE["login"])) {
  header("Location: " . "index.html");
  exit();
}

$user = "";
$products = [];
?>

<?php
$token = $_COOKIE["login"];
$sql = "SELECT * FROM users WHERE token='$token'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while ($row = $result->fetch_assoc()) {
    $user = $row;
    $id = $row["id"];

    $sql = "SELECT products.* FROM cart JOIN products ON cart.id_product=products.id WHERE id_user='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        array_push($products, $row);
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            $sql = "SELECT COUNT(id) AS count FROM cart WHERE id_user='$id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // output data of each row
              while ($row = $result->fetch_assoc()) { 
                echo $row["count"];
              }}?>
        </div>
    </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Order</h1>
                        </div>
                        <hr>
                        <p><b>No. of items:</b> <?php echo count(
                          $products
                        ); ?></p>
                        <p><b>Price:</b> <?php
                        $price = 0;
                        foreach ($products as $value) {
                          $price += $value["price"];
                        }
                        echo $price;
                        ?>$</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Count</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $count = 1;
                        $prev_id = 0;
                        $prev_name = "";
                        $prev_price = "";
                        $prev_count = 0;
                        
                        foreach ($products as $value) {
                            // check if this item has the same name and price as the previous item
                            if ($value["name"] == $prev_name && $value["price"] == $prev_price) {
                                // increment the count of the previous item
                                $prev_count++;
                            } else {
                                // output the previous item, if it exists
                                if ($prev_name != "") {
                                    echo "<tr><th>" . $count . "</th><td>" . $prev_name . "</td><td>" . $prev_price . "</td><td>" . $prev_count . "<a href='#' class='add-to-cart' data-id=".$prev_id." data-token=".$token.">+</a></td><td><img height='100' src='../img/product.webp' alt='product'></td></tr>";
                                    $count++;
                                }
                        
                                // save the current item as the previous item
                                $prev_id = $value["id"];
                                $prev_name = $value["name"];
                                $prev_price = $value["price"];
                                $prev_count = 1;
                            }
                        }
                        
                        // output the last item
                        if ($prev_name != "") {
                            echo "<tr><th>" . $count . "</th><td>" . $prev_name . "</td><td>" . $prev_price . "</td><td>" . $prev_count . "<a href='#' class='add-to-cart' data-id=".$prev_id." data-token=".$token.">+</a></td><td><img height='100' src='../img/product.webp' alt='product'></td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


    </div>

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
      url: "../script/add-count.php",
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
