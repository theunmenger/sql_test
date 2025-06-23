<?php
    session_start();

    $conn = require_once "db_connect.php";

    $email_err = $password_err = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $password = $_POST["password"];
        $email = $_POST["email"];
        
        //validate email
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

            if ($check_email && $correct_password) {
                $_SESSION['email'] = $email;
                header('location: logged_in.php');
                die();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="css/inlog.css">
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="container_top">
            <h2>Login</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="email">Email:</label><br>
                <input class="input" type="text" id="email" name="email" placeholder="Example@gmail.com..." require>
                <p class="error"><?php echo $email_err;?></p> <br>
                <label for="password">Password:</label><br>
                <input class="input" type="password" id="password" name="password" placeholder="Password..." require>
                <p class="error"><?php echo $password_err;?></p> <br>
                <input class="input" type="submit" name="login" value="Login">
            </form>
            <a href="index.php">Back</a>
        </div>
    </body>
</html>
