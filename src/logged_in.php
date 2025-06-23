<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header('location: login.php');
    }

    $conn = require_once "db_connect.php";

    $email_err = $password_err = "";

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
            <p><?php echo "Hello ". $username?></p>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input class="input" type="submit" name="Logout" value="logout">
            </form>
            <form action="change_pass.php">
                <input class="input" type="submit" name="change_pass" value="Change password">
            </form>
            <form action="delete.php">
                <input class="input_delete" type="submit" name="delete_account" value="Delete account">
            </form>
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
                                                    <a href='delete_user.php?email=" . urlencode($row["email"]) . "&username=" . urlencode($row["username"]) . "'>Delete</a>
                                                </td>
                                                <td>
                                                    <a href='update_user.php?email=". urlencode($row["email"]) . "&username=" . urlencode($row["username"]) . "&admin" . urlencode($row["admin"]) ."'>Update</a>
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
