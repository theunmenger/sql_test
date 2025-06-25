<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $username = $_POST['username'];

        $system = $conn->prepare("delete from inlog_gegevens_table where email = ?");
        $system->bind_param("s", $email);
        $system->execute();
        $system->close();

        header("Location: logged_in.php?deleted_user=" . urlencode($username));
        exit;
    }
?>
