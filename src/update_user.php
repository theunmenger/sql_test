<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";

    $username_err = $email_err = $update_notif = "";

    $user = $_POST['username'];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
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
        <h2>Update user: <?php echo $user?></h2>
        <a href="logged_in.php">Back</a>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="new_email">New mail:</label><br>
            <input class="input" type="text" id="new_email" name="new_email" placeholder="Example@gmail.com..." required>
            <p class="error"><?php echo $email_err;?></p> <br>
            <label for="new_username">New username:</label><br>
            <input class="input" type="text" id="new_username" name="new_username" placeholder="Username..." required> 
            <p class="error"><?php echo $username_err;?></p><br>
            <p>Admin status</p>
            <input type="radio" id="yes" name="admin_status" value="1">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="admin_status" value="0">
            <label for="no">No</label><br><br>
            <input class="input" type="submit" name="update" value="Update">
        </form>
    </div>
</body>
</html>