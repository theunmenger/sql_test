<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";

    $password_err = $password_verify_err = $update_notif = "";

    $email = $_SESSION['email'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $check_password = "select password from inlog_gegevens_table where email = '$email'";
        $password_output = $conn->query($check_password);
        $password_check = $password_output->fetch_assoc();

        $password = $_POST["password"];
        $verify_password = $_POST["verify_password"];
        $new_password = password_hash($_POST["new_pass"], PASSWORD_DEFAULT);

        if ($verify_password == $password) {
            $pass_ver = true;
        } else {
            $password_verify_err = "Passwords are not the same";
            $pass_ver = false;
        }

        if ($password_check !== null && password_verify($password, $password_check["password"])) {
            $correct_password = true;
        } else {
            $password_err = "Incorrect password";
            $correct_password = false;
        }        

        if ($correct_password && $pass_ver) {
            $update_sql = "update inlog_gegevens_table set password = '$new_password' where email = '$email'";
            $conn->query($update_sql);
            $update_notif = "Succesfully updated password";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change_password</title>
    <link rel="stylesheet" type="text/css" href="css/inlog.css">
</head>
<body>
    <div class="container_top">
        <h2>Change password</h2>
        <a href="logged_in.php">Back</a>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="password">Password:</label><br>
            <input class="input" type="password" id="password" name="password" placeholder="Password..." required>
            <p class="error"><?php echo $password_err;?></p> <br>
            <label for="password">Verify password:</label><br>
            <input class="input" type="password" id="verify_password" name="verify_password" placeholder="Verify password..." required>
            <p class="error"><?php echo $password_verify_err;?></p> <br>
            <label for="new_pass">New password:</label><br>
            <input class="input" type="password" id="new_pass" name="new_pass" placeholder="New password..." required required minlength="6"><br>
            <input class="input" type="submit" name="change_pass" value="Change password">
        </form>
        <h3><?php echo $update_notif?></h3>
    </div>
</body>
</html>