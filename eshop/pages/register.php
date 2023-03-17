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

<body class="align-items-center justify-content-around d-flex">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
        <label>Jmeno</label>
        <input class="form-control" type="text" name="username" required />

        <label>Heslo</label>
        <input class="form-control" type="password" name="password" required /><br>

        <button class="btn btn-light w-100" type="submit">Registrovat</button>
    </form>

    <footer class="footer mt-auto py-3 bg-dark">
        <div class="container">
            <span class="text-light">Honza</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
require_once "../script/conn.php";

$user = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user = test_input($_POST["username"]);
	$pass = password_hash(test_input($_POST["password"]), PASSWORD_DEFAULT);

	$sql = "SELECT * FROM users WHERE username='$user'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		echo "Uzivatel jiz existuje";
	} else {
		$sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";

		if ($conn->query($sql) === true) {
			echo "New record created successfully";
			header("Location: " . "../index.html");
			exit();
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}

$conn->close();

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>