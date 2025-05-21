<html>
    <body>
        <?php
            $username = $_POST["username"];
            $password = $_POST["password"];

            if ($username == "username" && $password == "password") {
                echo "login succesfull";
            } else {
                echo "wrong username or password";
            }
        ?>
    </body>
</html>