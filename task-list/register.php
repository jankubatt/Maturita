<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.scss">

  <title>Login system</title>
</head>

<body>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <label>Jmeno</label>
    <input type="text" name="username" required />

    <label>Heslo</label>
    <input  type="text" name="password" required /><br>

    <button type="submit">Submit</button>
  </form>
</body>

</html>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

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

    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
      header('Location: ' . "index.html");
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