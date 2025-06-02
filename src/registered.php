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

    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $insert = "INSERT INTO inlog_gegevens_table (username, password, email) VALUES ('$username', '$password', '$email')";
    $conn->query($insert);
?>