<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="style.css">
    <title>EShop</title>
</head>
<body class="align-items-center justify-content-around d-flex">
<form action="<?php echo htmlspecialchars(
  $_SERVER["PHP_SELF"]
); ?>" method="POST">
        <label>Jmeno</label>
        <input class="form-control" type="text" name="username" required/>

        <label>Heslo</label>
        <input class="form-control" type="password" name="password" required/><br>

        <button class="btn btn-light w-100" type="submit">Submit</button>
    </form>

    <footer class="footer mt-auto py-3 bg-dark">
  <div class="container">
    <span class="text-light">Honza</span>
  </div>
</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

<?php
require_once "../script/conn.php";

$user = $pass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $user = test_input($_POST["username"]);
  $pass = test_input($_POST["password"]);

  $sql = "SELECT * FROM users WHERE username='$user'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      if (password_verify($pass, $row["password"])) {
        $token = md5(uniqid($user, true));
        $id = $row["id"];
        $sql = "UPDATE users SET token='$token' WHERE id='$id';";
        $conn->query($sql);
        setcookie("login", $token, time() + 86400 * 30, "/");
        header("Location: " . "./homepage.php");
        exit();
      } else {
        echo "Špatné heslo";
      }
    }
  } else {
    echo "Uživatel nenalezen";
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
