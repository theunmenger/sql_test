<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";

    $username_err = $email_err = $update_notif = "";

    $user = $email = "";


    if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update']) && isset($_POST['username']) && isset($_POST['email'])) {
        $user = $_POST['username'];
        $email = $_POST['email'];
    }
    
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $user = $_POST['username'];
        $email = $_POST['email'];
        $new_username = $_POST['new_username'];
        $new_email = $_POST['new_email'];
        $admin = $_POST['admin_status'];

        $email_ver = false;
        $name_ver = false;
        
        if(!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email";
        } else {
            $email_ver = true;
        }

        if (!preg_match("/^[a-zA-Z-0-9_]+$/", $user)) {
            $username_err = "Username can only contain letters, numbers, underscores (_), and hyphens (-)";
        } else {
            $name_ver = true;
        }
            
        if ($name_ver && $email_ver) {
            echo "new_user: ". $new_username. " new_email: ". $new_email. " old_user: ". $user. " old_email: ". $email. " admin status: ". $admin;
        }

        if (!empty($_POST['new_username'])) {
            $update_username = "update inlog_gegevens_table set username = '$new_username' where email = '$email'";
        }

        if (!empty($_POST['new_email'])) {
            $update_email = "update inlog_gegevens_table set email = '$new_email' where email = '$email'";
        }

        if (!empty($_POST['admin_status'])) {
            $update_admin = "update inlog_gegevens_table set admin = '$admin' where email = '$email'";
        }
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
        <p><?php echo $update_notif;?></p>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($user); ?>">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <label for="new_email">New mail:</label><br>
            <input class="input" type="text" id="new_email" name="new_email" placeholder="Example@gmail.com...">
            <p class="error"><?php echo $email_err;?></p> <br>
            <label for="new_username">New username:</label><br>
            <input class="input" type="text" id="new_username" name="new_username" placeholder="Username..."> 
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