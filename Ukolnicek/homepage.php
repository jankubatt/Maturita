<?php
// Redirect to index.html if user is not logged in
if (!isset($_COOKIE['log'])) {
    header('Location: index.html');
    exit();
}

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user information from the database using the authToken cookie
$authToken = $_COOKIE['log'];
$sql = "SELECT * FROM users WHERE authToken='$authToken'";
$result = $conn->query($sql);

// Display user name if user is found, or an error message if not found
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $id = $row['id'];
    }
} else {
    $username = "User not found.";
}

// Handle form submission for adding a new task
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = test_input($_POST["name"]);
    $content = test_input($_POST["content"]);
    $date = test_input($_POST["date"]);

    // Insert new task into the database
    $sql = "INSERT INTO tasks (name, content, date, user) VALUES ('$name', '$content', '$date', '$id')";
    if ($conn->query($sql) === TRUE) {
        header('Location: homepage.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Helper function to sanitize user input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.scss">
    <title>Tasks</title>
</head>
<body>
    <div id="main">
        <div id="top-panel">
            <button id="add-task-btn">Přidat</button>

            <div class="buttons">
                <button id="login-btn">Login</button>
                <button id="register-btn">Register</button>
                <button id="logout-btn">Logout</button>

                <h1>Vítejte, <?php echo $username; ?></h1>
            </div>
        </div>

        <div id="tasks">
            <?php
                    $sql = "SELECT * FROM tasks WHERE user='$id' ORDER BY date DESC";
                    $taskResult = $conn->query($sql);
                    if ($taskResult->num_rows > 0) {
                        while ($taskRow = $taskResult->fetch_assoc()) {
                            $taskId = $taskRow['id'];
                            echo "<div class='task'><div class='task-name'><div>" . $taskRow["name"] . "</div><div class='task-delete' data-id='$taskId'>x</div></div><div class='task-content'>" . $taskRow["content"] . "</div><div class='task-date'>" . $taskRow["date"] . "</div></div>";
                        }
                    } else {
                        echo "No tasks found.";
                    }
                

            $conn->close();
            ?>
        </div>
    </div>

    <div class="modal">
        <div class="modal-content">
            <h1>Přidat úkol</h1><br/>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="text" id="task-name" name="name" placeholder="Name"><br />
                <textarea row="5" id="task-content" name="content" placeholder="Content"></textarea><br />
                <input type="date" id="task-date" name="date"><br />
                <button type="submit" id="save">Save</button>
            </form>
        </div>
    </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
        $("#add-task-btn").click(() => {
            $(".modal").toggle();
        })

        $("#login-btn").click(() => {
            window.location.href = 'login.php';

        })

        $("#register-btn").click(() => {
            window.location.href = 'register.php';
        })

        $("#logout-btn").click(() => {
            document.cookie = "log=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            window.location.href = 'login.php';

        })

        $(".task-delete").click(function () {
            var taskId = $(this).data('id');
            $.post("delete-task.php", { id: taskId }, function () {
                location.reload();
            });
        });
    })
    </script>
</body>
</html>