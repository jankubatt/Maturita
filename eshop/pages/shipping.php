<?php
require_once "../script/conn.php";
if (!isset($_COOKIE["login"])) {
  header("Location: " . "index.html");
  exit();
}

$user = "";
$id = 0;
$products = [];
$conn->query("SET NAMES 'utf8'");
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

<body class="d-flex flex-column h-100" style="height: 100vh !important;">
	<nav class="navbar navbar-light bg-light">
		<div class="container-fluid">
			<a class="navbar-brand">EShop</a>
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a href="./homepage.php" class="nav-link">Kategorie</a>
				</li>
			</ul>
			
			<div>
				<a class="btn btn-light" href="./cart.php">
					<i class="fa-solid fa-cart-shopping"></i>
					<span class="badge rounded-pill bg-dark">
						<?php
							$sql = "SELECT COUNT(id) AS count FROM cart WHERE id_user='$id'";
							$result = $conn->query($sql);

							if ($result->num_rows > 0) {
								// output data of each row
								while ($row = $result->fetch_assoc()) {
									echo $row["count"];
								}
							}
						?>
					</span>
				</a>
			</div>
		</div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Objednávka</h1>
                        </div>
                        <hr>
                        <p><b>Počet věcí:</b> <?php echo count($products); ?></p>
                        <p><b>Cena:</b> <?php $price = 0; foreach ($products as $value) {$price += $value["price"];}echo $price;?>Kč</p>
                        <small><?php echo $price + ($price * 0.21) ?>Kč s DPH</small>
                    </div>
                </div>

            </div>
            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Jméno a příjmení</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ulice</label>
                        <input type="text" class="form-control" name="street" required>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Číslo domu</label>
                                <input type="text" class="form-control" name="house" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">PSČ</label>
                                <input type="text" class="form-control" name="psc" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="shipping">
                        <label class="form-check-label">Vyzvednout na prodejně</label>
                    </div>

                    <button type="submit" class="btn btn-dark w-100">Pokračovat na shrnutí</button>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-dark">
  		<div class="container">
    		<span class="text-light">Honza</span>
  		</div>
	</footer>

	<script src="https://kit.fontawesome.com/848da1e5f7.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>

</html>

<?php
require_once "../script/conn.php";

$name = $street = $house = $psc = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = test_input($_POST["name"]);
	$street = test_input($_POST["street"]);
	$house = test_input($_POST["house"]);
	$psc = test_input($_POST["psc"]);
    $shipping = $_POST["shipping"];
    if ($shipping == "on") {$shipping = true;} else {$shipping = false;}
    $price_tax = $price + ($price * 0.21);
    $token = rand(100000, 999999);

	$sql = "INSERT INTO orders (id, name, street, house, psc, shipping, id_user, price, price_tax) VALUES ('$token', '$name', '$street', '$house', '$psc', '$shipping', '$id', '$price', '$price_tax')";
    if ($conn->query($sql) === true) {
        header("Location: " . "./summary.php?order=" . $token);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<?php $conn->close();
?>
