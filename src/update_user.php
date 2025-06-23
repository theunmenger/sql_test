<?php 
    session_start();
    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";

    $email = $_GET["email"];

    
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
        <table class="table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Admin status</th>
                </tr>
            </thead>
            <?php
                $table_sql = "select * from inlog_gegevens_table where email = '$email'";
                $table_output = $conn->query($table_sql);
                if ($table_output->num_rows > 0) {
                    while ($row = $table_output->fetch_assoc()) {
                        echo "
                            <tbody>
                                <tr>
                                    <td>". $row["username"]. "</td>
                                    <td>". $row["email"]. "</td>
                                    <td>". $row["admin"]. "</td>
                                </tr> 
                            </tbody>
                        ";
                    }
                }
            ?>
        </table>
        <form>
            <label for="email">Email:</label><br>
            <input class="input" type="text" id="email" name="email" placeholder="Example@gmail.com..." required>
            <p class="error"><?php echo $email_err;?></p> <br>
            <label for="username">Username:</label><br>
            <input class="input" type="text" id="username" name="username" placeholder="Username..." required> 
            <p class="error"><?php echo $username_err;?></p><br>
        </form>
    </div>
</body>
</html>