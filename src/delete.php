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
        $email = $_POST["email"];

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email";
        } else {
            //get email from table
            $check_email = "select email from inlog_gegevens_table where email = '$email'";
            //get password from table
            $check_password = "select password from inlog_gegevens_table where email = '$email'";

            $email_output = $conn->query($check_email);
            $email_check = $email_output->fetch_assoc();
            $password_output = $conn->query($check_password);
            $password_check = $password_output->fetch_assoc();

            $correct_email = false;
            $correct_password = false;
            $correct_verify_password = false;

            if ($email_check !== null && $email == $email_check["email"]) { 
                $correct_email = true;
            } else {
                $email_err = "Incorrect email";
            }
            if ($password_check !== null && password_verify($password, $password_check["password"])) {
                $correct_password = true;
            } else {
                $password_err = "Incorrect password";
                $correct_email = false;
                $correct_password = false;
            }

            if ($correct_password && $password == $pass_ver) {
                $correct_verify_password = true;
            } else {
                $password_verify_err = "Passwords are not the same";
                $correct_password = false;
                $correct_email = false;
                $correct_verify_password = false;
            }

            //sql statement delete account
            $delete_sql = "delete from inlog_gegevens_table where email = '$email'";

            

            if ($check_email && $correct_password && $correct_verify_password) {
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
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="email">Email:</label><br>
            <input class="input" type="text" id="email" name="email" placeholder="Example@gmail.com..." require>
            <p class="error"><?php echo $email_err;?></p> <br>
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