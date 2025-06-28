<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header('location: login.php');
    }

    $conn = require_once "db_connect.php";

    $email_err = $password_err = $deleted_notif = $update_notif = $error = "";

    //fetch email and username
    $email = $_SESSION['email'];
    $get_username = "select username from inlog_gegevens_table where email = '$email'";
    $get_username_output = $conn->query($get_username);
    $username_row = $get_username_output->fetch_assoc();
    if (!isset($username_row['username'])) {
        header('location: login.php');
    } else {
        $username = $username_row['username'];
    }
    $_SESSION['username'] = $username;

    //if logout is clicked (kan denk ik iets veranderen)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_unset();
        session_destroy();
        header('location: index.php');
        die();
    }
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/inlog.css">
        <meta charset="UTF-8">
    </head>
    <body>
        <div class="container_top">
            <h2><?php echo "Hello ". $username?></h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input class="input" type="submit" name="Logout" value="logout">
            </form>
            <form action="change_pass.php">
                <input class="input" type="submit" name="change_pass" value="Change password">
            </form>
            <form action="delete.php">
                <input class="input_delete" type="submit" name="delete_account" value="Delete account">
            </form>
            <?php 
                if (isset($_GET['deleted_user'])) {
                    $deleted_notif = "Succesfully deleted: ". $_GET['deleted_user'];
                }
                if (isset($_GET['update_notif'])) {
                    $update_notif = "Succesfully updated user: ". $_GET['update_notif'];
                }
                if (isset($_GET['error'])) {
                    $error = $_GET['error'];
                }
            ?>
            <p><?php echo $deleted_notif?></p>
            <p><?php echo $update_notif?></p>
            <p class="error"><?php echo $error?></p>
            <table class="table">
                <?php
                    $get_admin_status = "select admin from inlog_gegevens_table where email = '$email'";
                    $get_admin_status_output = $conn->query($get_admin_status);
                    $admin_status_row = $get_admin_status_output->fetch_assoc();
                    if (isset($admin_status_row['admin'])) {
                        if ($admin_status_row['admin'] == 1) {
                            echo "
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Admin status</th>
                                        <th>Delete</th>
                                        <th>Update</th>
                                    </tr>
                                </thead>
                            ";
                            $table_sql = "select * from inlog_gegevens_table";
                            $table_output = $conn->query($table_sql);
                            if ($table_output->num_rows > 0) {
                                while ($row = $table_output->fetch_assoc()) {
                                    echo "
                                        <tbody>
                                            <tr>
                                                <td>". $row["username"]. "</td>
                                                <td>". $row["email"]. "</td>
                                                <td>". $row["admin"]. "</td>
                                                <td>
                                                    <form method='POST' action='delete_user.php' style='display:inline;'>
                                                        <input type='hidden' name='email' value='". htmlspecialchars($row["email"]). "'>
                                                        <input type='hidden' name='username' value='". htmlspecialchars($row["username"]). "'>
                                                        <button class='input_delete_button' type='submit'>Delete</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form method='POST' action='update_user.php' style='display:inline;'>
                                                        <input type='hidden' name='email' value ='".  htmlspecialchars($row["email"]). "'>
                                                        <input type='hidden' name='username' value='". htmlspecialchars($row["username"]). "'>
                                                        <button class='input_b'type='submit'>Update</button>
                                                    </form>
                                                </td>
                                            </tr> 
                                        </tbody>
                                    ";
                                }
                            }
                        }
                    }
                ?>
            </table>
        </div>
    </body>
</html>
