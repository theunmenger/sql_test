<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header('location: login.php');
    }
    $conn = require_once "db_connect.php";

    $email_err = $password_err = $password_verify_err = "";
    $delete_notif = "";
    $email = $_SESSION['email'];
        
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $pass_ver = $_POST["verify_password"];
        $password = $_POST["password"];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email";
        } else {
            //get password from table
            $check_password = "select password from inlog_gegevens_table where email = '$email'";

            $password_output = $conn->query($check_password);
            $password_check = $password_output->fetch_assoc();

            $correct_password = false;
            $correct_verify_password = false;

            if ($password_check !== null && password_verify($password, $password_check["password"])) {
                $correct_password = true;
            } else {
                $password_err = "Incorrect password";
                $correct_password = false;
            }

            if ($correct_password && $password == $pass_ver) {
                $correct_verify_password = true;
            } else {
                $password_verify_err = "Passwords are not the same";
                $correct_password = false;
                $correct_verify_password = false;
            }

            //sql statement delete account
            $delete_sql = "delete from inlog_gegevens_table where email = '$email'";

            

            if ($correct_password && $correct_verify_password) {
                $conn->query($delete_sql);
                $delete_notif = "Account deleted succesfully";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="css/inlog.css">
</head>
<body>
    <div class="container_top">
        <h2 style="color:red;">Delete account</h2>
        <a href="logged_in.php">Back</a>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');">
            <label for="password">Password:</label><br>
            <input class="input" type="password" id="password" name="password" placeholder="Password..." require>
            <p class="error"><?php echo $password_err;?></p> <br>
            <label for="password">Verify password:</label><br>
            <input class="input" type="password" id="verify_password" name="verify_password" placeholder="Verify password..." require>
            <p class="error"><?php echo $password_verify_err;?></p> <br>
            <input class="input_delete" type="submit" name="delete" value="Delete">
        </form>
        <p class="error"><?php echo $delete_notif;?></p>
    </div>
</body>
</html>