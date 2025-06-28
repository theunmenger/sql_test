<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $admin = $_POST['admin_status'];

        $system = $conn->prepare("update inlog_gegevens_table set admin = ? where email = ?");
        $system->bind_param("is", $admin, $email);
        $system->execute();
        $system->close();

        header("Location: logged_in.php?update_notif=" . urlencode($email));
        exit;
    }
?>