<?php
if(!isset($_COOKIE['log'])) {
    header('Location: '."index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <title>Login system</title>
</head>
<body class="align-items-center d-flex">
    <div class="w-100 d-flex text-center justify-content-center flex-column">
    <h1 class="text-center">Jste přihlášen jako</h1>
    <?php
    $user = $pass = ""; 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

        $token = $_COOKIE['log'];
         $sql = "SELECT * FROM users WHERE authToken='$token'";
         $result = $conn->query($sql);
     
         if ($result->num_rows > 0) {
         // output data of each row
         while($row = $result->fetch_assoc()) {
            echo "<h2 class='text-center'>".$row['username']."</h2>";
         }
        }
    ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

