<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";
?>