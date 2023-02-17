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
    
    $taskId = "";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $taskId = test_input($_POST["id"]);
    
      $sql = "DELETE FROM tasks WHERE id='$taskId'";
        
        if ($conn->query($sql) === TRUE) {
          echo "New record created successfully";
          //header('Location: '."homepage.php");
          exit();
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }
      }
    
    
    $conn->close();   
    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>