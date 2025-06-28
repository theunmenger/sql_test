<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('location: login.php');
        die();
    }

    $conn = require_once "db_connect.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $new_email = $_POST['new_email'];
        $email_error_1 = true;
        $email_error_2 = true;

        $check_email = $conn->prepare("select email from inlog_gegevens_table where email = ?");
        $check_email->bind_param("s", $new_email);
        $check_email->execute();
        
        $result = $check_email->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $found_email = $row['email'];
        } else {
            $found_email = null;
        }
        $check_email->close();
        
        if(!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Updated email is invalid";
            header("location: logged_in.php?error=". urlencode($msg));
        } else {
            $email_error_2 = false;
        }

        if ($found_email == $new_email) {
            $msg = "Updated email has already been taken";
            header("location: logged_in.php?error=". urlencode($msg));
        } else {
            $email_error_1 = false;
        }

        if (!$email_error_1 && !$email_error_2) {
            $system = $conn->prepare("update inlog_gegevens_table set email = ? where email = ?");
            $system->bind_param("ss", $new_email, $email);
            $system->execute();
            $system->close();

            header("Location: logged_in.php?update_notif=" . urlencode($new_email));
            exit;
        }
    }
?>