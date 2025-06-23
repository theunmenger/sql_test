<?php
  $email_err = $username_err = "";
  $password_verify_err = "";

  $conn = require_once "db_connect.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="css/inlog.css">
    <meta charset="UTF-8">
  </head>
  <body>
    <div class="container_top">
      <div id="echo_output">
        <?php
          //check if register has been clicker
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $email = $_POST["email"];
            $verify_password = $_POST["verify_password"];

            $name_error = false;

            if (!preg_match("/^[a-zA-Z-0-9_]+$/", $username)) {
              $username_err = "Username can only contain letters, numbers, underscores (_), and hyphens (-)";
              $name_error = true;
            }

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $email_err = "Invalid email";
            } else {
              //look if email already exists
              $check_email = "select email from inlog_gegevens_table where email = '$email'";
              $email_output = $conn->query($check_email);
              $email_check = $email_output->fetch_assoc();

              $pass_ver = false;

              if (password_verify($verify_password, $password)) {
                $pass_ver = true;
              } else {
                $password_verify_err = "Passwords are not the same";
                $pass_ver = false;
              }

              if ($email_check !== null && $email == $email_check["email"]) {
                $email_err = "This email has already been taken";
              } else if ($pass_ver && !$name_error) { //if email doesn't exist and if there are no errors add email into table
                $insert = "INSERT INTO inlog_gegevens_table (username, password, email, admin) VALUES ('$username', '$password', '$email', '0')";
                $conn->query($insert);
                echo "Thank you for registering ". $username. ", you can now close this tab and login to your account.";
              } 
            }
          } 
        ?>
      </div>
      <h2>register</h2>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="email">Email:</label><br>
        <input class="input" type="text" id="email" name="email" placeholder="Example@gmail.com..." required>
        <p class="error"><?php echo $email_err;?></p> <br>
        <label for="username">Username:</label><br>
        <input class="input" type="text" id="username" name="username" placeholder="Username..." required> 
        <p class="error"><?php echo $username_err;?></p><br>
        <label for="password">Password:</label><br>
        <input class="input" type="password" id="password" name="password" placeholder="Password..." required> <br> 
        <label for="password">Verify password:</label><br>
        <input class="input" type="password" id="verify_password" name="verify_password" placeholder="Verify password..." required>
        <p class="error"><?php echo $password_verify_err;?></p> <br>
        <input class="input" type="submit" name="register" value="register">
      </form>

    </div>   
  </body>
</html>