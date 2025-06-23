<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $username = $_POST['username'];

        $delete_sql = "DELETE FROM inlog_gegevens_table WHERE email = '$email'";
        $conn->query($delete_sql);
        $delete_notif = "User deleted successfully";
    } else {
        $email = $_GET['email'] ?? '';
        $username = $_GET['username'] ?? '';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="css/inlog.css">
</head>
<body>
    <div class="container_top">
        <h2>Delete user: <?php echo $username?></h2>
        <a href="logged_in.php">Back</a>
        <form method="GET" action="delete_user.php">
            <input class="input_delete" type="submit" name="delete" value="Delete user">
        </form>
    </div>
</body>
</html>