<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
</head>
<body>
  <form action="index.php" method="post">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" placeholder="Username..."> <br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" placeholder="password..."> <br>
    <input type="submit" value="submit">
  </form>


  <?php
    $username = $_POST["username"];
    $password = $_POST["password"];

    echo $username;
    echo $password;
  ?>
</body>

</html>