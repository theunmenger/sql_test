<?php
  $servername = "mysql";
  $server_username = "root";
  $server_password = "password";
  $database = "inlog_gegevens";

  //connect
  $conn = new mysqli($servername, $server_username, $server_password, $database);
  //check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="css/inlog.css">
    <meta charset="UTF-8">
  </head>
  <body>
    <div id="form_div">
      <h2>register</h2>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="username">Username:</label><br>
        <input class="input" type="text" id="username" name="username" placeholder="Username..."> <br>
        <label for="password">Password:</label><br>
        <input class="input" type="password" id="password" name="password" placeholder="password..."> <br> 
        <label for="email">Email:</label><br>
        <input class="input" type="text" id="email" name="email" placeholder="Example@gmail.com..."><br>
        <input class="input" type="submit" name="register" value="register">
      </form>
      <div id="echo_output">
        <?php
          //check if register has been clicker
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = trim($_POST["username"]);
            $password = $_POST["password"];
            $email = $_POST["email"];

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              echo "Invalid email";
            } else {
              //look if email already exists
              $check_email = "select email from inlog_gegevens_table where email = '$email'";
              $email_output = $conn->query($check_email);
              $row = $email_output->fetch_assoc();

              if ($row !== null && $email == $row["email"]) {
                echo "This email has already been taken";
              } else {  //if email doesn't exist add email into table
                $insert = "INSERT INTO inlog_gegevens_table (username, password, email) VALUES ('$username', '$password', '$email')";
                $conn->query($insert);
                echo "Thank you for registering ". $username. ", you can now close this tab and login to your account.";
              }  
            }
          } 
        ?>
      </div>
    </div>   
  </body>
</html>