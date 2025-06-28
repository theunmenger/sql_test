<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $new_username = $_POST['new_username'];

        if (!preg_match("/^[a-zA-Z-0-9_]+$/", $new_username)) {
            $msg = "Username can only contain letters, numbers, underscores (_), and hyphens (-)";
            header("location: logged_in.php?error=". urlencode($msg));
            exit;
        } else {
            $system = $conn->prepare("update inlog_gegevens_table set username = ? where email = ?");
            $system->bind_param("ss", $new_username, $email);
            $system->execute();
            $system->close();

            header("Location: logged_in.php?update_notif=" . urlencode($email));
            exit;
        }

        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>